<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class ShowHidePassword extends Component
{
    public $showPassword = false;

    public function render()
    {
        return view('livewire.show-hide-password');
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }
}
