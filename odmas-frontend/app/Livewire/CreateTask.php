<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateTask extends Component
{
    public $activities = [];
    public $related_activity = '';
    public $employee = '';
    public $task_name = '';
    public $start_date = '';
    public $end_date = '';
    public $task_asignee_fields = [];
    public $employees = [];
    public $has_report = '';

    public function mount()
    {
        $this->activities = $this->getActivites();
        $this->employees = $this->getDeptEmployees();
    }

    public function getDeptEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1';
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

    public function getActivites()
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

    public function taskRequest()
    {
        $jsonData = $this->storeTask();
        if ($jsonData) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('activities.index');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->route('tasks.create')
                    ->with('error', $jsonData['error']);
            } else {
                return redirect()->back()->with('warning', 'Failed creating task');
            }
        } else {
            return redirect()->back()->with('warning', 'Failed creating task');
        }
    }

    public function storeTask()
    {
        $validatedData = $this->validate([
            'related_activity' => ['required', 'string'],
            'task_name' => ['string', 'required'],
            'start_date' => ['date', 'required'],
            'end_date' => ['date', 'required'],
            'employee' => ['required', 'integer'],
            'has_report' => ['required', 'string'],
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/task/add';
        $data = [];
        $data['related_activity'] = $validatedData['related_activity'];
        $data['task_name'] = $validatedData['task_name'];
        $data['related_task'] = '';
        $data['start_date'] = $validatedData['start_date'];
        $data['end_date'] = $validatedData['end_date'];
        $data['has_report'] = $validatedData['has_report'];
        $data['task_assignee'] = $this->task_asignee_fields;

        array_push($data['task_assignee'], [
            'id' => $validatedData['employee'],
        ]);
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
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

    public function addRowToItemList()
    {
        $this->task_asignee_fields[] = [
            'id' => 0,
        ];
    }

    public function removeRowToItemList($Id)
    {
        array_splice($this->task_asignee_fields, $Id, 1);
    }

    public function render()
    {
        return view('livewire.create-task');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
