<?php

namespace App\Livewire;

use Session;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditActivity extends Component
{
    public $activity = [];
    public $start_date;
    public $end_date;
    public $is_recurring;
    public $recurring_frequency;
    public $has_report;
    public $activity_name;

    public function render()
    {
        return view('livewire.edit-activity');
    }

    public function mount($id)
    {
        $this->activity = $this->getActivity($id);
        $this->activity_name = $this->activity['activity_name'];
        $this->start_date = $this->activity['start_date'];
        $this->end_date = $this->activity['end_date'];
    }

    public function getActivity($id)
    {
        $getActivity = 'https://api.odms.savannah.ug/api/v1/activity/get/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($getActivity);
                $activity = $response->json();
                $activity = $activity['data'];
                return $activity;
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function updateActivity()
    {
        $jsonData = $this->update();
        if ($jsonData['status'] == 200) {
            return redirect()
                ->route('activities.show', $this->activity['id'])
                ->with('success', 'Successfully updated an activity');
        } elseif ($jsonData['status'] == 400) {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        } elseif ($jsonData == 'Error') {
            return redirect()->route('error');
        } elseif ($jsonData == null) {
            return redirect()->route('login');
        } else {
        }
    }

    public function update()
    {
        $validated = $this->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'is_recurring' => ['nullable', 'string'],
            'recurring_frequency' => ['nullable', 'string'],
            'has_report' => ['nullable', 'string'],
            'activity_name' => ['nullable', 'string'],
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/activity/edit/' . $this->activity['id'];
        $data = [];
        $data['id'] = $this->activity['id'];
        $data['activity_name'] = $this->activity_name ? $this->activity_name : $this->activity['activity_name'];
        $data['start_date'] = $this->start_date ? $this->start_date : $this->activity['start_date'];
        $data['end_date'] = $this->end_date ? $this->end_date : $this->activity['end_date'];
        $data['is_recurring'] = $this->is_recurring ? $this->is_recurring : $this->activity['is_recurring'];
        $data['recurring_frequency'] = $this->recurring_frequency ? $this->recurring_frequency : $this->activity['recurring_frequency'];
        $data['has_report'] = $this->has_report ? $this->has_report : $this->activity['has_report'];
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response;
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
