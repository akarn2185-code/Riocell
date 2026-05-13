<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Log Chat AI') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Riwayat Percakapan Pelanggan</h3>
                    <p class="text-sm text-gray-500 mt-1">Monitor semua percakapan AI Chatbot dengan pelanggan</p>
                </div>

                @if($sessions->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($sessions as $session)
                    <a href="{{ route('owner.chatlogs.show', $session->session_id) }}" class="block p-4 sm:p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($session->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $session->user->name ?? 'Guest' }}</p>
                                    <p class="text-sm text-gray-500 truncate max-w-xs">
                                        {{ $session->last_message->message ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400">{{ $session->last_message_at ? \Carbon\Carbon::parse($session->last_message_at)->diffForHumans() : '-' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $session->message_count }} pesan</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p>Belum ada percakapan dengan AI Chatbot</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>