<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OvertimeControllerTest extends TestCase
{
    public function testApiStoreOvertimeAssertCreated()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);
        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date' => '2023-01-10',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertCreated();
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleEmployeeIdRequired()
    {
        $response = $this->post('/api/overtimes', [
            'date' => '2023-01-10',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'employee_id' => "Employee id harus diisi",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleEmployeeIdInteger()
    {
        $response = $this->post('/api/overtimes', [
            'employee_id' => "status",
            'date' => '2023-01-10',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'employee_id' => "Employee id harus berupa bilangan bulat",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleEmployeeIdExists()
    {
        $response = $this->post('/api/overtimes', [
            'employee_id' => 1,
            'date' => '2023-01-10',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'employee_id' => "Employee id tidak memiliki id referensi pada tabel Employee",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleDateRequired()
    {
        $response = $this->post('/api/overtimes', [
            'employee_id' => 1,
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'date' => "Date harus diisi",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleDateDate()
    {
        $response = $this->post('/api/overtimes', [
            'employee_id' => 1,
            'date' => 'adada',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'date' => "Date tidak sesuai dengan format tanggal [Y-m-d]",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleDateUnique()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date' => '2023-01-31',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date' => '2023-01-31',
            'time_started' => '10:25',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'date' => "Date sudah terdaftar, tidak bisa mendaftarkan tanggal yang sama untuk satu employee",
                ]
            ]);
    }


    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeStartedRequired()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_ended' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_started' => "Time started harus diisi",
                ]
            ]);
    }


    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeStartedDateFormat()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_started' => '11:26:35',
            'time_ended' => '11:28',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_started' => "Time started tidak sesuai dengan format [H:i]",
                ]
            ]);
    }


    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeStartedDateBefore()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_started' => '11:29',
            'time_ended' => '11:28',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_started' => "Time started tidak boleh lebih dari [time ended]",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeEndedRequired()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_started' => '11:26',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_ended' => "Time ended harus diisi",
                ]
            ]);
    }


    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeEndedDateFormat()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_started' => '11:20',
            'time_ended' => '11:26:35',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_ended' => "Time ended tidak sesuai dengan format [H:i]",
                ]
            ]);
    }

    public function testApiStoreOvertimeAssertUnprocessableRuleDateTimeEndedDateAfter()
    {
        $employee = Employee::create([
            'name' => $this->faker()->unique()->name,
            'salary' => $this->faker()->numberBetween(2000000, 10000000)
        ]);

        $response = $this->post('/api/overtimes', [
            'employee_id' => $employee->id,
            'date'       => '2023-01-31',
            'time_started' => '11:29',
            'time_ended' => '11:28',
            'updated_at' => "2023-01-09T17:28:14.000000Z",
            "created_at" => "2023-01-09T17:28:14.000000Z"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'time_ended' => "Time ended tidak boleh kurang dari [time started]",
                ]
            ]);
    }

    public function testApiStoreOvertimePaysCalculateAssertOk()
    {
        $response = $this->get('/api/overtime-pays/calculate?month=2023-01');

        $response->assertOk()
            ->assertJson([
                'message' => 'OK',
                'data' => []
            ]);
    }

    public function testApiStoreOvertimePaysCalculateAssertUnprocessableRuleMonthDateFormat()
    {

        $response = $this->get('/api/overtime-pays/calculate?month=2023-01-01');

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'month' => "Month tidak sesuai dengan format [Y-m]",
                ]
            ]);
    }

}
