<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileLocation;
use App\Models\File;

class APIFileLocationController extends Controller
{
   
    public function getFileLocation(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $locations = FileLocation::with(['file','user'])
            ->where('manager_id', $user->manager_id)
            ->select('room_number', 'cabinet_number', 'shelf_number', 'created_at', 'user_id')
            ->get();
        

            return response()->json([
                'success' => true,
                'data' => $locations,
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
