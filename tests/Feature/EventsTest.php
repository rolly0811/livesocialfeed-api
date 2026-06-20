<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetEvents()
    {
        $user = User::factory()->create(['contact_number' => '0991828772']);

        Sanctum::actingAs($user);

        $events = Event::factory()->count(10)->create(['start_date' => now(), 'end_date' => now()->addDays(5)]);
        $response = $this->get('/api/events?active=1');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }


}
