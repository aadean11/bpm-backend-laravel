<?php

namespace App\Http\Controllers\API;

use App\Models\TemplateSurvei;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

class TemplateSurveiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/template_survei",
     *     summary="Get list of template survei",
     *     tags={"TemplateSurvei"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="tsu_id", type="integer"),
     *                 @OA\Property(property="tsu_nama", type="string"),
     *                 @OA\Property(property="tsu_status", type="string"),
     *                 @OA\Property(property="tsu_created_by", type="string"),
     *                 @OA\Property(property="tsu_created_date", type="string", format="date-time"),
     *                 @OA\Property(property="tsu_modif_by", type="string"),
     *                 @OA\Property(property="tsu_modif_date", type="string", format="date-time"),
     *                 @OA\Property(property="ksr_id", type="integer"),
     *                 @OA\Property(property="skp_id", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function listTemplateSurvei()
    {
        $templates = TemplateSurvei::all();
        return response()->json($templates, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/template_survei/{id}",
     *     summary="Get template survei by ID",
     *     tags={"TemplateSurvei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID template survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tsu_id", type="integer"),
     *             @OA\Property(property="tsu_nama", type="string"),
     *             @OA\Property(property="tsu_status", type="string"),
     *             @OA\Property(property="tsu_created_by", type="string"),
     *             @OA\Property(property="tsu_created_date", type="string", format="date-time"),
     *             @OA\Property(property="tsu_modif_by", type="string"),
     *             @OA\Property(property="tsu_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="skp_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Template Survei not found"
     *     )
     * )
     */
    public function getTemplateSurvei($id)
    {
        $template = TemplateSurvei::find($id);
        if (!$template) {
            return response()->json(['message' => 'Template Survei not found'], 404);
        }
        return response()->json($template);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/template_survei",
     *     summary="Create new template survei",
     *     tags={"TemplateSurvei"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tsu_nama", type="string"),
     *             @OA\Property(property="tsu_status", type="string"),
     *             @OA\Property(property="tsu_created_by", type="string"),
     *             @OA\Property(property="tsu_created_date", type="string", format="date-time"),
     *             @OA\Property(property="tsu_modif_by", type="string"),
     *             @OA\Property(property="tsu_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="skp_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Template Survei created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function createTemplateSurvei()
    {
        request()->validate([
            'tsu_nama' => 'required|string',
            'tsu_status' => 'nullable|string',
            'tsu_created_by' => 'nullable|string',
            'tsu_created_date' => 'nullable|date',
            'tsu_modif_by' => 'nullable|string',
            'tsu_modif_date' => 'nullable|date',
            'ksr_id' => 'nullable|integer',
            'skp_id' => 'nullable|integer'
        ]);

        $template = TemplateSurvei::create(request()->all());

        return response()->json([
            'message' => 'Template Survei created successfully',
            'data' => $template
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/template_survei/{id}",
     *     summary="Update template survei",
     *     tags={"TemplateSurvei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID template survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tsu_nama", type="string"),
     *             @OA\Property(property="tsu_status", type="string"),
     *             @OA\Property(property="tsu_created_by", type="string"),
     *             @OA\Property(property="tsu_created_date", type="string", format="date-time"),
     *             @OA\Property(property="tsu_modif_by", type="string"),
     *             @OA\Property(property="tsu_modif_date", type="string", format="date-time"),
     *             @OA\Property(property="ksr_id", type="integer"),
     *             @OA\Property(property="skp_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Template Survei updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Template Survei not found"
     *     )
     * )
     */
    public function updateTemplateSurvei($id)
    {
        request()->validate([
            'tsu_nama' => 'required|string',
            'tsu_status' => 'nullable|string',
            'tsu_created_by' => 'nullable|string',
            'tsu_created_date' => 'nullable|date',
            'tsu_modif_by' => 'nullable|string',
            'tsu_modif_date' => 'nullable|date',
            'ksr_id' => 'nullable|integer',
            'skp_id' => 'nullable|integer'
        ]);

        $template = TemplateSurvei::find($id);

        if (!$template) {
            return response()->json([
                'message' => 'Template Survei not found'
            ], 404);
        }

        $template->update(request()->all());

        return response()->json([
            'message' => 'Template Survei updated successfully',
            'data' => $template
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/template_survei/{id}",
     *     summary="Delete template survei",
     *     tags={"TemplateSurvei"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID template survei",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Template Survei deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Template Survei not found"
     *     )
     * )
     */
    public function deleteTemplateSurvei($id)
    {
        $template = TemplateSurvei::find($id);
        if (!$template) {
            return response()->json(['message' => 'Template Survei not found'], 404);
        }

        $template->delete();
        return response()->json(['message' => 'Template Survei deleted successfully']);
    }
}
