<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        // Sample data for items
        $items = [
            [
                'name' => 'Book',
                'price' => 15.00,
            ],
            [
                'name' => 'Pencil',
                'price' => 12.00,
            ],
            [
                'name' => 'Ruler',
                'price' => 2.00,
            ],
            [
                'name' => 'Highlighter',
                'price' => 1.00,
            ],
            [
                'name' => 'Sticky Notes',
                'price' => 3.00,
            ],
        ];

        // Insert sample data into the items table
        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
