<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;

    public $selectedUserId;
    public $selectedUser;
    public $message = '';
    public $messages = [];
    public $file;
    public $showFileUpload = false;

    protected $listeners = ['userSelected' => 'loadChat'];

    public function loadChat($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
        
        // علامت‌گذاری پیام‌ها به عنوان خوانده شده
        Chat::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function loadMessages()
    {
        if (!$this->selectedUserId) return;

        $this->messages = Chat::where(function($q) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $this->selectedUserId);
        })->orWhere(function($q) {
            $q->where('sender_id', $this->selectedUserId)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage()
    {
        if ((!$this->message && !$this->file) || !$this->selectedUserId) return;

        $chatData = [
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUserId,
            'message' => $this->message ?: ''
        ];

        // آپلود فایل
        if ($this->file) {
            $fileName = time() . '_' . $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('chat-files', $fileName, 'public');
            
            $chatData['file_path'] = $filePath;
            $chatData['file_name'] = $this->file->getClientOriginalName();
            $chatData['file_size'] = $this->file->getSize();
            
            // تشخیص نوع فایل
            $mimeType = $this->file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $chatData['file_type'] = 'image';
            } else {
                $chatData['file_type'] = 'document';
            }
        }

        Chat::create($chatData);

        $this->reset(['message', 'file']);
        $this->showFileUpload = false;
        $this->loadMessages();
        $this->dispatch('refreshUserList');
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
        return view('livewire.chat.chat-box');
    }
}
