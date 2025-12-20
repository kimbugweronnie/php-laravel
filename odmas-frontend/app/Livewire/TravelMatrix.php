<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TravelMatrix extends Component
{
   
    

    public function render()
    {
        return view('livewire.travel-matrix');
    }

    public function getToken()
    {
        
    }
}
