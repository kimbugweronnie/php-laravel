<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class ProcurementController extends Controller
{
    public function index()
    {
        return view('procurement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('procurement.create');
    }

    public function show($id)
    {
        return view('procurement.show', compact('id'));
    }

    public function edit($id)
    {
        return view('procurement.edit', compact('id'));
    }

    public function editProcurement($id)
    {
        return view('procurement.edit-detail', compact('id'));
    }

    public function getProcurementById($id)
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
        $procurementReq = $this->getProcurementById($id);
        foreach ($procurementReq['meta_fields'] as $field) {
            $total = $total + intval($field['estimated_total_cost']);
        }
        return $total;
    }

    public function downloadPDF($id)
    {
        $data = $this->getProcurementById($id);
        if ($data == 'Error') {
            return redirect()->route('error');
        }
        if ($data == null) {
            return redirect()->route('login');
        }
        $pdf = Pdf::loadView('pdf.procurement-requisition', ['procurementReq' => $this->getProcurementById($id), 'total' => $this->total($id)]);
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
