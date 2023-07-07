<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Society;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Vaccination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VaccinationController extends Controller
{
    public function registrasi(Request $request)
    {
        $society = Society::where(['login_tokens' => $request->query('token')])->first();
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|date_format:Y-m-d',
            'spot_id' => 'required',
        ], [], ['spot-id' => 'spot']);

        if ($validator->fails()) {
            return response()->json([
                'messagge' => 'Invalid field',
                'error' => $validator->errors(),
            ], 401);
        }

        // cek consultation
        $cekConsultation = Consultation::where(['society_id' => $society->id, 'status' => 'accepted'])
            ->where('docter_id', '!=', null)
            ->first();

        if (!$cekConsultation) {
            return response()->json([
                'message' => 'You consultation must be accepted by doctor before'
            ], 401);
        }

        // cek apakah sudah vaccine
        $cekVaccine = Vaccination::where(['society_id' => $society->id])
            ->orderBy('date', 'asc')
            ->first();

        if (!$cekVaccine) {
            $lastQueue = Vaccination::where(['date' => $request->date, 'spot_id' => $request->spot_id])
                ->orderBy('queue', 'desc')
                ->first();

            $queue = 1;
            if ($lastQueue) {
                $queue = (int)$lastQueue->queue + 1;
            }

            #  Insert ke table vaccination
            $vaccine = new Vaccination([
                'date' => $request->date,
                'spot_id' => $request->spot_id,
                'society_id' => $society->id,
                'queue' => $queue,
            ]);

            $vaccine->save();
            return response()->json([
                'message' => 'First vacciantion registered successful'
            ], 200);
        } else {
            # mencari sudah berapa kali vasin
            $countVaccine = Vaccination::where(['society_id' => $society->id])
                ->orderBy('date', 'asc')
                ->count();

            # cek apakah vaccination sudah dilakukan sebanyak 2x
            if ($countVaccine >= 2) {
                return response()->json([
                    'message' => 'Socity has been 2x vaccinated'
                ], 401);
            }

            # ambil tanggal pertama kali vaksi
            $firstDateVaccine = new Carbon($cekVaccine->date);
            # ambil tanggal kedua vaksin
            $secondDateVaccine = new Carbon($request->date);
            # cek kondisi
            $diff = $firstDateVaccine->diffInDays($secondDateVaccine);

            # cek jarak vaksin ke satu dan kedua lebih dari 30 hari
            if ($diff < 30) {
                return response()->json([
                    'message' => 'Wait at least +30 days from 1st vaccination'
                ], 401);
            }

            $lastQueue = Vaccination::where(['date' => $request->date, 'spot_id' => $request->spot_id])
                ->orderBy('queue', 'desc')
                ->first();

            $queue = 1;
            if ($lastQueue) {
                $queue = (int)$lastQueue->queue + 1;
            }

            #  Insert ke table vaccination
            $vaccine = new Vaccination([
                'date' => $request->date,
                'spot_id' => $request->spot_id,
                'society_id' => $society->id,
                'queue' => $queue,
            ]);

            $vaccine->save();
            return response()->json([
                'message' => 'Second vacciantion registered successful'
            ], 200);
        }
    }
}
