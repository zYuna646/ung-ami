<?php

namespace App\Helpers;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\Program;
use App\Models\Unit;

class ModelHelper
{
    public static function getModelByRequest($request)
    {
        switch ($request->unit) {
            case 'Fakultas':
                return Faculty::where('faculty_name', $request->faculty ?? null)->first();
            case 'Jurusan':
                return Department::where('department_name', $request->department ?? null)->first();
            case 'Program Studi':
                return Program::where('program_name', $request->program ?? null)->first();
            default:
                return Unit::where('unit_name', $request->unit ?? null)->first();
        }
    }
}
