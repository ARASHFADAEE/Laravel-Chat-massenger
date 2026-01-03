<?php

namespace App\Livewire\Chat;

use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserList extends Component
{
    public $selectedUserId;
    public $selectedGroupId;
    public $activeTab = 'users'; // 'users' or 'groups'
    
    protected $listeners = [
        'refreshUserList' => '$refresh',
        'refreshChatList' => '$refresh',
        'groupCreated' => '$refresh'
    ];

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedGroupId = null;
        $this->dispatch('userSelected', userId: $userId);
    }

    public function selectGroup($groupId)
    {
        $this->selectedGroupId = $groupId;
        $this->selectedUserId = null;
        $this->dispatch('groupSelected', groupId: $groupId);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedUserId = null;
        $this->selectedGroupId = null;
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::id())
            ->get()
            ->map(function ($user) {
                $lastMessage = Auth::user()->getLastMessageWith($user->id);
                $user->last_message = $lastMessage;
                return $user;
            });

        $groups = Auth::user()->groups()
            ->with(['creator', 'messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get()
            ->map(function ($group) {
                $group->last_message = $group->getLastMessage();
                return $group;
            });

        return view('livewire.chat.user-list', [
            'users' => $users,
            'groups' => $groups
        ]);
    }
}
