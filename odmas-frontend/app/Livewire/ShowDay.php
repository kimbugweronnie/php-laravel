<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class ShowDay extends Component
{
    public $showPassword = false;
    public $period;

    public function generatePeriod()
    {
        $currentTime = now()->addHours(3)->format('H');
        if(intval($currentTime) >= 0 && intval($currentTime) < 12) {
            return "Welcome, Good Morning";
        }elseif(intval($currentTime) >= 12 && intval($currentTime) < 17) {
            return "Welcome, Good Afternoon";
        }else {
            return "Welcome, Good Evening";
        }
    }

    public function mount()
    {
        $this->period = $this->generatePeriod();
    }
    
    public function render()
    {
        return view('livewire.show-day');
    }
}
