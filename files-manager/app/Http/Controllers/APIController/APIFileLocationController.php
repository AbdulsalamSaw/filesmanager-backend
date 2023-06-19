<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileLocation;
use App\Models\File;

class APIFileLocationController extends Controller
{
   
    public function getFileLocation()
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $location = FileLocation::where('manager_id', $user->manager_id)->select('id', 'room_number', 'cabinet_number', 'shelf_number', 'file_type')->get();

            return response()->json([
                'success' => true,
                'data' => $location,
            ], 200);
        } catch (Exception $e) {
            Log::error("Error getting file location : " . $e->getMessage());

            $statusCode = 500;
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                $statusCode = $e->getCode();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], $statusCode);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

   
    public function store(Request $request)
    {
        
    }

    
    public function show(string $id)
    {
        
    }

   
    public function update(Request $request, string $id)
    {
        
    }

   
    public function destroy(string $id)
    {
       
    }
}
