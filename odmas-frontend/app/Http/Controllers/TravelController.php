<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('travel.index');
    }

    public function travelExpenseVoucher()
    {
        return view('travel.expense-voucher');
    }

    public function createTravelMatrix($id)
    {
        return view('travel.create-travel-matrix', compact('id'));
    }

    public function singleTravelMatrix($week_from, $week_to)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/travel_matrix/get?week_from=' . $week_from . '&week_to=' . $week_to;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $data = $response->json()['data'];
                return view('travel.single-travel-matrix', compact('data'));
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }

        return view('travel.create-travel-matrix', compact('id'));
    }

    public function travelReport()
    {
        return view('travel.travel-report');
    }

    public function create()
    {
        return view('travel.create');
    }

    // TODO: Hardcode id, Why???
    public function store(Request $request)
    {
        $data = $this->storeTravelRequisition($request);
        $id = 1;
        return redirect()->route('travels.show', $id)->with('success', ' Travel Requisition successfully.');
    }

    public function storeTravelRequisition($request)
    {
        $userId = null;
        if (Session::get('userDetails')) {
            $userId = Session::get('userDetails')['id'];
        } else {
            return redirect()->route('login');
        }
        return $request;
    }

    public function getProject($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json()['data']['project_number'];
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function show($id)
    {
        return view('travel.show', compact('id'));
    }

    public function edit($id)
    {
        return view('travel.edit', compact('id'));
    }

    public function editDetails($id)
    {
        return view('travel.edit-detail', compact('id'));
    }

    public function getTravelById($id)
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function total($id)
    {
        $total = 0;
        $travelReq = $this->getTravelById($id);
        foreach ($travelReq['travel_advance_request_fields'] as $field) {
            $total = $total + $field['total'];
        }
        return $total;
    }

    public function employees($id)
    {
        $employees = 0;
        $travelReq = $this->getTravelById($id);
        $employees = count($travelReq['travel_advance_request_fields']);
        return $employees;
    }

    public function days($id)
    {
        $days = 0;
        $travelReq = $this->getTravelById($id);
        foreach ($travelReq['travel_advance_request_fields'] as $field) {
            $days = $days + $field['days'];
        }
        return $days;
    }

    public function rates($id)
    {
        $rates = 0;
        $travelReq = $this->getTravelById($id);
        foreach ($travelReq['travel_advance_request_fields'] as $field) {
            $rates = $rates + $field['rate'];
        }
        return $rates;
    }

    public function downloadPDF($id)
    {
        $data = $this->getTravelById($id);
        if ($data == 'Error') {
            return redirect()->route('error');
        }
        if ($data == null) {
            return redirect()->route('login');
        }
        $project_number = $this->getProject($data['related_document_request']['related_project_document']['related_project']['id']);

        $pdf = Pdf::loadView('pdf.travel-requisition', [
            'travelReq' => $this->getTravelById($id),
            'project_number' => $project_number,
            'subTotal' => $this->total($id),
            'rate' => $this->rates($id),
            'days' => $this->days($id),
            'numberOfPersons' => $this->employees($id),
        ]);
        $pdfContent = $pdf->stream($data['related_document_request']['related_project_document']['document_name'] . '.pdf')->getContent();
        return response()->make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $data['related_document_request']['related_project_document']['document_name'] . '.pdf"',
        ]);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
