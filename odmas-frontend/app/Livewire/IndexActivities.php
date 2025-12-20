<?php

namespace App\Livewire;

use Session;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IndexActivities extends Component
{
    public $activities = [];

    public function render()
    {
        return view('livewire.index-activities');
    }

    public function mount()
    {
        $this->activities = $this->getActivities();
    }

    public function getActivities()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/list?search=false';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
