<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Illuminate\Support\Facades\Password;
use App\Notifications\CustomResetPassword;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|same:password'
        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function requestToken(Request $request): JsonResponse
    {
        $request->validate([
            'identity_number' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('identity_number', $request->identity_number)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'identity_number' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        $token = $user->createToken($request->device_name)->plainTextToken;
    
        $response = [
            'user' => [
                'id' => $user->id,
                'name'=> $user->name,
                'role' => $user->role,
                // Add other desired user details
            ],
            'token' => $token,
        ];
    
        return response()->json($response);
    }
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function delete_tokens(Request $request)
    {

        if (!isset($request->device_name)) {
            return response()->json([
                'message' => 'Device name is required'
            ], 400);
        } else {
            $res = DB::statement("delete from personal_access_tokens where tokenable_id=" . $request->user()->id . " and name='" . $request->device_name . "'");

            if ($res)
                return response()->json([
                    'message' => 'Tokens deleted for mentioned user device'
                ]);
            else
                return response()->json([
                    'message' => 'issue while deleting tokens'
                ]);
        }
    }

    public function resetPassword(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email|max:255',
                    'identity_number' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Find the user by identity number
                $user = User::where('identity_number', $request->identity_number)
            ->where('email', $request->email)
            ->first();

                if (!$user) {
                    return response()->json([
                        'message' => 'The Email is not associated with any account'
                    ], 400);
                }

                $status = Password::sendResetLink([
                    'email' => $request->email
                ], function ($user, $token) {
                    $user->notify(new CustomResetPassword($token));
                });

                if ($status === Password::RESET_LINK_SENT) {
                    return response()->json([
                        'message' => 'The reset link has been sent.'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'There is an issue with your email address.'
                    ], 422);
                }
            }
}