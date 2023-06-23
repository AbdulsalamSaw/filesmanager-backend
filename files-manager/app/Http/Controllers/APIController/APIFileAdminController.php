<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\FileImported;
use Log;
use Carbon\Carbon;

class APIFileAdminController extends Controller
{
    public function reportFileUserAdmin(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            //$manager = User::findOrFail($user->id);
            $files = File::with(['user' => function ($query) {
                $query->select('id', 'name');
            }])->where('manager_id', $user->manager_id)->get(['id', 'label', 'file_name', 'file_size', 'file_written','file_type', 'user_id', 'created_at']);

            Log::info('Files retrieved successfully');
            return response()->json([
                'success' => true,
                'message' => 'Files retrieved successfully',
                'files' => $files
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving files: ' . $e->getMessage());
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

    public function import(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $file = $request->file('file');
            $path = $file->store('imported-files');
            $fileSize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            Log::warning("Imported file size: $fileSize kb and type: $fileType");
            
            $file = new File;
            $file->label = $request->label;
            $file->file_name = $request->name;
            $file->file_path = $path;
            $file->file_size = $fileSize;
            $file->file_type = $fileType;
            $file->user_id = $user->id;
            $file->manager_id = $user->manager_id;
            $file->file_written =  $request->file_written;
          //  $file->hidden = $request->hidden;
            $file->hidden = false;

            $file->save();

            return response()->json([
                'success' => true,
                'message' => 'File imported successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error importing file: " . $e->getMessage());

            $statusCode = 500;
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                $statusCode = $e->getCode();
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function exportFile(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
      
        try {
            $file = File::where('id', $request->id)->where('manager_id', $user->manager_id)->firstOrFail();
            if ($file) {
                $filePath = storage_path('app/' . $file->file_path);
                $fileLabel = $file->label;
                $fileName = $file->file_name;
                if (file_exists($filePath)) {
                    $headers = [
                        'Content-Type' => 'application/' . $file->file_type,
                        'Content-Disposition' => 'inline; filename="' . $fileName . '"',
                    ];
                    $file = File::where('id', $request->id)->where('manager_id', $user->manager_id)->firstOrFail();
                   // $this->saveFileImported($user,$file);
        
                    return response(file_get_contents($filePath), 200, $headers);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'File not found',
                    ], 404);
                }
            }
        } catch (Exception $e) {
            Log::error("Error exporting file: " . $e->getMessage());

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

    public function deleteFile(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $file = File::where('id', $request->id)->where('manager_id', $user->manager_id)->firstOrFail();
            if ($file) {
                $filePath = storage_path('app/' . $file->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                Log::warning("Deleted file: $file");

                $file->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'File deleted successfully',
                ], 200);
            }
        } catch (Exception $e) {
            Log::error("Error deleting file: " . $e->getMessage());

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


    public function getFileImported(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $fileImported = FileImported::where('manager_id', $user->manager_id)->get();

            return response()->json([
                'success' => true,
                'data' => $fileImported,
            ], 200);
        } catch (Exception $e) {
            Log::error("Error getting file Imported: " . $e->getMessage());

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
}
