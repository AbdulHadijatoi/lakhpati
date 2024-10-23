<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Comuna;
use App\Models\Contest;
use App\Models\Participant;
use App\Models\Population;
use App\Models\Sector;
use App\Models\Setting;
use App\Models\TypeOfFault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends AppBaseController {
    
    public function getTermsConditions() {
        $data = Setting::where('key','terms')->first();

        return $this->sendDataResponse($data);
    }
     
}
