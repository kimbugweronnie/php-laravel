<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('documents.index');
    }

    public function addedBy()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_categories?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            }catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
           return redirect()->route('login');
        }
    }

    public function create()
    {
        $projects = Session::get('projects');
        $docTypes = $this->getDocTypes();
        $docCategories = $this->getDocCategories();
        if ($projects || $docTypes || $docCategories) {
            $projects = Session::get('projects');
            $docTypes = $this->getDocTypes();
            $docCategories = $this->getDocTypes();
        } 
        else if (($docTypes == 'Error') || ($docCategories == 'Error')) {
           return redirect()->route('error');
        } 
         else if ($docTypes == null || $docCategories == null ) {
           return redirect()->route('login');
        } 
        return view('documents.create', compact(['projects', 'docTypes', 'docCategories']));
    }
    
    public function store(Request $request)
    {
        $jsonData = $this->storeDocument($request);
        if ($jsonData) {
            if($jsonData ==  "Please show the document type"){
                return redirect()->route('documents.create')->with('error', $jsonData);
            }
            elseif($jsonData ==  'Error'){
                return redirect()->route('error');
            }elseif($jsonData == null){
                return redirect()->route('login');
            }else{
                return redirect()->route('documents.index')->with('success',"Document added successfully");
            }
        } else{
            return redirect()->route('login');
        }
    }
    
    public function show($id)
    {
        $document =  $this->getDocument($id);
        if($document == 'Error'){
            return redirect()->route('error');
        }
        $url = 'https://api.odms.savannah.ug';
        if ($document) {
            return view('documents.show', compact(['document'],'url'));
        } else {
            return redirect()->route('login');
        }
    }

    public function update(Request $request, Document $document)
    {
        $data = $this->validateData($request);
        if($request->hasFile('company_document') && $request->file('company_document')->isValid()) {
            $document->clearMediaCollection('company_document');
            $document->addMediaFromRequest('company_document')->toMediaCollection('company_document');
        }
        $document->update($data);
        return redirect()->route('documents.show', $document)->with('success', $document->title . ' updated successfully.');
    }

    public function destroy($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/delete/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url);
            }catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully');
    }

    public function storeDocument($request)
    {
        $userId = null;
        if (Session::get('employee_details')) {
            $userId = Session::get('employee_details')['id'];
        }
        $validatedData = $request->validate([
            'related_project' => ['required','integer'],
            'category' => ['required','string']
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/add';
        $data = [];
        if($request->category == "DEPARTMENT DOCUMENTS") {
            $uploaded_document_category = $request->category == "DEPARTMENT DOCUMENTS" ? 3 : 1;
            $related_department = $request->category == "DEPARTMENT DOCUMENTS" ? 1 : null;
        } elseif($request->category == "PROJECT DOCUMENTS") {
            $uploaded_document_category = $request->category == "PROJECT DOCUMENTS" ? 3 : 1;
            $related_department = $request->category == "PROJECT DOCUMENTS" ? 1 : null;
        }
        $fileName = $request->file->getClientOriginalName();
        $data['file_name'] = $request->file_name;
        $data['description'] = $request->description;
        $data['added_by'] = $userId;
        $data['uploaded_document_type'] = $request->category;
        $data['related_project'] = $request->related_project;
        $data['uploaded_document_category'] = $uploaded_document_category;
        $data['related_department'] = $related_department;

        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->attach(
                    'file_path', file_get_contents($request->file), $fileName
                )->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getDocCategories() 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_categories?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            }catch (\Throwable $error) {
                return 'Error';
            }
        } else {
           return;
        }
    }

    public function getDocTypes() 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_types?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            return $jsonData['data'];
            }catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getDocument($id) 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/get/'. $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            }catch (\Throwable $error) {
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

