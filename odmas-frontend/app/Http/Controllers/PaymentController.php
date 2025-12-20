<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.create');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        return view('payment.edit', compact('id'));
    }

    public function editPayment($id)
    {
        return view('payment.edit-detail', compact('id'));
    }

    public function getPaymentReqById($id)
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

    public function downloadPDF($id)
    {
        $data = $this->getPaymentReqById($id);
        $pdf = Pdf::loadView('pdf.payment-requisition', ['paymentReq' => $this->getPaymentReqById($id), 'total' => $this->getTotal($id)]);
        $pdfContent = $pdf->stream($data['title'] . '.pdf')->getContent();
        return response()->make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $data['title'] . '.pdf"',
        ]);
    }
    function getTotal($id)
    {
        $total = 0;
        $payment = $this->getPaymentReqById($id);
        foreach ($payment['meta_fields'] as $field) {
            $total = $total + $field['amount'];
        }
        return $total;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('payment.show', compact('id'));
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
