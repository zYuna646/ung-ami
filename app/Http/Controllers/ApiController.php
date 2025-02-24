<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Instrument;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Program;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // public function getFakultas()
    // {
    //     try {
    //         $fakultas = Fakultas::with('prodi')->get();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data fakultas berhasil diambil',
    //             'data' => $fakultas
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getProdi()
    {
        try {
            $prodi = Program::with('fakultas')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data prodi berhasil diambil',
                'data' => $prodi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPeriodes()
    {
        try {
            $periode = Periode::with('standard', 'instruments')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data prodi berhasil diambil',
                'data' => $periode
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
