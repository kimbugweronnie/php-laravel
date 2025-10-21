<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Date;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index', ['orders' => OrderResource::collection(Order::with('cart_items'))]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        

       
    }

    /**
     * Store a newly created order along side cart_tems
     */
    public function store(Request $request)
    {
        $itemsCount = 0;
        $totalAmount = 0;

        foreach ($request->items as $item) {
            $totalAmount += $item->price * $item->quantity;
            $itemsCount++;
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'completed_at' => Date::now(),
            'items' => $request->items,
            'total_amount' => $totalAmount,
            'itemsCount' => $itemsCount,
        ]);

        foreach ($request->items as $item) {
            CartItem::create([
                'product' => $request->product,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'order_id' => $order->id,
            ]);
        }

        return new OrderResource($order);
    }

    /**
     * Fetching time diffrence
     */
    public function getTimeDiffence($id1,$id2) :int
    {
        $aCompletedAt = Order::where('id', $id1)
        ->where('status', 'completed')
        ->orderByDesc('completed_at')
        ->select('completed_at')
        ->first();

        $bCompletedAt = Order::where('id', $id2)
        ->where('status', 'completed')
        ->orderByDesc('completed_at')
        ->select('completed_at')
        ->first();

        return $bCompletedAt['completed_at'] - $aCompletedAt['completed_at'];
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function collectionTest($arra1,$arra2)
    {
        $employees = [
            ['name' => 'John', 'city' => 'Dallas'],
            ['name' => 'Jane', 'city' => 'Austin'],
            ['name' => 'Jake', 'city' => 'Dallas'],
            ['name' => 'Jill', 'city' => 'Dallas'],
        ];
        
        $offices = [
            ['office' => 'Dallas HQ', 'city' => 'Dallas'],
            ['office' => 'Dallas South', 'city' => 'Dallas'],
            ['office' => 'Austin Branch', 'city' => 'Austin'],
        ];
        
        $output = [
            "Dallas" => [
                "Dallas HQ" => ["John", "Jake", "Jill"],
                "Dallas South" => ["John", "Jake", "Jill"],
            ],
            "Austin" => [
                "Austin Branch" => ["Jane"],
            ],
        ];

        $output =[];

        foreach ($offices as $office => $value) {
            foreach ($employees as $employee[1] => $city) {
                if($office[$value] ==  $employee[1][$city] )
                array_push($output,[ $office['$value'] => $employee[1][$city]  ]);

            }  
        }
        return $output;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
