<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = '{"category":"1","biggest_challenge":"Budgeting","registering_as":"Couple","source":"Facebook","event":{"date":"2026-06-13","needs":["Venue","Catering","Photography","Videography","Bridal Gown","Suit/Tuxedo","Hair & Makeup","Wedding Coordinator","Event Stylist"],"type":"Church Wedding","budget":"Below ₱100,000","guests":"150","remarks":"Test"},"name":"Rolly Domingo","mobile":"09678303010","email":"domingorolly11@gmail.com","city":"Manila","style":"Elegant","receive_updates":true,"agreed":true,"category_type":"wedding"}';

        $response = $this->post('/api/event-registration', json_decode($data, true));

        $response->assertStatus(201);
    }
}
