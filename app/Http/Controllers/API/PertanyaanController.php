<?php

namespace App\Http\Controllers\API;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

class PertanyaanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/pertanyaan",
     *     summary="Get list of pertanyaan",
     *     tags={"Pertanyaan"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="pty_id", type="integer"),
     *                 @OA\Property(property="pty_pertanyaan", type="string"),
     *                 @OA\Property(property="pty_status", type="integer"),
     *                 @OA\Property(property="pty_isheader", type="integer"),
     *                 @OA\Property(property="pty_isgeneral", type="integer"),
     *                 @OA\Property(property="pty_created_by", type="string"),
     *                 @OA\Property(property="pty_created_date", type="string", format="date-time"),
     *                 @OA\Property(property="pty_modif_by", type="string"),
     *                 @OA\Property(property="pty_modif_date", type="string", format="date-time"),
     *                 @OA\Property(property="ksr_id", type="integer"),
     *                 @OA\Property(property="pty_role_responden", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function listPertanyaan()
    {
        $pertanyaan = Pertanyaan::all();
        return response()->json($pertanyaan, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/pertanyaan/{id}",
     *     summary="Get pertanyaan by ID",
     *     tags={"Pertanyaan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pertanyaan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="pty_id", type="integer"),
     *             @OA\Property(property="pty_pertanyaan", type="string"),
     *             @OA\Property(property="pty_status", type="integer"),
     *             @OA\Property(property="pty_isheader", type="integer"),
     *             @OA\Property(property="pty_isgeneral", type="integer"),
     *             @OA\Property(property="pty_created_by", type="string"),
     *             @OA\Property(property="pty_created_date", type="string", format="date-time"),
     *             @OA\Property(property="pty_modif_by", type="string"),
     *             @OA\Property(property="pty_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="pty_role_responden", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertanyaan not found"
     *     )
     * )
     */
    public function getPertanyaan($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        if (!$pertanyaan) {
            return response()->json(['message' => 'Pertanyaan not found'], 404);
        }
        return response()->json($pertanyaan);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/pertanyaan",
     *     summary="Create new pertanyaan",
     *     tags={"Pertanyaan"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="pty_pertanyaan", type="string"),
     *             @OA\Property(property="pty_status", type="integer"),
     *             @OA\Property(property="pty_isheader", type="integer"),
     *             @OA\Property(property="pty_isgeneral", type="integer"),
     *             @OA\Property(property="pty_created_by", type="string"),
     *             @OA\Property(property="pty_created_date", type="string", format="date-time"),
     *             @OA\Property(property="pty_modif_by", type="string"),
     *             @OA\Property(property="pty_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="pty_role_responden", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pertanyaan created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function createPertanyaan()
    {
        request()->validate([
            'pty_pertanyaan' => 'required|string',
            'pty_status' => 'required|integer',
            'pty_isheader' => 'required|integer',
            'pty_isgeneral' => 'required|integer',
            'pty_created_by' => 'required|string',
            'pty_created_date' => 'nullable|date',
            'pty_modif_by' => 'nullable|string',
            'pty_modif_date' => 'nullable|date',
            'ksr_id' => 'nullable|integer',
            'pty_role_responden' => 'nullable|string'
        ]);

        $pertanyaan = Pertanyaan::create(request()->all());

        return response()->json([
            'message' => 'Pertanyaan created successfully',
            'data' => $pertanyaan
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/pertanyaan/{id}",
     *     summary="Update pertanyaan",
     *     tags={"Pertanyaan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pertanyaan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="pty_pertanyaan", type="string"),
     *             @OA\Property(property="pty_status", type="integer"),
     *             @OA\Property(property="pty_isheader", type="integer"),
     *             @OA\Property(property="pty_isgeneral", type="integer"),
     *             @OA\Property(property="pty_created_by", type="string"),
     *             @OA\Property(property="pty_created_date", type="string", format="date-time"),
     *             @OA\Property(property="pty_modif_by", type="string"),
     *             @OA\Property(property="pty_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="pty_role_responden", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pertanyaan updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertanyaan not found"
     *     )
     * )
     */
    public function updatePertanyaan($id)
    {
        request()->validate([
            'pty_pertanyaan' => 'required|string',
            'pty_status' => 'required|integer',
            'pty_isheader' => 'required|integer',
            'pty_isgeneral' => 'required|integer',
            'pty_created_by' => 'nullable|string',
            'pty_created_date' => 'nullable|date',
            'pty_modif_by' => 'nullable|string',
            'pty_modif_date' => 'nullable|date',
            'ksr_id' => 'nullable|integer',
            'pty_role_responden' => 'nullable|string'
        ]);

        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json([
                'message' => 'Pertanyaan not found'
            ], 404);
        }

        $pertanyaan->update(request()->all());

        return response()->json([
            'message' => 'Pertanyaan updated successfully',
            'data' => $pertanyaan
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/pertanyaan/{id}",
     *     summary="Delete pertanyaan",
     *     tags={"Pertanyaan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID pertanyaan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pertanyaan deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pertanyaan not found"
     *     )
     * )
     */
    public function deletePertanyaan($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        if (!$pertanyaan) {
            return response()->json(['message' => 'Pertanyaan not found'], 404);
        }

        $pertanyaan->delete();
        return response()->json(['message' => 'Pertanyaan deleted successfully']);
    }
}
