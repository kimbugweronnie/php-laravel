<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TravelReport extends Component
{
   

    public function render()
    {
        return view('livewire.travel-report');
    }

    public function getToken()
    {
        
    }
}
