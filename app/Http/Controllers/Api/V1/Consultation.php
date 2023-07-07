<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Consultation as ModelsConsultation;
use App\Models\Society;
use Illuminate\Http\Request;

class Consultation extends Controller
{

    public function index(Request $request)
    {
        $society = Society::where(['login_tokens' => $request->query('token')])->first();

        return response()->json([
            "data" => [
                'consultations' => ModelsConsultation::where(['society_id' => $society->id])
                    ->get()->map(function (ModelsConsultation $consul) {

                        $docter = $consul->docter;

                        return [
                            'id' => $consul->id,
                            'status' => $consul->status,
                            'disease_history' => $consul->disease_history,
                            'current_symptoms' => $consul->current_symptoms,
                            'doctor_notes' => $consul->doctor_notes,
                            'docter' => $docter ?? null
                        ];
                    }),
                'code' => 200,
                'status' => 'Ok'
            ]
        ], 200);
    }

    public function requestConsultations(Request $request)
    {
        $society = Society::where(['login_tokens' => $request->query('token')])->first();
        $consul = new ModelsConsultation([
            'society_id' => $society->id,
            'disease_history' => $request->disease_history ?? null,
            'current_symptoms' => $request->current_symptoms ?? null
        ]);

        if ($consul->save()) {
            return response()->json([
                'message' => 'Request consulation sent succesfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Request consulation sent failed'
            ], 401);
        }
    }
}
