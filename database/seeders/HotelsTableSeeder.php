<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedHotelDatabase(5);
    }

    private function seedHotelDatabase(int $c): void
    {
        for ($i = 0; $i < $c; $i++) {
            $hotel = Hotel::factory()
                ->count(1)
                ->create()
                ->each(function ($hotel) {
                    $hotel->rooms()->saveMany(Room::factory()->count(5)->make());
                });
                
            foreach ($hotel->first()->rooms()->get() as $room) {
                $room->facilities()->saveMany(Facility::factory()->count(5)->make());
                $hotel->first()->facilities()->saveMany($room->facilities()->get());
            }
        }
    }
}
