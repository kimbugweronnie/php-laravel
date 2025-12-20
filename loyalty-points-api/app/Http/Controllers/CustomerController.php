<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService; 
    }
    
    public function index()
    {
        return $this->customerService->getcustomers();
    }

    public function store(CustomerRequest $request)
    {
        return $this->customerService->store($request->validated(),$request->email,$request->phone_number,$request->phone_prefix,$request->password);
    }

    public function getOtp(Request $request)
    {
        return $this->customerService->saveotp($request->id);
    }

    public function verifyOtp(Request $request)
    {
        return $this->customerService->verifyotp($request->id,$request->otp);
    }

    public function show($id)
    {
        return $this->customerService->getcustomer($id);
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        return $this->customerService->updateCustomer($request,$id);
    }

    public function destroy($id)
    {
        return $this->customerService->destroy($id);
    }
}
