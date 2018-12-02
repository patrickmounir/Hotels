<?php

namespace Tests\Feature\Hotels;

use App\Hotel;
use App\User;
use App\Transformers\HotelTransformer;
use Tests\TestCase;

class CreateHotelTest extends TestCase
{
    /** @test */
    function a_user_can_create_a_hotel()
    {
        //background

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $hotelData = factory(Hotel::class)->make()->toArray();

        //action
        $response = $this->post(route('createHotel'), $hotelData);

        //assertions
        $response->assertStatus(201);

        $hotelData['user_id'] = $user->id;

        $this->assertDatabaseHas('hotels', $hotelData);

        $hotellnDB = Hotel::all()->last();

        $response->assertJson(\Fractal::item($hotellnDB, new HotelTransformer())->toArray());
    }
}
