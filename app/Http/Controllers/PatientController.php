namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    public function register(Request $request)
    {
        $response = Http::post('http://41.188.172.204:3033/patient-registration', $request->all());

        $data = $response->json();

        return response()->json([
            'message' => 'successfully',
            'Check_In_Date_And_Time' => $data['Check_In_Date_And_Time'] ?? null,
        ]);
    }
}