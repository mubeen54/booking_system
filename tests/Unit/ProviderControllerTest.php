<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\ProviderController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class ProviderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Method test_add_provider_creates_provider
     *
     * @return void
     */
    public function test_add_provider_creates_provider()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $providerData = [
            'name' => 'Test Provider',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'range' => 50,
        ];

        $controller = new ProviderController();

        $response = $controller->addProvider(new Request($providerData));

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertDatabaseHas('providers', [
            'name' => $providerData['name'],
            'latitude' => $providerData['latitude'],
            'longitude' => $providerData['longitude'],
            'range' => $providerData['range'],
        ]);
    }
}
