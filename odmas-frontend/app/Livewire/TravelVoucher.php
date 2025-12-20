<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TravelVoucher extends Component
{
   
    

    public function render()
    {
        return view('livewire.travel-voucher');
    }

    public function getToken()
    {
        
    }
}
