<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->getTasks();
        if ($tasks) {
            return view('tasks.index', compact('tasks'));
        } else {
            return redirect()->route('login');
        }
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function show($taskId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/task/get/' . $taskId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            $task = $jsonData['data'];
            return view('tasks.show', compact('task'));
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($taskId)
    {
        $activities = $this->getActivities();
        $projectUsers = $this->getDeptEmployees();
        $url = 'https://api.odms.savannah.ug/api/v1/task/get/' . $taskId;
        $accessToken = $this->getToken();
        if ($accessToken || $activities || $projectUsers) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            $task = $jsonData['data'];
            return view('tasks.edit', compact(['task', 'activities', 'projectUsers']));
        } else {
            return redirect()->route('login');
        }
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
                return 'Error';
            }
        } else {
            return;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskId)
    {
        $editedResponse = $this->updateTask($request, $taskId);
        if ($editedResponse) {
            if ($editedResponse == 'Error') {
                return redirect()->route('error');
            } elseif ($editedResponse['status'] == 200) {
                $task = $editedResponse['data'];
                return view('tasks.show', compact('task'))->with('success', 'Successfully updated');
            } elseif ($editedResponse['error']) {
                return redirect()
                    ->route('tasks.edit', $taskId)
                    ->with('error', $editedResponse['error']);
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($taskId)
    {
        $task = $this->getATask($taskId);
        $url = 'https://api.odms.savannah.ug/api/v1/task/delete/' . $taskId;
        $accessToken = $this->getToken();
        if ($accessToken || $task) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url);
                return redirect()
                    ->route('activities.show', $task['related_activity']['id'])
                    ->with('success', 'Task deleted successfully');
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function removeAssignee()
    {
    }

    public function updateTask($request, $taskId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/task/edit/' . $taskId;
        $data = [];
        $data['related_activity'] = $request->related_activity;
        $data['related_task'] = '';
        $data['task_name'] = $request->task_name;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['has_report'] = false;
        $perData = [];
        array_push($perData, ['id' => $request->task_assignee]);
        $data['task_assignee'] = $perData;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getATask($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/task/get/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getTasks()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/task/list?search=false';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
