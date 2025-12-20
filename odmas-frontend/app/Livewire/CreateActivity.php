<?php
namespace App\Livewire;

use Session;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateActivity extends Component
{
    public $start_date;
    public $end_date;
    public $is_recurring;
    public $recurring_frequency;
    public $has_report;
    public $activity_name;

    public function render()
    {
        return view('livewire.create-activity');
    }

    public function mount()
    {
        $accessToken = $this->getToken();
        if (!$accessToken) {
            return redirect()->route('login');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }

    public function store()
    {
        if (strtotime($this->start_date) > strtotime($this->end_date)) {
            return redirect()->route('activities.create')->with('warning', 'Unable to create activity with the these dates');
        }
        if ($this->is_recurring == 'Select ocurrence') {
            return redirect()->route('activities.create')->with('error', 'Select ocurrence');
        }
        if ($this->recurring_frequency == 'Select frequency') {
            return redirect()->route('activities.create')->with('error', 'Select frequency');
        }
        if ($this->has_report == 'Select choice') {
            return redirect()->route('activities.create')->with('error', 'Select choice');
        }
        $jsonData = $this->storeActivity();

        if ($jsonData == null) {
            return redirect()->back('error', 'Creating Activity Wasn\'t successful.');
        }
        if ($jsonData['status'] == 201) {
            return redirect()->route('activities.index');
        } else {
            return redirect()->back('error', 'It Wasn\'t successful.');
        }
    }

    public function storeActivity()
    {
        $userId = null;
        if (Session::get('userDetails')) {
            $userId = Session::get('userDetails')['id'];
        } else {
            return redirect()->route('login');
        }

        $validated = $this->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'is_recurring' => ['required', 'string'],
            'recurring_frequency' => ['required', 'string'],
            'has_report' => ['required', 'string'],
            'activity_name' => 'required',
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/activity/add';
        $data = [];
        $data['activity_name'] = $validated['activity_name'];
        $data['start_date'] = $validated['start_date'];
        $data['end_date'] = $validated['end_date'];
        $data['is_recurring'] = $validated['is_recurring'];
        $data['recurring_frequency'] = $validated['recurring_frequency'];
        $data['has_report'] = $validated['has_report'];
        $data['added_by'] = $userId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
