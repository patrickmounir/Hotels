<?php

namespace Tests\Feature\Hotels;

use App\Hotel;
use App\User;
use App\Transformers\HotelTransformer;
use Tests\TestCase;

class CreateHotelTest extends TestCase
{

    public function requiredFields()
    {
        return [
            ['name'],
            ['description'],
        ];
    }
    /**
     * @param $hotelData
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitCreateHotelEndpoint($hotelData)
    {
        $response = $this->post(route('createHotel'), $hotelData);
        return $response;
    }

    /** @test */
    function a_user_can_create_a_hotel()
    {
        //background

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $hotelData = factory(Hotel::class)->make()->toArray();

        //action
        $response = $this->hitCreateHotelEndpoint($hotelData);

        //assertions
        $response->assertStatus(201);

        $hotelData['user_id'] = $user->id;

        $this->assertDatabaseHas('hotels', $hotelData);

        $hotellnDB = Hotel::all()->last();

        $response->assertJson(\Fractal::item($hotellnDB, new HotelTransformer())->toArray());
    }

    /** @test */
    function a_guest_cannot_create_hotel()
    {
        $hotelData = factory(Hotel::class)->make()->toArray();

        $response = $this->hitCreateHotelEndpoint($hotelData);

        $response->assertStatus(401);

        $response->assertJson(['message' => 'Forbidden!']);
    }

    /**
     * @dataProvider requiredFields
     *
     * @param $field
     *
     * @test
     */
    function a_user_cannot_create_hotel_without_required_fields($field)
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $hotelData = factory(Hotel::class)->make()->toArray();

        unset($hotelData[$field]);

        $response = $this->hitCreateHotelEndpoint($hotelData);

        $response->assertStatus(422);

        $errors = $response->decodeResponseJson('errors');

        $this->assertArrayHasKey($field, $errors);
    }
}
