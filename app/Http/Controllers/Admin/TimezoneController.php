<?php 
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimezoneController extends Controller
{
    public function get_time_zone($countryId)
    {
        $country_timezone = DB::table('country_timezone')->where('country_id', $countryId)->get();
        return response()->json($country_timezone);
        // Fetch states based on the selected country
       
    }
}
?>