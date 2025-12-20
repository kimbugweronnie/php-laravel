<?php

namespace App\Livewire;

use Session;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Home extends Component
{
    public $approvals = [];
    public $activities = [];
    public $apprNums;
    public $activityCount;
    public $clockin_clockout;
    public $isitFive;

    public function render()
    {
        return view('livewire.home');
    }

    public function mount()
    {
       
        $this->clockin_clockout = $this->checkClockinClockout();
        $this->approvals = $this->getApprovals();
        $this->activities = $this->getActivities();
        $this->apprNums = count($this->approvals);
        $this->activityCount = count($this->activities);
       
    }

     public function getActivities()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/list?search=false';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function checkTime(){
       $time = date('H', strtotime('+3 hours'));
       return $time;
    }

    public function checkClockinClockout()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/clock_in_clock_out/check';
        $currentTime = now()->format('Y-m-d');
        $data = [];
        $data['date'] = $currentTime;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                $jsonData = $response->json();
                return $jsonData;
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }
    
    public function getApprovals()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approvals';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    return 'No approvals';
                }
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                }
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
