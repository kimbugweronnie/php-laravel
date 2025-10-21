<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
   
class QueryGroupLinkResource extends JsonResource
{
   

    public function toArray($request)
    
    {
        return [
            'data' => QueryResource::collection($this->records()) 
        ];
        
    }
}
