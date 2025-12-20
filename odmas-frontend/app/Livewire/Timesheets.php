<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;


class Timesheets extends Component{

    public $timesheets;
    public $employee_id;
    public $month;
    public $year;
    
   
    public function mount ()
    {
    
        if(($this->getTimesheets() == 'Error')){
            return redirect()->route('error');
        }
        if($this->getTimesheets() == null){
            return redirect()->route('login');
        }
        $id = Session::get('userDetails')['id'];
        $currentDateTime = now();
        $this->month = $currentDateTime->format('F'); 
        $this->year = $currentDateTime->year; 
        $this->timesheets = $this->getTimesheets();

    }

    public function getTimesheets() 
    {
           
    } 

   
    public function render()
    {
        return view('livewire.timesheets');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
