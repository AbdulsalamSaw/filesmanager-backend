<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Log;

class APIReportController extends Controller
{
    public function countFile(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $fileCount = File::where('manager_id', $user->manager_id)->count();
            Log::info('File count: ' . $fileCount);
            return response()->json([
                'success' => true,
                'message' => 'Successfully',
                'file_count' => $fileCount
            ], 200);
        } catch (Exception $e) {
            Log::error('Error counting files: ' . $e->getMessage());
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

    public function countUser(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $userCount = User::where('manager_id', $user->manager_id)->count();
            Log::info('User count: ' . $userCount);
            return response()->json([
                'success' => true,
                'message' => 'Successfully',
                'user_count' => $userCount - 1
            ], 200);
        } catch (Exception $e) {
            Log::error('Error counting users: ' . $e->getMessage());
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

    public function reportFileUser(Request $request)
    {
       /* $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }*/

        try {
           // $manager = User::findOrFail($user->id);
            $files = File::with(['user' => function ($query) {
                $query->select('id', 'name');
            }])->where('manager_id', $request->manager_id)->orderBy('created_at', 'desc')
            ->get(['id', 'label', 'file_name', 'file_size', 'file_written','file_type', 'user_id', 'created_at']);

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

    public function reportUser(Request $request)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $allUser = User::where('manager_id', $user->manager_id)->get(['id', 'name', 'email', 'created_at']);

            Log::info('Users retrieved successfully');
            return response()->json([
                'success' => true,
                'message' => 'Successfully',
                'users' => $allUser
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving users: ' . $e->getMessage());
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

    public function deleteUser(Request $request, $id)
    {
        $user = $request->user('sanctum');
        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        try {
            $deleteUser = User::where('manager_id', $user->manager_id)->where('id', $id)->first();
            Log::warning("Delete employee with ID: $id");
            $deleteUser->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully',
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting employee: ' . $e->getMessage());
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
