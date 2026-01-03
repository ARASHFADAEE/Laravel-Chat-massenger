<?php

namespace App\Livewire\Group;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateGroup extends Component
{
    #[Validate('required|min:3|max:50')]
    public $name = '';
    
    #[Validate('nullable|max:200')]
    public $description = '';
    
    public $selectedUsers = [];
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
        $this->reset(['name', 'description', 'selectedUsers']);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function toggleUser($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_filter($this->selectedUsers, fn($id) => $id != $userId);
        } else {
            $this->selectedUsers[] = $userId;
        }
    }

    public function createGroup()
    {
        $this->validate();

        if (count($this->selectedUsers) < 1) {
            $this->addError('selectedUsers', 'حداقل یک کاربر را انتخاب کنید.');
            return;
        }

        $group = Group::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => Auth::id()
        ]);

        // اضافه کردن سازنده به عنوان ادمین
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'role' => 'admin'
        ]);

        // اضافه کردن کاربران انتخاب شده
        foreach ($this->selectedUsers as $userId) {
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $userId,
                'role' => 'member'
            ]);
        }

        $this->closeModal();
        $this->dispatch('groupCreated');
        $this->dispatch('refreshChatList');
        
        session()->flash('message', 'گروه با موفقیت ایجاد شد!');
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('livewire.group.create-group', [
            'users' => $users
        ]);
    }
}
