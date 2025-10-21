<?php

namespace App\Listeners;

use App\Events\ProcessProductImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Product;

class ProductCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProcessProductImage $event): void
    {
        Product::create([
            'product_code' => '1234412',
            'quantity' => 1222
    
        ]);

    }
}
