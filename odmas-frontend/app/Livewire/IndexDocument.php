<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;

class IndexDocument extends Component
{
    public $active_doc = false;
    public $deleted_doc = false;
    public $category = '';
    public $active_docs = [];
    public $deleted_docs = [];
    public $url;

    public function render()
    {
        return view('livewire.index-document');
    }

    public function mount()
    {
        $this->active_doc = true;
        $this->url = 'https://api.odms.savannah.ug';
        $this->category = Session::get('category');
        $this->category = 'department_document';
        $this->reqByCategory();
    }

    public function reqByCategory()
    {
        if ($this->category) {
            Session::put('category', $this->category);
            if ($this->active_doc) {
                $jsonData = $this->getActiveDocs($this->category);
                if ($jsonData) {
                    if ($jsonData == 'Error') {
                        return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                    } else if ($jsonData['status'] == 200) {
                        if($this->category == 'department_document') {
                            $this->active_docs = $jsonData['data'];
                        } elseif($this->category == 'project_general_document') {
                            $this->active_docs = $jsonData['data'];
                        }
                    } else {
                        return redirect()->back()->with('error', $jsonData['error']);
                    }
                } else {
                    return redirect()->back()->with('warning', 'No data available');
                }
            } elseif($this->deleted_doc) {
                $jsonData = $this->getDeletedDocs($this->category);
                if ($jsonData) {
                    if ($jsonData == 'Error') {
                       return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                    } elseif ($jsonData['status'] == 200) {
                        if (!empty($jsonData['data'])) {
                            $this->deleted_docs = $jsonData['data'];
                        } else {
                            return redirect()->back()->with('warning', 'No data available');
                        }
                    } else {
                        return redirect()->back()->with('error', $jsonData['error']);
                    }
                } else {
                  return redirect()->back()->with('warning', 'No data available');
                }
            }
        } else {
            return redirect()->back()->with('warning', 'Please select a category');
        }
    }

    public function handleActiveDoc()
    {
        if ($this->deleted_doc) {
            $this->deleted_doc = false;
        }
        $this->active_doc = true;
        $category = Session::get('category');
        if ($category) {
            $jsonData = $this->getActiveDocs($category);
            if ($jsonData) {
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->active_docs = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                } else {
                    return redirect()->back()->with('error', $jsonData['error']);
                }
            } else {
                return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a Category');
        }
    }

    public function handleDeletedDoc()
    {
        if ($this->active_doc) {
            $this->active_doc = false;
        }
        $this->deleted_doc = true;
        $category = Session::get('category');
        if ($category) {
            $jsonData = $this->getDeletedDocs($category);
            if ($jsonData) {
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                }
                else if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->deleted_docs = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                } else {
                    return redirect()->back()->with('error', $jsonData['error']);
                }
            } else {
               return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a Categoty');
        }
    }

    public function getActiveDocs($category) 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/list?category=' . $category . '&id=1&search=false&status_filter=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getDeletedDocs($category) 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/list?category='. $category .'&id=1&search=false&status_filter=2';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
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