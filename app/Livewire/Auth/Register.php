<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Register extends Component
{
    #[Validate('required|min:3')]
    public $name = '';
    
    #[Validate('required|email|unique:users')]
    public $email = '';
    
    #[Validate('required|min:6')]
    public $password = '';
    
    #[Validate('required|same:password')]
    public $password_confirmation = '';
    
    #[Validate('required')]
    public $security_code = '';

    public $showSuccess = false;

    public function register()
    {
        // بررسی کد امنیتی
        if ($this->security_code !== '445678') {
            $this->addError('security_code', 'کد امنیتی اشتباه است.');
            return;
        }

        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        
        return redirect()->route('chat');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
