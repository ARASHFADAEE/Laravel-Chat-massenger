<?php

namespace App\Livewire\Group;

use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupChat extends Component
{
    use WithFileUploads;

    public $selectedGroupId;
    public $selectedGroup;
    public $message = '';
    public $messages = [];
    public $file;
    public $showFileUpload = false;

    protected $listeners = ['groupSelected' => 'loadGroupChat'];

    public function loadGroupChat($groupId)
    {
        $this->selectedGroupId = $groupId;
        $this->selectedGroup = Group::with('users')->find($groupId);
        
        // بررسی عضویت کاربر در گروه
        if (!$this->selectedGroup || !$this->selectedGroup->isMember(Auth::id())) {
            $this->selectedGroup = null;
            $this->selectedGroupId = null;
            return;
        }
        
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->selectedGroupId) return;

        $this->messages = GroupMessage::with('sender')
            ->where('group_id', $this->selectedGroupId)
            ->orderBy('created_at')
            ->get();
    }

    public function sendMessage()
    {
        if ((!$this->message && !$this->file) || !$this->selectedGroupId) return;

        // بررسی عضویت
        if (!$this->selectedGroup->isMember(Auth::id())) {
            return;
        }

        $messageData = [
            'group_id' => $this->selectedGroupId,
            'sender_id' => Auth::id(),
            'message' => $this->message ?: ''
        ];

        // آپلود فایل
        if ($this->file) {
            $fileName = time() . '_' . $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('group-files', $fileName, 'public');
            
            $messageData['file_path'] = $filePath;
            $messageData['file_name'] = $this->file->getClientOriginalName();
            $messageData['file_size'] = $this->file->getSize();
            
            // تشخیص نوع فایل
            $mimeType = $this->file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $messageData['file_type'] = 'image';
            } else {
                $messageData['file_type'] = 'document';
            }
        }

        GroupMessage::create($messageData);

        $this->reset(['message', 'file']);
        $this->showFileUpload = false;
        $this->loadMessages();
        $this->dispatch('refreshChatList');
    }

    public function toggleFileUpload()
    {
        $this->showFileUpload = !$this->showFileUpload;
        if (!$this->showFileUpload) {
            $this->file = null;
        }
    }

    public function render()
    {
        return view('livewire.group.group-chat');
    }
}
