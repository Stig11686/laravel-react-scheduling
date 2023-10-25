<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZoomRoom;

class ZoomRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $zoomrooms = [
            [
                'name' => 'TCG Training Room 1',
                'link' => 'https://us02web.zoom.us/j/3871878781'
            ],
            [
                'name' => 'TCG Training Room 2',
                'link' => 'https://us02web.zoom.us/j/387287878'
            ],
            [
                'name' => 'TCG Training Room 3',
                'link' => 'https://us02web.zoom.us/j/3873878783'
            ],
            [
                'name' => 'TCG Training Room 4',
                'link' => 'https://us02web.zoom.us/j/4874878784'
            ]
        ];

        foreach($zoomrooms as $zoomroom){
            ZoomRoom::create($zoomroom);
        }


    }
}
