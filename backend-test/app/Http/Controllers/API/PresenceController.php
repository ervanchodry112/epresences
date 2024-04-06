<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovePresenceRequest;
use App\Http\Requests\StorePresenceRequest;
use App\Http\Resources\PresenceResource;
use App\Models\Epresence;
use Exception;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/presence",
     *      tags={"Presence"},
     *      summary="Get user Presences list",
     *      operationId="getPresences",
     *
     *      @OA\Response(
     *          response="default",
     *          description="Return list of user presences",
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
    public function index()
    {
        $presences = request()->user()->presences()->where('type', '=', 'IN')->get();

        return PresenceResource::collection($presences);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/presence",
     *      tags={"Presence"},
     *      summary="Create presence data",
     *      description="Input type and time presence here",
     *      operationId="createPresence",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     enum={"IN", "OUT"}
     *                 ),
     *                 @OA\Property(
     *                     property="waktu",
     *                     type="string"
     *                 ),
     *                 example={"type": "IN", "waktu": "2024-04-06 08:00:00"}
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
     *      ),
     *      security={
     *          {"sanctum": {}}
     *      }
     * )
     */
    public function store(StorePresenceRequest $request)
    {
        $presence = $request->user()->presences()->where('type', $request->type)->whereDate('waktu', now()->toDateTimeString())->get()->toArray();
        if (!empty($presence)) {
            $response = [
                'status'    => 409,
                'message'   => 'Anda sudah melakukan presensi hari ini!'
            ];
            return response($response, 409);
        }

        try {
            $data = $request->validated();
            $data['id_users'] = $request->user()->id;

            $presence = new Epresence($data);

            $presence->createPresence();

            $presence->refresh();

            $response = [
                'status'    => 201,
                'message'   => 'Created',
                'data'      => $presence->toArray(),
            ];
            return response($response, 201);
        } catch (Exception $e) {
            $reponse = [
                'status'    => 500,
                'message'   => $e->getMessage(),
            ];

            return response($reponse, 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/presence/{presence}",
     *      tags={"Presence"},
     *      summary="Approve presence",
     *      description="Input presence id here",
     *      operationId="approvePresence",
     *      @OA\Parameter(
     *          name="presence",
     *          in="path",
     *          description="ID presence",

     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="default",
     *          description="Return approved presence data",
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
    public function update(Request $request, Epresence $presence)
    {
        try {
            $presence->approvePresence();

            $response = [
                'status'    => 200,
                'message'   => 'Success',
                'data'      => $presence->toArray(),
            ];

            return response($response);
        } catch (Exception $e) {
            $response = [
                'status'    => 500,
                'message'   => $e->getMessage(),
            ];
            return response($response);
        }
    }

}
