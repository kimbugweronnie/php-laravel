<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\QueryGroupLink;
use App\Models\QueryGroup;
   
class ReportResource extends JsonResource
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
            'id' => $this->reportid,
            'reportname' => $this->reportname,
            'exceltemplatename' => $this->exceltemplatename,
            'cdCheck' => false,
            'querygroupid' => $this->querygroupid
        ];  
    }
}
