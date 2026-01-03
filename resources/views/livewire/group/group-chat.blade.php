<div class="h-full flex flex-col">
    @if($selectedGroup)
        <!-- هدر گروه -->
        <div class="bg-white border-b border-gray-200 p-4 flex items-center gap-3">
            @if($selectedGroup->avatar)
                <img src="{{ $selectedGroup->avatar }}" class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            @endif
            <div>
                <h3 class="font-semibold text-gray-900">{{ $selectedGroup->name }}</h3>
                <p class="text-sm text-gray-500">{{ $selectedGroup->users->count() }} عضو</p>
                @if($selectedGroup->description)
                    <p class="text-xs text-gray-400">{{ $selectedGroup->description }}</p>
                @endif
            </div>
        </div>

        <!-- پیام‌های گروه -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" id="group-messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        @if($message->sender_id != auth()->id())
                            <!-- نام فرستنده برای پیام‌های دیگران -->
                            <div class="text-xs text-gray-500 mb-1 px-1">
                                {{ $message->sender->name }}
                            </div>
                        @endif
                        
                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-white text-gray-900' }} shadow">
                            
                            <!-- نمایش فایل -->
                            @if($message->hasFile())
                                @if($message->isImage())
                                    <!-- نمایش عکس -->
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $message->file_path) }}" 
                                             alt="{{ $message->file_name }}"
                                             class="max-w-full h-auto rounded-lg cursor-pointer"
                                             onclick="window.open('{{ asset('storage/' . $message->file_path) }}', '_blank')">
                                    </div>
                                @else
                                    <!-- نمایش فایل -->
                                    <div class="mb-2 p-3 {{ $message->sender_id == auth()->id() ? 'bg-blue-400' : 'bg-gray-100' }} rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-8 h-8 {{ $message->sender_id == auth()->id() ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium {{ $message->sender_id == auth()->id() ? 'text-white' : 'text-gray-900' }}">{{ $message->file_name }}</p>
                                                <p class="text-xs {{ $message->sender_id == auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">{{ $message->getFileSizeFormatted() }}</p>
                                            </div>
                                            <a href="{{ asset('storage/' . $message->file_path) }}" 
                                               download="{{ $message->file_name }}"
                                               class="{{ $message->sender_id == auth()->id() ? 'text-white hover:text-blue-100' : 'text-blue-500 hover:text-blue-700' }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- متن پیام -->
                            @if($message->message)
                                <p class="text-sm">{{ $message->message }}</p>
                            @endif
                        </div>
                        
                        <div class="mt-1 flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <span class="text-xs text-gray-500">
                                {{ $message->created_at->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="mt-2">هنوز پیامی در گروه ارسال نشده</p>
                    <p class="text-sm">اولین پیام را ارسال کنید!</p>
                </div>
            @endforelse
        </div>

        <!-- باکس ارسال پیام گروه -->
        <div class="bg-white border-t border-gray-200 p-4">
            <!-- نمایش فایل انتخاب شده -->
            @if($file)
                <div class="mb-3 p-3 bg-gray-100 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <span class="text-sm text-gray-700">{{ $file->getClientOriginalName() }}</span>
                        </div>
                        <button wire:click="$set('file', null)" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- آپلود فایل -->
            @if($showFileUpload)
                <div class="mb-3">
                    <input type="file" wire:model="file" 
                           accept="image/*,.pdf,.doc,.docx,.txt,.zip,.rar"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            @endif

            <form wire:submit="sendMessage" class="flex items-center gap-2">
                <button type="button" wire:click="toggleFileUpload"
                        class="p-2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                </button>
                
                <input 
                    wire:model="message" 
                    type="text" 
                    placeholder="پیام خود را در گروه بنویسید..."
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:keydown.enter="sendMessage"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition-colors duration-200 disabled:opacity-50"
                    {{ (!$message && !$file) ? 'disabled' : '' }}
                >
                    ارسال
                </button>
            </form>
        </div>
    @else
        <!-- حالت انتخاب نشده -->
        <div class="h-full flex items-center justify-center bg-gray-50">
            <div class="text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">گروه انتخاب کنید</h3>
                <p class="mt-1 text-sm text-gray-500">برای شروع گفتگو، یکی از گروه‌ها را انتخاب کنید</p>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('groupSelected', () => {
            setTimeout(() => {
                const container = document.getElementById('group-messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        });
    });
</script>