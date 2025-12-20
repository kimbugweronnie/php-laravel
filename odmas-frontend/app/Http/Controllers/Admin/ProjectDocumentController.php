<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ProjectDocumentController extends Controller
{
    public function index()
    {
        return view('project_documents.index');
    }

    public function edit($id)
    {
        return view('project_documents.edit', compact('id'));
    }
    
    public function create()
    {
        return view('project_documents.create');
    }
}
