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
        // Extract the area parameter from the request
        $area = $request->area;

        // If the area parameter is not set or doesn't follow the expected format, return null
        if (!$area || !preg_match('/^(\d+)([A-Za-z]+)$/', $area, $matches)) {
            return null;
        }

        // Split the area into the id and the model type
        $id = $matches[1];           // The numeric part (e.g., 5 or 1)
        $modelType = $matches[2];     // The model type part (e.g., Unit, Faculty, etc.)

        // Switch case based on the model type
        switch ($modelType) {
            case 'Faculty':
                return Faculty::find($id);
            case 'Program':
                return Program::find($id);
            case 'Department':
                return Department::find($id);
            default:
                return Unit::find($id);  // Default to Unit if no other type matches
        }
    }
}
