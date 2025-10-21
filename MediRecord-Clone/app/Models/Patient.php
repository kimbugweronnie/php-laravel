<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "patient";
    
    protected $fillable = [
     'creator','date_created','changed_by','date_changed','voided',
     'voided_by','date_voided','void_reason','allergy_status'
    ];
    
    public function get_patients()
    {
        return $this::all(); 
    }

    public function get_patient($id)
    {
        return $this::where('id',$id)->first();
    }
    
    

   
}
