<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Employee;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth:api',
        ];
    }

    /**
     * Display user profile.
     */
    public function index()
    {
        $user = Employee::where('account_id', Auth::user()->id)->first();

        return response()->json([
            'message' => 'Successfully fetch record.',
            'data' => new ProfileResource($user->load(['role', 'account']))
        ], 200);
    }

    /**
     * Update user profile.
     */
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = Employee::where('account_id', Auth::user()->id)->first();

            $user->update($request->except(['password']));
            $user->account()->update($request->except(['phone', 'address']));

            return response()->json([
                'message' => 'Record successfully updated.',
                'data' => new ProfileResource($user->load(['role', 'account']))
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
