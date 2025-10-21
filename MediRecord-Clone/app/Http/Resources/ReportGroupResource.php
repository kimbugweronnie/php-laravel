<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;

   
class ReportGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    
    public function toArray($request) 
    
    {
        return [ 
            'id' => $this->reportgroupid,
            'reportgroupname' => $this->reportgroupname,
            'ptCheck' => false,
            'reports' => ReportResource::collection($this->reports($this->reportgroupid))  
        ];
       
    }
}
