<?php

namespace App\Livewire;

use Session;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IndexClockInAndOut extends Component
{
    public $clockInsAndOuts = [];
    public $start_date = null;
    public $end_date = null;

    public function mount()
    {
        $start = Carbon::now()->subDays(14)->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $this->clockInsAndOuts = $this->getClockInsAndOutCustom($start, $end);
        if (is_null($this->clockInsAndOuts)) {
            return redirect()->route('login');
        } elseif ($this->getClockInsAndOutCustom($start, $end) == 'Error') {
            return redirect()->route('error');
        }
    }

    public function render()
    {
        return view('livewire.index-clock-in-and-out');
    }

    public function fetchClockInsAndOutRange()
    {
        if ($this->start_date) {
            if (!$this->isValidDate($this->start_date)) {
                return redirect()->back()->with('warning', 'Wrong date format');
            }
        } elseif ($this->end_date) {
            if (!$this->isValidDate($this->end_date)) {
                return redirect()->back()->with('warning', 'Wrong date format');
            }
        } elseif (strtotime($this->end_date) < strtotime($this->start_date)) {
            return redirect()->back()->with('warning', 'Wrong date ranges');
        } else {
            return redirect()->back()->with('warning', 'No dates entered');
        }

        if ($this->start_date && $this->end_date) {
            $this->clockInsAndOuts = $this->getClockInsAndOutCustom($this->start_date, $this->end_date);
            if ($this->getClockInsAndOutCustom($this->start_date, $this->end_date) == 'Error') {
                return redirect()->route('error');
            }
            if ($this->clockInsAndOuts) {
                $this->start_date = '';
                $this->end_date = '';
            } else {
                return [];
            }
        } else {
            return redirect()->back();
        }
    }

    public function isValidDate($date, $format = 'Y-m-d')
    {
        $dateTime = Carbon::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }

    public function getClockInsAndOutCustom($start, $end)
    {
        $id = Session::get('userDetails')['id'];
        $url = 'https://api.odms.savannah.ug/api/v1/clock_in_clock_out/list/' . $id . '?filter_period=True&start_date=' . $start . '&end_date=' . $end;
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
