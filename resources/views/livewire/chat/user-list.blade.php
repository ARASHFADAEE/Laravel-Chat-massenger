<div class="h-full flex flex-col">
    <!-- هدر -->
    <div class="bg-white border-b border-gray-200 p-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">چت‌ها</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                    خروج
                </button>
            </form>
        </div>

        <!-- تب‌ها -->
        <div class="flex space-x-1 bg-gray-100 rounded-lg p-1">
            <button 
                wire:click="setActiveTab('users')"
                class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'users' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                پیام‌های خصوصی
            </button>
            <button 
                wire:click="setActiveTab('groups')"
                class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors {{ $activeTab === 'groups' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                گروه‌ها
            </button>
        </div>

        <!-- دکمه ایجاد گروه -->
        @if($activeTab === 'groups')
            <div class="mt-3">
                @livewire('group.create-group')
            </div>
        @endif
    </div>

    <!-- محتوای تب‌ها -->
    <div class="flex-1 overflow-y-auto">
        @if($activeTab === 'users')
            <!-- لیست کاربران -->
            @forelse($users as $user)
                <div class="flex items-center gap-3 p-4 hover:bg-gray-50 cursor-pointer border-b border-gray-100 {{ $selectedUserId == $user->id ? 'bg-blue-50' : '' }}"
                     wire:click="selectUser({{ $user->id }})">
                    
                    <!-- آواتار -->
                    <div class="flex-shrink-0">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- اطلاعات کاربر -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $user->name }}
                            </p>
                            @if($user->last_message)
                                <p class="text-xs text-gray-500">
                                    {{ $user->last_message->created_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                        
                        @if($user->last_message)
                            <p class="text-sm text-gray-500 truncate">
                                @if($user->last_message->sender_id == auth()->id())
                                    شما: 
                                @endif
                                {{ Str::limit($user->last_message->message, 30) }}
                            </p>
                        @else
                            <p class="text-sm text-gray-400">هنوز پیامی ارسال نشده</p>
                        @endif
                    </div>

                    <!-- نشانگر پیام خوانده نشده -->
                    @php
                        $unreadCount = \App\Models\Chat::where('sender_id', $user->id)
                            ->where('receiver_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    
                    @if($unreadCount > 0)
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p>هیچ کاربری یافت نشد</p>
                </div>
            @endforelse
        @else
            <!-- لیست گروه‌ها -->
            @forelse($groups as $group)
                <div class="flex items-center gap-3 p-4 hover:bg-gray-50 cursor-pointer border-b border-gray-100 {{ $selectedGroupId == $group->id ? 'bg-blue-50' : '' }}"
                     wire:click="selectGroup({{ $group->id }})">
                    
                    <!-- آواتار گروه -->
                    <div class="flex-shrink-0">
                        @if($group->avatar)
                            <img src="{{ $group->avatar }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- اطلاعات گروه -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $group->name }}
                            </p>
                            @if($group->last_message)
                                <p class="text-xs text-gray-500">
                                    {{ $group->last_message->created_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                        
                        @if($group->last_message)
                            <p class="text-sm text-gray-500 truncate">
                                {{ $group->last_message->sender->name }}: {{ Str::limit($group->last_message->message, 25) }}
                            </p>
                        @else
                            <p class="text-sm text-gray-400">هنوز پیامی ارسال نشده</p>
                        @endif
                        
                        <p class="text-xs text-gray-400">
                            {{ $group->users->count() }} عضو
                        </p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p class="mt-2">هیچ گروهی یافت نشد</p>
                    <p class="text-sm">گروه جدید ایجاد کنید!</p>
                </div>
            @endforelse
        @endif
    </div>
</div>