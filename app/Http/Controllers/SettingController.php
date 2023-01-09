<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateRequest;
use App\Repositories\Setting\SettingRepository;

class SettingController extends Controller
{
    private SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @OA\Patch(
     *     tags={"Settings"},
     *     path="/api/settings",
     *     summary="Update a data setting",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="key",
     *                     type="string",
     *                     default="overtime_method"
     *                 ),
     *                 @OA\Property(
     *                     property="value",
     *                     oneOf={
     *                     	   @OA\Schema(type="string"),
     *                     	   @OA\Schema(type="integer"),
     *                     },
     *                     default=1
     *                 ),
     *                 example={"key": "overtime_method", "value": 2},
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"message": "Data setting berhasil diupdate", "data": {}}, summary="Update Successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result2", value={"message": "Unprocessable Content", "errors": {"key" : "Key hanya boleh diisi dengan 'overtime_method'"}}, summary="Unprocessable Content - Rule [Key] in:overtime_method"),
     *             @OA\Examples(example="result3", value={"message": "Unprocessable Content", "errors": {"value" : "Value tidak memiliki id referensi dengan code 'overtime_method'"}}, summary="Unprocessable Content - Rule [Value] exists where code=overtime_method"),
     *         ),
     *     ),
     * )
     */


    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->settingRepository->updateSetting($request);

        /**
         * Helpers -> resJson
         */
        return resJson([
            'message' => $response->message,
            'data'    => $response->data ?? null,
        ], $response->status);
    }
}


