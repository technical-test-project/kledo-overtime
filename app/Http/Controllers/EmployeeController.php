<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreRequest;
use App\Repositories\Employee\EmployeeRepository;

class EmployeeController extends Controller
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @OA\Post(
     *     tags={"Employee"},
     *     path="/api/employees",
     *     summary="Insert a data employee",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     default="Budi"
     *                 ),
     *                 @OA\Property(
     *                     property="salary",
     *                     oneOf={
     *                     	   @OA\Schema(type="integer"),
     *                     },
     *                     default=2000000
     *                 ),
     *                 example={"name": "Budi", "salary": 2000000},
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"message": "Data Employee berhasil dibuat", "data": {"name" : "Budi", "salary" : "2000000", "updated_at": "2023-01-09T15:23:26.000000Z", "created_at": "2023-01-09T15:23:26.000000Z", "id": 1}}, summary="Created Successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result1", value={"message": "Unprocessable Content", "errors": {"name" : "Name harus diisi"}}, summary="Unprocessable Content - Rule [Name] required"),
     *             @OA\Examples(example="result2", value={"message": "Unprocessable Content", "errors": {"name" : "Name harus berupa string"}}, summary="Unprocessable Content - Rule [Name] string"),
     *             @OA\Examples(example="result3", value={"message": "Unprocessable Content", "errors": {"name" : "Name harus memiliki minimum 2 karakter"}}, summary="Unprocessable Content - Rule [Name] min"),
     *             @OA\Examples(example="result4", value={"message": "Unprocessable Content", "errors": {"name" : "Name sudah terdaftar"}}, summary="Unprocessable Content - Rule [Name] unique"),
     *
     *             @OA\Examples(example="result5", value={"message": "Unprocessable Content", "errors": {"salary" : "Salary harus diisi"}}, summary="Unprocessable Content - Rule [Salary] required"),
     *             @OA\Examples(example="result6", value={"message": "Unprocessable Content", "errors": {"salary" : "Salary harus berupa bilangan bulat"}}, summary="Unprocessable Content - Rule [Salary] integer"),
     *             @OA\Examples(example="result7", value={"message": "Unprocessable Content", "errors": {"salary" : "Salary harus memiliki nilai minimum 2.000.000"}}, summary="Unprocessable Content - Rule [Salary] min"),
     *             @OA\Examples(example="result8", value={"message": "Unprocessable Content", "errors": {"salary" : "Salary harus memiliki nilai maksimum 10.000.000"}}, summary="Unprocessable Content - Rule [Salary] max"),
     *         ),
     *     ),
     * )
     */

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->employeeRepository->store($request);

        /**
         * Helpers -> resJson
         */
        return resJson([
            'message' => $response->message,
            'data'    => $response->data ?? null,
        ], $response->status);
    }
}
