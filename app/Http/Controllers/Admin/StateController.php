<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function getStates($countryId)
    {
        $states = DB::table('states')->where('country_id', $countryId)->get();
        return response()->json($states);
        // Fetch states based on the selected country
       
    }
}
?>