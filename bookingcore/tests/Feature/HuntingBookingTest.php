<?php


namespace Tests\Feature;


use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class HuntingBookingTest extends TestCase
{
    use RefreshDatabase;


    public function test_guides_filter_by_min_experience(): void
    {
        Guide::factory()->create(['name' => 'A', 'experience_years' => 1, 'is_active' => true]);
        Guide::factory()->create(['name' => 'B', 'experience_years' => 5, 'is_active' => true]);
        Guide::factory()->create(['name' => 'C', 'experience_years' => 7, 'is_active' => false]);


        $this->getJson('/api/guides?min_experience=3')
            ->assertOk()
            ->assertJsonMissing(['name' => 'A'])
            ->assertJsonFragment(['name' => 'B'])
            ->assertJsonMissing(['name' => 'C']);
    }


    public function test_booking_creation_and_conflict(): void
    {
        $guide = Guide::factory()->create(['is_active' => true, 'experience_years' => 3]);


        $payload = [
            'tour_name' => 'Boar Run',
            'hunter_name' => 'John Doe',
            'guide_id' => $guide->id,
            'date' => now()->addDay()->toDateString(),
            'participants_count' => 3,
        ];


        $this->postJson('/api/bookings', $payload)
            ->assertCreated()
            ->assertJsonFragment(['tour_name' => 'Boar Run']);


        $this->postJson('/api/bookings', $payload)
            ->assertStatus(409)
            ->assertJson(['message' => 'Guide is not available on selected date.']);
    }
}
