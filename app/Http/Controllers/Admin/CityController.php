<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
   
public function getCities($stateId)
{
    $cities = DB::table('cities')->where('state_id', $stateId)->get();
    return response()->json($cities);
}
}
