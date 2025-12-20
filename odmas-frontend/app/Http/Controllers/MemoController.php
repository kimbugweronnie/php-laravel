<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('memo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $memoId = '';
        $projectId = '';
        $projectUsers = [];

        if (Session::get('memoId') || Session::get('projectId')) {
            $memoId = Session::get('memoId');
            $projectId = Session::get('projectId');
            $jsonData = $this->getProjectUsers();
            if ($jsonData) {
                if ($jsonData == 'Error') {
                    return redirect()->route('error');
                } elseif ($jsonData['status'] == 200) {
                    $projectUsers = $jsonData['data'];
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->back()->with('error', 'Please select project and memo template to proceed');
        }
        return view('memo.create', compact(['projectUsers']));
    }

    public function store(Request $request)
    {
        $memoId = Session::get('memoId');
        $validatedData = $request->validate([
            'date' => 'required',
            'title' => ['required', 'string'],
            'person_to' => ['required'],
            'purpose' => ['required', 'string'],
            'background' => ['required', 'string'],
            'persons_through' => ['required', 'array'],
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/memos';
        $data = [];
        $data['related_project_document'] = $memoId;
        $data['title'] = $validatedData['title'];
        $data['background'] = $validatedData['background'];
        $data['purpose'] = $validatedData['purpose'];
        $data['to'] = $validatedData['person_to'];
        $data['date'] = $validatedData['date'];

        $perData = [];
        if (count($validatedData['persons_through']) > 0) {
            foreach ($validatedData['persons_through'] as $person) {
                array_push($perData, ['id' => $person]);
            }
        }
        $data['persons_through'] = $perData;

        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                $jsonData = $response->json();
                if ($jsonData) {
                    if ($jsonData['status'] == 201) {
                        return redirect()->route('memos.index')->with('success', 'Sucessfully created memo request');
                    } elseif ($jsonData == 'Error') {
                        return redirect()->route('error');
                    } elseif ($jsonData['status'] == 400) {
                        if (isset($jsonData['error']['related_project_document'])) {
                            return redirect()->route('memos.create')->with('error', 'Please select a memo template');
                        }
                        return redirect()
                            ->route('memos.create')
                            ->with('error', $jsonData['error']);
                    }
                } else {
                    return redirect()->route('login');
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        return view('memo.edit', compact('id'));
    }

    public function getMemoReqById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/details/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                }
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function show($id)
    {
        return view('memo.show', compact('id'));
    }

    public function getMemoById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/details/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                } else {
                    return [];
                }
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function downloadPDF($id)
    {
        $data = $this->getMemoById($id);
        if ($data == 'Error') {
            return redirect()->route('error');
        }
        if ($data == null) {
            return redirect()->route('login');
        }
        $currentUser = Session::get('userDetails');
        $pdf = Pdf::loadView('pdf.memo', [
            'memo' => $this->getMemoById($id),
            'currentUser' => $currentUser,
        ]);
        $pdfContent = $pdf->stream($data['title'] . '.pdf')->getContent();
        return response()->make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $data['title'] . '.pdf"',
        ]);
    }

    public function editDetails($id)
    {
        if ($this->getMemoReqById($id) == 'Error') {
            return redirect()->route('error');
        }
        if (is_null($this->getMemoReqById($id))) {
            return redirect()->route('login');
        }
        if (is_null($this->getProjectUsers())) {
            return redirect()->route('login');
        }
        $memoReq = $this->getMemoById($id);
        $jsonData = $this->getProjectUsers();
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 200) {
                $projectUsers = $jsonData['data'];
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->route('login');
        }
        $approvers = $memoReq['approval_steps'];
        foreach ($approvers as $approver) {
            $approverId = $approver['related_approver']['id'];
            $projectUsers = array_filter($projectUsers, function ($projectUser) use ($approverId) {
                return $projectUser['id'] !== $approverId;
            });
        }

        return view('memo.edit-detail', compact('memoReq', 'projectUsers', 'approvers'));
    }

    public function updateDetails(Request $request, $id)
    {
        // dd($request);
        $validatedData = $request->validate([
            'date' => 'required',
            'title' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'background' => ['required', 'string'],
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/memos/edit?id=' . $id;
        $data = [];
        $data['title'] = $validatedData['title'];
        $data['date'] = $validatedData['date'];
        $data['purpose'] = $validatedData['purpose'];
        $data['background'] = $validatedData['background'];
        // dd($data);
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return redirect()->route('memos.editDetails', $id)->with('success', 'Sucessfully updated  memo request');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getProjectUsers()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
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
