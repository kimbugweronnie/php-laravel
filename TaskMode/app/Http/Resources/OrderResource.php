<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CartItem;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       
          return [
            'order_id' => $this->id,
            'customer_name' => $this->customer_name,
            'total_amount' => $this->total_amount,
            'items_count' => $this->itemsCount,
            'last_added_to_cart' => CartItem::where('order_id', $this->id)
            ->orderByDesc('created_at')
            ->first(),
            'items' => $this->items,
            'completed_order_exists' => $this->status
          ];
        
    }
}
