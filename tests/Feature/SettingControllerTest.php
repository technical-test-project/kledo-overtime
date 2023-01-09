<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    public function testApiUpdateSettingAssertOk()
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->patch('/api/settings', [
            'key' => 'overtime_method',
            'value' => 1
        ]);

        $response->assertOk();
    }

    public function testApiUpdateSettingAssertUnprocessableKeyValue()
    {
        $response = $this->patch('/api/settings', [
            'key' => 'overtime',
            'value' => 3
        ]);

        $response->assertUnprocessable()
        ->assertJson([
            'message' => 'Unprocessable Content',
            'errors' => [
                'key' => "Key hanya boleh diisi dengan \"overtime_method\"",
                'value' => "Value tidak memiliki id referensi dengan code \"overtime_method\""
            ]
        ]);
    }

    public function testApiUpdateSettingAssertUnprocessableKey()
    {
        $response = $this->patch('/api/settings', [
            'key' => 'overtime',
            'value' => 1
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'key' => "Key hanya boleh diisi dengan \"overtime_method\"",
                ]
            ]);
    }

    public function testApiUpdateSettingAssertUnprocessableValue()
    {
        $response = $this->patch('/api/settings', [
            'key' => 'overtime_method',
            'value' => 3
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Unprocessable Content',
                'errors' => [
                    'value' => "Value tidak memiliki id referensi dengan code \"overtime_method\""
                ]
            ]);
    }
}
