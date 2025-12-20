@section('content')

@push('styles')
    <style>
        table, th, td {
            border: 2px solid #0a0a0a !important;
        }
       
    </style>
@endpush

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="border bg-white rounded-3 shadow px-4 py-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="9">
                                <div class="text-center pb-4">
                                    <div class="fs-3 text-uppercase">Uganda episcopal conference - Uganda catholic secretariat</div> 
                                    <div class="fs-3 text-uppercase">Uganda Catholic medical bureau</div>
                                    <div class="fs-3 text-uppercase">FLASH PROJECT</div>
                                    <div class="fs-3 text-uppercase">2345</div>
                                    <div class="fs-3 text-uppercase">PROCUREMENT REQUISITION</div>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="9"> Procurement Reference Number (Refer to the Procurement Guidelines)</th>
                        </tr>
                        <tr>
                            <th colspan="2">PD Entity Code:</th>
                            <th colspan="2">Wrks/Srvcs/Supplies?</th>
                            <th class="text-capitalize" colspan="2">Budget Year</th>
                            <th>Sequence Number</th>
                            <th>ITB Number</th>
                            <th>Contract Number</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td>{{ $request['entity_code'] }}</td>
                            <td></td>
                            <td>{{ $request['supplies'] }}</td>
                            <td></td>
                            <td>{{ $request['budget_year'] }}</td>
                            <td></td>
                            <td>{{ $request['sequence_number'] }}</td>
                            <td>{{ $request['itb_number'] }}</td>
                            <td>{{ $request['contract_number'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase" colspan="9">Subject of procurement: {{ $jsonData['data']['title'] }} </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase" colspan="2">Location for delivery: </td>
                            <td colspan="3"> {{ $jsonData['data']['location_for_delivery'] }}</td>
                            <td class="fw-bold text-capitalize" colspan="2">Date required: </td>
                            <td colspan="2">{{ $jsonData['data']['date'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-capitalize">Item No.</td>
                            <td class="fw-bold text-capitalize" colspan="4">Description</td>
                            <td class="fw-bold text-capitalize">Quantity</td>
                            <td class="fw-bold text-capitalize">Unit of Measure</td>
                            <td class="fw-bold text-capitalize">Estimated Unit Cost</td>
                            <td class="fw-bold text-capitalize">Estimated Total Cost (Ushs)</td>
                        </tr>
                        @forelse($jsonData['data']['meta_fields'] as $item)
                        <tr>
                            <td>{{count($jsonData['data']['meta_fields'])}}</td>
                            <td colspan="4">{{$item['description']}}</td>
                            <td>{{ $item['quantity']}}</td>
                            <td>{{ $item['unit_of_measure'] }}</td>
                            <td>{{ $item['estimated_unit_cost'] }}</td>
                            <td>{{ $item['estimated_total_cost'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td></td>
                            <td colspan="4"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforelse
                        <tr>
                            <td></td>
                            <td  class="fw-bold text-capitalize"colspan="4">Currency (Ushs):</td>
                            <td></td>
                            <td  class="fw-bold text-capitalize"colspan="2">Estimated Total Cost:</td>
                            <td>{{ $item['estimated_total_cost'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase" colspan="9">Budget code:</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-uppercase">Program</td>
                            <td class="fw-bold text-uppercase">Project</td>
                            <td class="fw-bold text-uppercase">Donor</td>
                            <td class="fw-bold text-uppercase">Activity</td>
                            <td class="fw-bold text-uppercase">Resp/Cost centre</td>
                            <td class="fw-bold text-uppercase">Annual budget</td>
                            <td class="fw-bold text-uppercase">Exp to date</td>
                            <td class="fw-bold text-uppercase">Budget balance</td>
                            <td class="fw-bold text-uppercase">Amount required</td>
                        </tr>
                        <tr>
                            <td>{{ $request['program'] }}</td>
                            <td>{{ $request['project'] }}</td>
                            <td>{{ $request['donor'] }}</td>
                            <td>{{ $request['activity'] }}</td>
                            <td>{{ $request['cost_centre'] }}</td>
                            <td>{{ $request['annual_budget'] }}</td>
                            <td>{{ $request['exp_to_date'] }}</td>
                            <td>{{ $request['budget_balance'] }}</td>
                            <td>{{ $request['amount_required'] }}</td>
                        </tr>
                        <!-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> -->
                        <tr>
                            <td colspan="12">
                                <div class="row mt-4">
                                    <div class="col-2 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize"><tr>
                            <td colspan="12">
                                <div class="row mt-4">
                                    <div class="col-3 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Requested By:</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Name:.......................</span>   
                                        </div>
                                         <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Signature:......................</span>   
                                        </div>
                                         <div class="col-3  fs-4">
                                           
                                            <span class="fw-bold">Date:......................</span>   
                                        </div>
                                        
                                    </div>
                                </div>
                               <div class="row mt-4">
                                    <div class="col-3 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Verified By: (Finance)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Name:.......................</span>   
                                        </div>
                                         <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Signature:......................</span>   
                                        </div>
                                         <div class="col-3  fs-4">
                                           
                                            <span class="fw-bold">Date:......................</span>   
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Approved By: (Program Manager)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Name:.......................</span>   
                                        </div>
                                         <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Signature:......................</span>   
                                        </div>
                                         <div class="col-3  fs-4">
                                           
                                            <span class="fw-bold">Date:......................</span>   
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-3 fs-4">
                                        <div>
                                            <span class="fw-bold text-capitalize">Authorized By: (Executive Secretary)</span> 
                                            </span>
                                        </div>
                                        </div>
                                        <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Name:.......................</span>   
                                        </div>
                                         <div class="col-3 fs-4">
                                           
                                            <span class="fw-bold">Signature:......................</span>   
                                        </div>
                                         <div class="col-3  fs-4">
                                           
                                            <span class="fw-bold">Date:......................</span>   
                                        </div>
                                        
                                    </div>
                                </div>
                            </td>
                        </tr>       
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection