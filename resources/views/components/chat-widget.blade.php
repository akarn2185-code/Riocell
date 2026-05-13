<!-- Chat Widget -->
<div x-data="chatWidget()" 
     @open-chat.window="if(!isOpen) toggleChat()"
     x-cloak class="fixed bottom-4 right-4 z-50">
    
    <!-- Chat Button -->
    <button @click="toggleChat()" 
        class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-lg flex items-center justify-center text-white hover:shadow-xl transition-all duration-300 transform hover:scale-105"
        :class="{ 'scale-0': isOpen }">
        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute bottom-0 right-0 w-[calc(100vw-2rem)] sm:w-96 h-[500px] sm:h-[550px] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Rio Cell Assistant</h3>
                    <p class="text-blue-100 text-xs flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                        Online 24/7
                    </p>
                </div>
            </div>
            <button @click="toggleChat()" class="text-white/80 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chatMessages" x-ref="chatMessages">
            <!-- Welcome Message -->
            <template x-if="messages.length === 0">
                <div class="flex items-start">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-tl-none p-3 max-w-[80%]">
                        <p class="text-sm text-gray-800 dark:text-gray-200">Halo! 👋 Saya adalah asisten virtual Rio Cell. Ada yang bisa saya bantu?</p>
                        <p class="text-xs text-gray-500 mt-2">Anda bisa bertanya tentang produk, harga, cara pemesanan, dan lainnya.</p>
                    </div>
                </div>
            </template>

            <!-- Chat Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <template x-if="msg.role === 'assistant'">
                        <div class="flex items-start max-w-[85%]">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-tl-none p-3">
                                <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line" x-text="msg.message"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="msg.time"></p>
                            </div>
                        </div>
                    </template>
                    <template x-if="msg.role === 'user'">
                        <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none p-3 max-w-[85%]">
                            <p class="text-sm" x-text="msg.message"></p>
                            <p class="text-xs text-blue-200 mt-1" x-text="msg.time"></p>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl rounded-tl-none p-3">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Replies -->
        <div class="px-4 pb-2" x-show="messages.length === 0">
            <div class="flex flex-wrap gap-2">
                <button @click="sendQuickReply('Daftar harga pulsa')" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    💰 Harga Pulsa
                </button>
                <button @click="sendQuickReply('Cara pemesanan')" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    🛒 Cara Pesan
                </button>
                <button @click="sendQuickReply('Jam operasional')" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    🕐 Jam Buka
                </button>
            </div>
        </div>

        <!-- Input -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <input type="text" x-model="newMessage" 
                    placeholder="Ketik pesan..." 
                    class="flex-1 rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    :disabled="isTyping">
                <button type="submit" 
                    class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition disabled:opacity-50"
                    :disabled="!newMessage.trim() || isTyping">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function chatWidget() {
    return {
        isOpen: false,
        isTyping: false,
        messages: [],
        newMessage: '',
        sessionId: localStorage.getItem('chat_session_id') || null,

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && this.sessionId) {
                this.loadHistory();
            }
        },

        async loadHistory() {
            if (!this.sessionId) return;
            
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
                    message: 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.',
                    time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                });
            }

            this.isTyping = false;
            this.$nextTick(() => this.scrollToBottom());
        },

        sendQuickReply(text) {
            this.newMessage = text;
            this.sendMessage();
        },

        scrollToBottom() {
            const container = this.$refs.chatMessages;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>