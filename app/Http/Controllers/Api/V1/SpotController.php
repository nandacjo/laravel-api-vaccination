<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\Spot;
use App\Models\SpotVaccine;
use App\Models\Vaccination;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function spotVaccines(Request $request)
    {
        $society = Society::where(['login_tokens' => $request->query('token')])->first();
        $vaccines = Vaccine::all();

        return response()->json([
            'spots' => Spot::where(['regional_id' => $society->regional_id])->get()->map(function (Spot $spot) use ($vaccines) {
                $spotVaccines = [];
                foreach ($vaccines as $vaccine) {
                    $isAvailable = SpotVaccine::where('spot_id', $spot->id)
                        ->where('vaccine_id', $vaccine->id)
                        ->exists();
                    $spotVaccines[$vaccine->name] = $isAvailable;
                }
                return [
                    'id' => $spot->id,
                    'name' => $spot->name,
                    'address' => $spot->address,
                    'serve' => $spot->serve,
                    'capacity' => $spot->capacity,
                    'available_vaccines' => $spotVaccines
                ];
            })
        ], 200);
    }

    public function spotDetail(Request $request, $spot_id)
    {
        $tanggal = $request->query('date') ?? date('Y-m-d');
        $spot = Spot::where('id', $spot_id)->first();

        return response()->json([
            'date' => $tanggal,
            'spot' => [
                'id' => $spot->id,
                'name' => $spot->name,
                'address' => $spot->address,
                'serve' => $spot->serve,
                'capacity' => $spot->capacity,
            ],
            'vaccinations_count' => Vaccination::where(['spot_id' => $spot_id, 'date' => $tanggal])->count(),
        ], 200);
    }
}








// $spot_vaccines[$vaccine] = SpotVaccine::where(['spot_id' => $spot->id, 'vaccine_id' => $vaccine->id])->count() > 0;
