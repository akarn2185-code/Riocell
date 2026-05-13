<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('owner.chatlogs.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Chat dengan {{ $user->name ?? 'Guest' }}
                </h2>
            </div>
            
            <!-- Tombol Hapus Riwayat Chat -->
            <form action="{{ route('owner.chatlogs.destroy', $sessionId) }}" method="POST" onsubmit="return confirm('Peringatan: Anda yakin ingin menghapus SELURUH riwayat percakapan ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Obrolan
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-4 sm:p-6 space-y-5 max-h-[600px] overflow-y-auto bg-gray-50 dark:bg-gray-900/50">
                    
                    <div class="text-center pb-4">
                        <span class="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-xs text-gray-500 dark:text-gray-400 rounded-full font-medium">
                            Awal percakapan: {{ $messages->first()->created_at->format('d M Y') }}
                        </span>
                    </div>

                    @foreach($messages as $message)
                    <div class="{{ $message->role === 'user' ? 'flex justify-end' : 'flex justify-start' }}">
                        @if($message->role === 'assistant')
                        <!-- Balasan AI -->
                        <div class="flex items-start max-w-[85%]">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0 shadow-sm border border-white dark:border-gray-800">
                                <span class="text-white font-bold text-xs">AI</span>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
                                <p class="text-xs text-gray-400 mt-2 font-medium">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                        @else
                        <!-- Pertanyaan User -->
                        <div class="flex items-start max-w-[85%]">
                            <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none p-4 shadow-md">
                                <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                <div class="flex justify-end items-center mt-2 space-x-1">
                                    <p class="text-xs text-blue-200 font-medium">{{ $message->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center ml-3 flex-shrink-0 shadow-sm border border-white dark:border-gray-800">
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-300">{{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>