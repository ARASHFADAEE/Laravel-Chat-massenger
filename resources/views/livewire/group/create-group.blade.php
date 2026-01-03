<div>
    <!-- دکمه ایجاد گروه -->
    <button wire:click="openModal" 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        ایجاد گروه جدید
    </button>

    <!-- مودال ایجاد گروه -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <!-- هدر مودال -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">ایجاد گروه جدید</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- فرم ایجاد گروه -->
                    <form wire:submit="createGroup" class="space-y-4">
                        <!-- نام گروه -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">نام گروه</label>
                            <input wire:model="name" type="text" id="name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="نام گروه را وارد کنید">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- توضیحات -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات (اختیاری)</label>
                            <textarea wire:model="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="توضیحات گروه را وارد کنید"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- انتخاب کاربران -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">انتخاب اعضا</label>
                            <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md">
                                @foreach($users as $user)
                                    <div class="flex items-center p-2 hover:bg-gray-50">
                                        <input type="checkbox" 
                                               wire:click="toggleUser({{ $user->id }})"
                                               {{ in_array($user->id, $selectedUsers) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="mr-3 flex items-center">
                                            @if($user->avatar)
                                                <img src="{{ $user->avatar }}" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-xs text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <span class="mr-2 text-sm text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedUsers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- دکمه‌های عمل -->
                        <div class="flex justify-end space-x-2 pt-4">
                            <button type="button" wire:click="closeModal"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200">
                                انصراف
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-200">
                                ایجاد گروه
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- نمایش پیام موفقیت -->
    @if (session()->has('message'))
        <div class="mt-2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>