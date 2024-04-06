<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPresencesResource;
use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class KaryawanController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/karyawan",
     *      tags={"Karyawan"},
     *      summary="Get List Karyawan",
     *      operationId="getKaryawan",
     *      @OA\Response(
     *          response="default",
     *          description="Return list of karyawan",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="string"
     *              )
     *          )
     *      ),
     *      security={
     *          {"sanctum": {}}
     *      }
     * )
     */
    public function index(){
        $user = request()->user();
        if(!empty($user->npp_supervisor)){
            throw new UnauthorizedException('Unauthorized');
        }

        return UserResources::collection($user->karyawan);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/karyawan/presences/{user}",
     *      tags={"Karyawan"},
     *      summary="Get List presences of karyawan",
     *      operationId="getKaryawanPresences",
     *      @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="ID User",

     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Return list presences of karyawan",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="string"
     *              )
     *          )
     *      ),
     *      security={
     *          {"sanctum": {}}
     *      }
     * )
     */
    public function presences(User $user){

        if (!empty(request()->user()->npp_supervisor)) {
            throw new UnauthorizedException('Unauthorized');
        }

        return AllPresencesResource::collection($user->presences);
    }
}
