<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileLocation;
use App\Models\File;
use Log;
use Illuminate\Database\QueryException;

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
        try {
            $user = $request->user('sanctum');
            if (!$user) {
                return response()->json(['error' => 'Invalid token.'], 401);
            }
    
            $model = new FileLocation;
            $model->file_lable = $request->file_lable;
            $model->file_name = $request->file_name;
            $model->room_number = $request->room_number;
            $model->shelf_number = $request->shelf_number;
            $model->cabinet_number = $request->cabinet_number;
            $model->user_id = $user->id;
            $model->manager_id = $user->manager_id;
            $model->file_written =  $request->file_written;


            $model->save();
       
            if ($model) {
                // Data saved successfully
                return response()->json(['message' => 'Data saved successfully']);
            }
        } catch (QueryException $e) {
            // Handle the database query exception
            Log::error("Error saving data in file_location: " . $e->getMessage());
    
            $statusCode = 500;
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                $statusCode = $e->getCode();
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        }
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
