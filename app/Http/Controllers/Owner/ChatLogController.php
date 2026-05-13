<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ChatLog;
use App\Models\User;
use Illuminate\Http\Request;

class ChatLogController extends Controller
{
    /**
     * Menampilkan daftar semua percakapan AI dengan pelanggan
     */
    public function index(Request $request)
    {
        // Ambil semua session chat unik
        $sessions = ChatLog::select('session_id', 'user_id')
            ->selectRaw('MIN(created_at) as started_at')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('COUNT(*) as message_count')
            ->groupBy('session_id', 'user_id')
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($session) {
                $session->user = User::find($session->user_id);
                $session->last_message = ChatLog::where('session_id', $session->session_id)
                    ->orderByDesc('created_at')
                    ->first();
                return $session;
            });

        return view('owner.chatlogs.index', compact('sessions'));
    }

    /**
     * Menampilkan detail dari satu sesi percakapan
     */
    public function show($sessionId)
    {
        $messages = ChatLog::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        $session = ChatLog::where('session_id', $sessionId)->first();
        
        // Jika chat tidak ditemukan, redirect kembali
        if (!$session) {
            return redirect()->route('owner.chatlogs.index')->with('error', 'Chat tidak ditemukan.');
        }

        $user = User::find($session->user_id);

        return view('owner.chatlogs.show', compact('messages', 'sessionId', 'user'));
    }

    /**
     * Menghapus seluruh riwayat percakapan dari satu sesi
     */
    public function destroy($sessionId)
    {
        // Hapus semua chat yang memiliki session_id tersebut
        ChatLog::where('session_id', $sessionId)->delete();

        return redirect()->route('owner.chatlogs.index')
            ->with('success', 'Riwayat obrolan AI berhasil dihapus secara permanen!');
    }
}