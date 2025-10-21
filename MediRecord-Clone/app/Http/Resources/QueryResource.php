<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
   
class QueryResource extends JsonResource
{
   

    public function toArray($request)
    {
        
        return [
            'queryname' => $this->queryname,
            'data' => DB::select($this->querydefinition)

        ];
        
    }
}
