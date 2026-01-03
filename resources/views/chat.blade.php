<x-layouts.app>
    <div class="h-screen flex">
        <!-- سایدبار کاربران و گروه‌ها -->
        <div class="w-80 bg-white border-r border-gray-200">
            @livewire('chat.user-list')
        </div>

        <!-- بخش چت -->
        <div class="flex-1 bg-gray-50">
            <!-- چت خصوصی -->
            <div id="private-chat">
                @livewire('chat.chat-box')
            </div>
            
            <!-- چت گروهی -->
            <div id="group-chat" style="display: none;">
                @livewire('group.group-chat')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            // نمایش چت خصوصی
            Livewire.on('userSelected', () => {
                document.getElementById('private-chat').style.display = 'block';
                document.getElementById('group-chat').style.display = 'none';
            });
            
            // نمایش چت گروهی
            Livewire.on('groupSelected', () => {
                document.getElementById('private-chat').style.display = 'none';
                document.getElementById('group-chat').style.display = 'block';
            });
        });
    </script>
</x-layouts.app>