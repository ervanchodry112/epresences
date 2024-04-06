<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      tags={"Authorization"},
     *      summary="Get Authorization Token",
     *      description="Enter your credential here",
     *      operationId="login",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "example@email.com", "password": "123456"}
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="return authorization token",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user_data = User::getUserWithToken($request->email);

            $response = [
                'message'   => 'Success',
                'data'      => $user_data,
            ];

            return response($response, 200, ['content-type' => 'application/json']);
        }
    }
}
