<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileLocation;
use App\Models\File;
use Log;

class APIFileLocationController extends Controller
{
    public function getFileLocation(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    
        try {
            $locations = FileLocation::with(['file', 'user'])
                ->where('manager_id', $user->manager_id)
                ->get();
    
            return response()->json([
                'success' => true,
                'data' => $locations,
            ], 200);
        } catch (Exception $e) {
            Log::error("Error getting file location: " . $e->getMessage());
    
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
    
    public function store(Request $request)
    {
        try {
            $user = $request->user('sanctum');
            if (!$user) {
                return response()->json(['error' => 'Invalid token.'], 401);
            }
    
            $data = $request->validate([
                'file_lable' => 'required',
                'file_name' => 'required',
                'room_number' => 'required',
                'shelf_number' => 'required',
                'cabinet_number' => 'required',
                'file_written' => 'required',
            ]);
    
            $data['user_id'] = $user->id;
            $data['manager_id'] = $user->manager_id;
    
            $model = FileLocation::create($data);
    
            if ($model) {
                return response()->json(['message' => 'Data saved successfully']);
            }
        } catch (Exception $e) {
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
    
    public function updateFileLocation(Request $request, $id)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    
        try {
            $location = FileLocation::where('id', $id)
                ->where('manager_id', $user->manager_id)
                ->first();
    
            if (!$location) {
                return response()->json(['error' => 'File location not found.'], 404);
            }
    
            $data = $request->validate([
                'file_lable' => 'required',
                'file_name' => 'required',
                'room_number' => 'required',
                'shelf_number' => 'required',
                'cabinet_number' => 'required',
                'file_written' => 'required',
            ]);
    
            $location->update($data);
    
            return response()->json(['message' => 'File location updated successfully.']);
        } catch (Exception $e) {
            Log::error("Error updating file location: " . $e->getMessage());
    
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
    
    public function deleteFileLocation(Request $request, $id)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
    
        try {
            $location = FileLocation::where('id', $id)
                ->where('manager_id', $user->manager_id)
                ->first();
    
            if (!$location) {
                return response()->json(['error' => 'File location not found.'], 404);
            }
    
            $location->delete();
    
            return response()->json(['message' => 'File location deleted successfully.']);
        } catch (Exception $e) {
            Log::error("Error deleting file location: " . $e->getMessage());
    
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
    
}
