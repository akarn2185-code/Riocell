<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Layanan Pelanggan (AI)') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Chat Container -->
            <div x-data="fullChat()" class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-[70vh] sm:h-[75vh] border border-gray-200 dark:border-gray-700">
                
                <!-- Header Chat (UBAH JADI DARK SLATE) -->
                <div class="bg-slate-900 p-4 sm:p-5 flex items-center justify-between shadow-md z-10">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4 border-2 border-slate-700 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg">CS Rio Cell (AI)</h3>
                            <p class="text-slate-400 text-sm flex items-center">
                                <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2 animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.8)]"></span>
                                Online membalas otomatis
                            </p>
                        </div>
                    </div>
                    <div>
                        <button @click="messages = []; localStorage.removeItem('chat_session_id'); sessionId = null;" class="text-slate-400 hover:text-white text-xs bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg transition border border-slate-700" title="Hapus Riwayat">
                            Mulai Ulang
                        </button>
                    </div>
                </div>

                <!-- Area Pesan -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-50 dark:bg-slate-900 space-y-6" id="mainChatArea" x-ref="mainChatArea">
                    
                    <template x-if="messages.length === 0">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0 shadow-md">
                                <span class="text-white font-bold text-sm">AI</span>
                            </div>
                            <div class="bg-white dark:bg-slate-800 rounded-2xl rounded-tl-none p-4 shadow-sm max-w-[85%] sm:max-w-[75%] border border-slate-200 dark:border-slate-700">
                                <p class="text-slate-800 dark:text-slate-200">Halo! 👋 Selamat datang di Pusat Bantuan Rio Cell.</p>
                                <p class="text-slate-800 dark:text-slate-200 mt-2">Saya adalah asisten virtual yang siap melayani Anda 24 jam. Jangan ragu untuk bertanya tentang:</p>
                                <ul class="mt-2 space-y-1 text-slate-600 dark:text-slate-400 text-sm list-disc list-inside ml-4">
                                    <li>Daftar produk & harga terbaru</li>
                                    <li>Cara melakukan pemesanan</li>
                                    <li>Lokasi dan jam operasional toko</li>
                                </ul>
                            </div>
                        </div>
                    </template>

                    <template x-for="(msg, index) in messages" :key="index">
                        <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                            
                            <!-- Chat AI -->
                            <template x-if="msg.role === 'assistant'">
                                <div class="flex items-start max-w-[90%] sm:max-w-[75%]">
                                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0 shadow-md">
                                        <span class="text-white font-bold text-sm">AI</span>
                                    </div>
                                    <div class="bg-white dark:bg-slate-800 rounded-2xl rounded-tl-none p-4 shadow-sm border border-slate-200 dark:border-slate-700">
                                        <p class="text-slate-800 dark:text-slate-200 whitespace-pre-line leading-relaxed" x-text="msg.message"></p>
                                        <p class="text-xs text-slate-400 mt-2 font-medium" x-text="msg.time"></p>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Chat User -->
                            <template x-if="msg.role === 'user'">
                                <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none p-4 shadow-md max-w-[90%] sm:max-w-[75%]">
                                    <p class="text-white leading-relaxed" x-text="msg.message"></p>
                                    <div class="flex justify-end items-center mt-2 space-x-1">
                                        <p class="text-xs text-blue-200 font-medium" x-text="msg.time"></p>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </template>

                    <!-- Animasi Mengetik -->
                    <div x-show="isTyping" class="flex items-start">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                            <span class="text-white font-bold text-sm">AI</span>
                        </div>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl rounded-tl-none p-4 shadow-sm border border-slate-200 dark:border-slate-700">
                            <div class="flex space-x-2 h-5 items-center">
                                <div class="w-2.5 h-2.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                <div class="w-2.5 h-2.5 bg-cyan-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                <div class="w-2.5 h-2.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="p-4 sm:p-5 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 z-10">
                    <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                        <input type="text" x-model="newMessage" 
                            placeholder="Ketik pesan Anda..." 
                            class="flex-1 rounded-xl border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white px-5 py-3.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            :disabled="isTyping">
                        <button type="submit" 
                            class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-600 rounded-xl flex items-center justify-center text-white hover:bg-blue-700 transition disabled:opacity-50 shadow-md"
                            :disabled="!newMessage.trim() || isTyping">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Chat JS (Sama persis) -->
    <script>
    function fullChat() {
        return {
            isTyping: false,
            messages: [],
            newMessage: '',
            sessionId: localStorage.getItem('chat_session_id') || null,

            init() {
                if (this.sessionId) {
                    this.loadHistory();
                }
            },

            async loadHistory() {
                try {
                    const response = await fetch(`/api/chat/history?session_id=${this.sessionId}`);
                    const data = await response.json();
                    this.messages = data.messages || [];
                    this.$nextTick(() => this.scrollToBottom());
                } catch (error) {
                    console.error('Failed to load history:', error);
                }
            },

            async sendMessage() {
                if (!this.newMessage.trim() || this.isTyping) return;

                const message = this.newMessage.trim();
                this.newMessage = '';

                const now = new Date();
                const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                this.messages.push({
                    role: 'user',
                    message: message,
                    time: time
                });

                this.$nextTick(() => this.scrollToBottom());
                this.isTyping = true;

                try {
                    const response = await fetch('/api/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            message: message,
                            session_id: this.sessionId
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.sessionId = data.session_id;
                        localStorage.setItem('chat_session_id', data.session_id);

                        this.messages.push({
                            role: 'assistant',
                            message: data.message,
                            time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                        });
                    }
                } catch (error) {
                    this.messages.push({
                        role: 'assistant',
                        message: 'Maaf, terjadi kesalahan koneksi server. Silakan coba lagi nanti.',
                        time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                    });
                }

                this.isTyping = false;
                this.$nextTick(() => this.scrollToBottom());
            },

            scrollToBottom() {
                const container = this.$refs.mainChatArea;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        }
    }
    </script>
</x-app-layout>