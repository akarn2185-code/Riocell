<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->message;
        $sessionId = $request->session_id ?? Str::uuid()->toString();
        $userId = Auth::id();

        ChatLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'user',
            'message' => $userMessage
        ]);

        $aiResponse = $this->getGeminiResponse($userMessage, $sessionId);

        ChatLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'assistant',
            'message' => $aiResponse
        ]);

        return response()->json([
            'success' => true,
            'message' => $aiResponse,
            'session_id' => $sessionId
        ]);
    }

    private function getGeminiResponse($message, $sessionId)
    {
        $apiKey = env('GEMINI_API_KEY', 'AIzaSyBaP10lv6EKWdkox7bELVm30jJmCUAiEYw');
        $modelName = 'gemini-1.5-flash'; 

        try {
            $systemPrompt = $this->getSystemPrompt();
            $finalMessage = "INSTRUKSI SISTEM:\n" . $systemPrompt . "\n\nCHAT PELANGGAN:\n" . $message;

            $contents = [
                [
                    'role' => 'user',
                    'parts' => [['text' => $finalMessage]]
                ]
            ];

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, ['contents' => $contents]);

            if ($response->status() === 404) {
                $modelsReq = Http::withoutVerifying()->get("https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}");
                if ($modelsReq->successful()) {
                    $availableModels = $modelsReq->json()['models'] ?? [];
                    foreach ($availableModels as $m) {
                        $methods = $m['supportedGenerationMethods'] ?? [];
                        if (in_array('generateContent', $methods) && strpos($m['name'], 'gemini') !== false) {
                            $modelName = str_replace('models/', '', $m['name']);
                            break;
                        }
                    }
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";
                    $response = Http::withoutVerifying()->timeout(15)->post($url, ['contents' => $contents]);
                }
            }

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            return $this->getTemplateResponse($message);

        } catch (\Exception $e) {
            return $this->getTemplateResponse($message);
        }
    }

    private function getSystemPrompt()
    {
        $products = Product::where('is_active', true)->get();
        $productList = "";
        if($products->count() > 0) {
            foreach($products as $p) {
                $productList .= "- {$p->name}: Rp " . number_format($p->sell_price, 0, ',', '.') . "\n";
            }
        }

        return "Kamu adalah CS virtual sekaligus Tech Support yang pintar, ramah, penuh empati, dan solutif untuk konter 'Rio Cell'.
Gunakan emoji yang sesuai agar obrolan terlihat hidup dan santai.

DATA TOKO RIO CELL:
- Buka: 08:00 - 21:00 WIB
- Alamat: Jl. Soekarno-Hatta (Seberang PO Bus Primajasa), Babakan Ciparay, Kota Bandung
- WA: 0831-1318-8047
- Layanan: Pulsa, Paket Data, E-Wallet, Aksesoris HP, Tukar Saldo E-wallet ke Tunai.

DAFTAR PRODUK KAMI:
{$productList}

TUGAS UTAMA & CARA MENANGANI KELUHAN (SANGAT PENTING):
1. JAWAB SEMUA PERTANYAAN: Kamu bebas menjawab pertanyaan umum, curhatan, atau keluhan teknis pelanggan.
2. KELUHAN SINYAL/INTERNET LEMOT: Berikan tips troubleshooting praktis (Contoh: saranin on/off mode pesawat, restart HP, cek sisa kuota, atau setting APN).
3. KELUHAN PULSA/DATA BELUM MASUK: Tunjukkan empati. Jelaskan terkadang ada delay provider 5-15 menit. Jika sudah lama, suruh hubungi WhatsApp Owner di 0831-1318-8047 dengan melampirkan Order ID.
4. KELUHAN HP RUSAK/PANAS: Berikan saran masuk akal, lalu tawarkan barangkali butuh beli kabel charger atau casing baru di Rio Cell.
5. PENGETAHUAN UMUM: Jawab dengan santai dan lucu, tapi tetap coba selipkan promosi Rio Cell secara halus.

ATURAN GAYA BAHASA:
1. Posisikan dirimu sebagai CS manusia yang peduli. Gunakan sapaan 'Kak'.
2. JANGAN menjawab terlalu kaku seperti robot.
3. Tetap ringkas, maksimal 4 paragraf pendek.";
    }

    private function getTemplateResponse($message)
    {
        $msg = strtolower($message);
        
        if (Str::contains($msg, ['lemot', 'sinyal', 'jaringan', 'lelet'])) {
            return "Waduh, maaf banget Kak kalau internetnya lagi kurang stabil 🥺. Coba pancing dengan *Mode Pesawat (Airplane Mode)* selama 10 detik lalu matikan lagi. Kalau masih lemot, mungkin kuotanya habis, yuk cek dan isi ulang di Katalog Rio Cell! 📶";
        }

        if (Str::contains($msg, ['belum masuk', 'lama', 'pulsa belum', 'kuota belum', 'komplain'])) {
            return "Mohon maaf atas ketidaknyamanannya ya Kak 🙏. Kadang dari provider ada delay 5-15 menit. Kalau sudah lebih dari itu, langsung chat WA Owner kami di 0831-1318-8047 dengan menyebutkan Nomor Pesanannya ya! 🏃‍♂️💨";
        }

        if (Str::contains($msg, ['harga', 'pulsa', 'paket', 'dana'])) {
            return "Halo Kak! 😊 Untuk daftar harga lengkap, Kakak bisa langsung cek di menu *Katalog* ya. Harganya dijamin miring!";
        }
        
        return "Halo Kak! 😊 Maaf banget, sistem AI kami sedang maintenance sebentar. Untuk keluhan atau order, Kakak bisa langsung chat WhatsApp Owner di 0831-1318-8047 ya. Terima kasih pengertiannya! 🙏";
    }

    public function getHistory(Request $request)
    {
        $sessionId = $request->session_id;
        if (!$sessionId) return response()->json(['messages' => []]);

        $messages = ChatLog::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'role' => $chat->role,
                    'message' => $chat->message,
                    'time' => $chat->created_at->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}