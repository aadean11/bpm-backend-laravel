<?php

namespace App\Http\Controllers\API;

use App\Models\KriteriaSurvei;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

class KriteriaSurveiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/kriteria-survei",
     *     summary="Get list of kriteria survei",
     *     tags={"Kriteria Survei"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ksr_id", type="integer"),
     *                 @OA\Property(property="ksr_nama", type="string"),
     *                 @OA\Property(property="ksr_status", type="integer"),
     *                 @OA\Property(property="ksr_created_by", type="string"),
     *                 @OA\Property(property="ksr_created_date", type="string", format="date-time"),
     *                 @OA\Property(property="ksr_modif_by", type="string"),
     *                 @OA\Property(property="ksr_modif_date", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function listKriteriaSurvei()
    {
        $kriteriaSurvei = KriteriaSurvei::all();
        return response()->json($kriteriaSurvei, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/kriteria-survei/{id}",
     *     summary="Get kriteria survei by ID",
     *     tags={"Kriteria Survei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID kriteria survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="ksr_nama", type="string"),
     *             @OA\Property(property="ksr_status", type="integer"),
     *             @OA\Property(property="ksr_created_by", type="string"),
     *             @OA\Property(property="ksr_created_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_modif_by", type="string"),
     *             @OA\Property(property="ksr_modif_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kriteria Survei not found"
     *     )
     * )
     */
    public function getKriteriaSurvei($id)
    {
        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
            return response()->json(['message' => 'Kriteria Survei not found'], 404);
        }
        return response()->json($kriteriaSurvei);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/kriteria-survei",
     *     summary="Create new kriteria survei",
     *     tags={"Kriteria Survei"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ksr_nama", type="string"),
     *             @OA\Property(property="ksr_status", type="integer"),
     *             @OA\Property(property="ksr_created_by", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Kriteria Survei created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function createKriteriaSurvei()
    {
        request()->validate([
            'ksr_nama' => 'required|string|max:50',
            'ksr_status' => 'required|integer',
            'ksr_created_by' => 'nullable|string|max:50'
        ]);

        $kriteriaSurvei = KriteriaSurvei::create([
            'ksr_nama' => request('ksr_nama'),
            'ksr_status' => request('ksr_status'),
            'ksr_created_by' => request('ksr_created_by'),
            'ksr_created_date' => now()
        ]);

        return response()->json([
            'message' => 'Kriteria Survei created successfully',
            'data' => $kriteriaSurvei
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/kriteria-survei/{id}",
     *     summary="Update kriteria survei",
     *     tags={"Kriteria Survei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID kriteria survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ksr_nama", type="string"),
     *             @OA\Property(property="ksr_status", type="integer"),
     *             @OA\Property(property="ksr_modif_by", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kriteria Survei updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kriteria Survei not found"
     *     )
     * )
     */
    public function updateKriteriaSurvei($id)
    {
        request()->validate([
            'ksr_nama' => 'required|string|max:50',
            'ksr_status' => 'required|integer',
            'ksr_modif_by' => 'nullable|string|max:50'
        ]);

        $kriteriaSurvei = KriteriaSurvei::find($id);

        if (!$kriteriaSurvei) {
            return response()->json([
                'message' => 'Kriteria Survei not found'
            ], 404);
        }

        $kriteriaSurvei->update([
            'ksr_nama' => request('ksr_nama'),
            'ksr_status' => request('ksr_status'),
            'ksr_modif_by' => request('ksr_modif_by'),
            'ksr_modif_date' => now()
        ]);

        return response()->json([
            'message' => 'Kriteria Survei updated successfully',
            'data' => $kriteriaSurvei
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/kriteria-survei/{id}",
     *     summary="Delete kriteria survei",
     *     tags={"Kriteria Survei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID kriteria survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kriteria Survei deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kriteria Survei not found"
     *     )
     * )
     */
    public function deleteKriteriaSurvei($id)
    {
        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
            return response()->json(['message' => 'Kriteria Survei not found'], 404);
        }

        $kriteriaSurvei->delete();
        return response()->json(['message' => 'Kriteria Survei deleted successfully']);
    }
}
