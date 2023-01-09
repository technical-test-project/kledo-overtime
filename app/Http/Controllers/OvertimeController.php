<?php

namespace App\Http\Controllers;

use App\Http\Requests\Overtime\CalculateRequest;
use App\Http\Requests\Overtime\StoreRequest;
use App\Repositories\Overtime\OvertimeRepository;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    private OvertimeRepository $overtimeRepository;

    public function __construct(OvertimeRepository $overtimeRepository)
    {
        $this->overtimeRepository = $overtimeRepository;
    }

    /**
     * @OA\Post(
     *     tags={"Overtime"},
     *     path="/api/overtimes",
     *     summary="Insert a data Overtime",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="employee_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string",
     *                     default="2023-01-10"
     *                 ),
     *                 @OA\Property(
     *                     property="time_started",
     *                     type="string",
     *                     default="10:30"
     *                 ),
     *                 @OA\Property(
     *                     property="time_ended",
     *                     type="string",
     *                     default="11:25"
     *                 ),
     *                 example={"employee_id": 1, "date": "2023-01-10", "time_started": "10:30", "time_ended": "11:25"},
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"message": "Data Overtime berhasil dibuat", "data": {"employee_id" : "1", "date" : "2023-01-11", "time_started": "11:28", "time_ended": "11:58","updated_at": "2023-01-09T17:28:14.000000Z", "created_at": "2023-01-09T17:28:14.000000Z"}}, summary="Created Successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result1", value={"message": "Unprocessable Content", "errors": {"employee_id" : "Employee Id harus diisi"}}, summary="Unprocessable Content - Rule [Employee Id] required"),
     *             @OA\Examples(example="result2", value={"message": "Unprocessable Content", "errors": {"employee_id" : "Employee Id harus berupa bilangan bulat"}}, summary="Unprocessable Content - Rule [Employee Id] integer"),
     *             @OA\Examples(example="result3", value={"message": "Unprocessable Content", "errors": {"employee_id" : "Employee Id tidak memiliki id referensi pada tabel Employee"}}, summary="Unprocessable Content - Rule [Employee Id] exists"),
     *
     *             @OA\Examples(example="result4", value={"message": "Unprocessable Content", "errors": {"date" : "Date harus diisi"}}, summary="Unprocessable Content - Rule [Date] required"),
     *             @OA\Examples(example="result5", value={"message": "Unprocessable Content", "errors": {"date" : "Date tidak sesuai dengan format tanggal [Y-m-d]"}}, summary="Unprocessable Content - Rule [Date] date"),
     *             @OA\Examples(example="result6", value={"message": "Unprocessable Content", "errors": {"date" : "Date sudah terdaftar, tidak bisa mendaftarkan tanggal yang sama untuk satu employee"}}, summary="Unprocessable Content - Rule [Date] unique"),
     *
     *             @OA\Examples(example="result7", value={"message": "Unprocessable Content", "errors": {"time_started" : "Time Started harus diisi"}}, summary="Unprocessable Content - Rule [Time Started] required"),
     *             @OA\Examples(example="result8", value={"message": "Unprocessable Content", "errors": {"time_started" : "Time Started tidak sesuai dengan format [Y-m-d]"}}, summary="Unprocessable Content - Rule [Time Started] date_format"),
     *             @OA\Examples(example="result9", value={"message": "Unprocessable Content", "errors": {"time_started" : "Time Started tidak boleh lebih dari time_ended"}}, summary="Unprocessable Content - Rule [Time Started] before"),
     *
     *             @OA\Examples(example="result10", value={"message": "Unprocessable Content", "errors": {"time_ended" : "Time End harus diisi"}}, summary="Unprocessable Content - Rule [Time End] required"),
     *             @OA\Examples(example="result11", value={"message": "Unprocessable Content", "errors": {"time_ended" : "Time End tidak sesuai dengan format [Y-m-d]"}}, summary="Unprocessable Content - Rule [Time End] date_format"),
     *             @OA\Examples(example="result12", value={"message": "Unprocessable Content", "errors": {"time_ended" : "Time End tidak boleh lebih dari time_started"}}, summary="Unprocessable Content - Rule [Time End] after"),
     *
     *         ),
     *     ),
     * )
     */


    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->overtimeRepository->store($request);

        /**
         * Helpers -> resJson
         */
        return resJson([
            'message' => $response->message,
            'data'    => $response->data ?? null,
        ], $response->status);
    }


    /**
     * @OA\Get (
     *     tags={"Overtime"},
     *     path="/api/overtime-pays/calculate",
     *     summary="Calculate Overtime Pays",
     *     @OA\Parameter (
     *         description="Parameter with mutliple examples",
     *         in="query",
     *         name="month",
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="2023-01", summary="Month [Y-m]"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={"message":"OK","data":{{"id":1,"name":"udin1","salary":2000000,"overtimes":{{"id":1,"date":"2023-01-04","time_started":"11:28:00","time_ended":"12:48:00","overtime_duration":"1 Jam"},{"id":2,"date":"2023-01-04","time_started":"10:28:00","time_ended":"12:48:00","overtime_duration":"2 Jam"}},"overtime_duration_total":3,"amount":34682}}}, summary="Showed Successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result1", value={"message": "Unprocessable Content", "errors": {"month" : "Month tidak sesuai dengan format [Y-m]"}}, summary="Unprocessable Content - Rule [Month] date_format"),
     *         ),
     *     ),
     * )
     */
    public function calculate(CalculateRequest $request): \Illuminate\Http\JsonResponse
    {
        $response = $this->overtimeRepository->calculate($request);

        /**
         * Helpers -> resJson
         */
        return resJson([
            'message' => $response->message,
            'data'    => $response->data ?? null,
        ], $response->status);
    }
}
