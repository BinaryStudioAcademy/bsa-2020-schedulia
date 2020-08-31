<?php

use Illuminate\Database\Seeder;
use App\Entity\EventType;
use App\Entity\Tag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = EventType::all();

        $eventTypes->map(
            function (EventType $eventType) {
                return factory(Tag::class, 5)->create([
                    'event_type_id' => $eventType->id,
                ]);
            }
        );
    }
}
