<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    public function testApiStoreEmployeeAssertCreated()
    {
        $response = $this->post('/api/employees', [
            'name' => 'Budi',
            'salary' => 8000000
        ]);

        $response->assertCreated();
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleNameRequire()
    {
        $response = $this->post('/api/employees', [
            'salary' => 8000000
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'name' => "Name harus diisi",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleNameString()
    {
        $response = $this->post('/api/employees', [
            'name' => 10,
            'salary' => 8000000
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'name' => "Name harus berupa string",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleNameMin()
    {
        $response = $this->post('/api/employees', [
            'name' => "A",
            'salary' => 8000000
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'name' => "Name harus memiliki minimum 2 karakter",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleNameUnique()
    {
        $this->post('/api/employees', [
            'name' => "Test",
            'salary' => 8000000
        ]);
        $response = $this->post('/api/employees', [
            'name' => "Test",
            'salary' => 8000000
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'name' => "Name sudah terdaftar",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleSalaryRequired()
    {
        $response = $this->post('/api/employees', [
            'name' => "Test",
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'salary' => "Salary harus diisi",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleSalaryInteger()
    {
        $response = $this->post('/api/employees', [
            'name' => "Test",
            'salary' => "8Jt"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'salary' => "Salary harus berupa bilangan bulat",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleSalaryMin()
    {
        $response = $this->post('/api/employees', [
            'name' => "Test",
            'salary' => "1000000"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'salary' => "Salary harus memiliki nilai minimum 2.000.000",
                ]
            ]);
    }

    public function testApiStoreEmployeeAssertUnprocessableRuleSalaryMax()
    {
        $response = $this->post('/api/employees', [
            'name' => "Test",
            'salary' => "90000000"
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'salary' => "Salary harus memiliki nilai maksimum 10.000.000",
                ]
            ]);
    }
}
