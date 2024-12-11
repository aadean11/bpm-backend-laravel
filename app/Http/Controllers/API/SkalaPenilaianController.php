<?php

namespace App\Http\Controllers\API;

use App\Models\SkalaPenilaian;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

class SkalaPenilaianController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/skala_penilaian",
     *     summary="Get list of skala penilaian",
     *     tags={"SkalaPenilaian"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="skp_id", type="integer"),
     *                 @OA\Property(property="skp_skala", type="integer"),
     *                 @OA\Property(property="skp_deskripsi", type="string"),
     *                 @OA\Property(property="skp_tipe", type="string"),
     *                 @OA\Property(property="skp_status", type="integer"),
     *                 @OA\Property(property="skp_created_by", type="string"),
     *                 @OA\Property(property="skp_created_date", type="string", format="date-time"),
     *                 @OA\Property(property="skp_modif_by", type="string"),
     *                 @OA\Property(property="skp_modif_date", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function listSkalaPenilaian()
    {
        $skalaPenilaian = SkalaPenilaian::all();
        return response()->json($skalaPenilaian, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/skala_penilaian/{id}",
     *     summary="Get skala penilaian by ID",
     *     tags={"SkalaPenilaian"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID skala penilaian",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="skp_id", type="integer"),
     *             @OA\Property(property="skp_skala", type="integer"),
     *             @OA\Property(property="skp_deskripsi", type="string"),
     *             @OA\Property(property="skp_tipe", type="string"),
     *             @OA\Property(property="skp_status", type="integer"),
     *             @OA\Property(property="skp_created_by", type="string"),
     *             @OA\Property(property="skp_created_date", type="string", format="date-time"),
     *             @OA\Property(property="skp_modif_by", type="string"),
     *             @OA\Property(property="skp_modif_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skala Penilaian not found"
     *     )
     * )
     */
    public function getSkalaPenilaian($id)
    {
        $skala = SkalaPenilaian::find($id);
        if (!$skala) {
            return response()->json(['message' => 'Skala Penilaian not found'], 404);
        }
        return response()->json($skala);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/skala_penilaian",
     *     summary="Create new skala penilaian",
     *     tags={"SkalaPenilaian"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="skp_skala", type="integer"),
     *             @OA\Property(property="skp_deskripsi", type="string"),
     *             @OA\Property(property="skp_tipe", type="string"),
     *             @OA\Property(property="skp_status", type="integer"),
     *             @OA\Property(property="skp_created_by", type="string"),
     *             @OA\Property(property="skp_created_date", type="string", format="date-time"),
     *             @OA\Property(property="skp_modif_by", type="string"),
     *             @OA\Property(property="skp_modif_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Skala Penilaian created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function createSkalaPenilaian()
    {
        request()->validate([
            'skp_skala' => 'required|integer',
            'skp_deskripsi' => 'required|string',
            'skp_tipe' => 'required|string',
            'skp_status' => 'required|integer',
            'skp_created_by' => 'nullable|string',
            'skp_created_date' => 'nullable|date',
            'skp_modif_by' => 'nullable|string',
            'skp_modif_date' => 'nullable|date'
        ]);

        $skala = SkalaPenilaian::create(request()->all());

        return response()->json([
            'message' => 'Skala Penilaian created successfully',
            'data' => $skala
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/skala_penilaian/{id}",
     *     summary="Update skala penilaian",
     *     tags={"SkalaPenilaian"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID skala penilaian",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="skp_skala", type="integer"),
     *             @OA\Property(property="skp_deskripsi", type="string"),
     *             @OA\Property(property="skp_tipe", type="string"),
     *             @OA\Property(property="skp_status", type="integer"),
     *             @OA\Property(property="skp_created_by", type="string"),
     *             @OA\Property(property="skp_created_date", type="string", format="date-time"),
     *             @OA\Property(property="skp_modif_by", type="string"),
     *             @OA\Property(property="skp_modif_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skala Penilaian updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skala Penilaian not found"
     *     )
     * )
     */
    public function updateSkalaPenilaian($id)
    {
        request()->validate([
            'skp_skala' => 'required|integer',
            'skp_deskripsi' => 'required|string',
            'skp_tipe' => 'required|string',
            'skp_status' => 'required|integer',
            'skp_created_by' => 'nullable|string',
            'skp_created_date' => 'nullable|date',
            'skp_modif_by' => 'nullable|string',
            'skp_modif_date' => 'nullable|date'
        ]);

        $skala = SkalaPenilaian::find($id);

        if (!$skala) {
            return response()->json([
                'message' => 'Skala Penilaian not found'
            ], 404);
        }

        $skala->update(request()->all());

        return response()->json([
            'message' => 'Skala Penilaian updated successfully',
            'data' => $skala
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/skala_penilaian/{id}",
     *     summary="Delete skala penilaian",
     *     tags={"SkalaPenilaian"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID skala penilaian",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skala Penilaian deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skala Penilaian not found"
     *     )
     * )
     */
    public function deleteSkalaPenilaian($id)
    {
        $skala = SkalaPenilaian::find($id);
        if (!$skala) {
            return response()->json(['message' => 'Skala Penilaian not found'], 404);
        }

        $skala->delete();
        return response()->json(['message' => 'Skala Penilaian deleted successfully']);
    }
}
