<?php

namespace App\Http\Controllers;

use App\Services\NutritionService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class NutritionController 
{
    private $nutritionservice;
    public function __construct(NutritionService $nutritionservice) {
        $this->nutritionservice = $nutritionservice;
    }
    
    public function getnutrition()
    {
        return $this->nutritionservice->get_nutrition();
    }

}