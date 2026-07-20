<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collab1 = User::firstWhere('username', 'Collab1'); 
        $collab2 = User::firstWhere('username', 'Collab2'); 
        $collab3 = User::firstWhere('username', 'Collab3'); 
        $collab4 = User::firstWhere('username', 'Collab4'); 
        $collab5 = User::firstWhere('username', 'Collab5'); 

        $project1 = Project::create([
            'leader_id' => $collab1->id, 
            'title' => 'AquaVerse',
            'description' => 'Mobile application that focuses on sea creatures education.',
            'accent' => '#7C2D8E',
            'icon' => 'fishing-hook', 
            'deadline' => Carbon::parse('07/22/2026')
        ]); 

        $project2 = Project::create([
            'leader_id' => $collab2->id, 
            'title' => 'MindSpace',
            'description' => 'MindSpace Mobile App for mental health and mood tracking.',
            'accent' => '#0056D2', 
            'icon' => 'heart-pulse',
            'deadline' => Carbon::parse('07/15/2026')
        ]); 
            
        $project3 = Project::create([
            'leader_id' => $collab3->id, 
            'title' => 'CookEase',
            'description' => 'CookEase Mobile App for easy recipes and meal planning.',
            'accent' => '#1F5D3A', 
            'icon' => 'cooking-pot', 
            'deadline' => Carbon::parse('08/19/2026')
        ]); 
            
        $project4 = Project::create([
            'leader_id' => $collab1->id, 
            'title' => 'PetPal',
            'description' => 'PetPal Mobile App for smart pet care management system.',
            'accent' => '#0EA5A4', 
            'icon' => 'cat', 
            'deadline' => Carbon::parse('08/23/2026')
        ]); 
        
        $project5 = Project::create([
            'leader_id' => $collab2->id, 
            'title' => 'TravelMate',
            'description' => 'TravelMate Mobile App for smart trip planning and itineraries.',
            'accent' => '#8B5A2B', 
            'icon' => 'backpack', 
            'deadline' => Carbon::parse('07/28/2026')
        ]); 
        
        $project6 = Project::create([
            'leader_id' => $collab4->id, 
            'title' => 'EcoTrack',
            'description' => 'EcoTrack App for tracking and reducing daily carbon footprint.',
            'accent' => '#F35C75', 
            'icon' => 'trees', 
            'deadline' => Carbon::parse('07/22/2026')
        ]); 

        $project1->users()->attach([
            $collab1->id, 
            $collab3->id,
            $collab4->id
        ]);

        $project2->users()->attach([
            $collab2->id,
            $collab5->id,
            $collab3->id, 
            $collab4->id
        ]);

        $project3->users()->attach([
            $collab3->id, 
        ]);

        $project4->users()->attach([
            $collab1->id, 
            $collab2->id,
            $collab5->id, 
            $collab4->id
        ]);

        $project5->users()->attach([
            $collab2->id,
            $collab1->id,
            $collab5->id, 
            $collab4->id
        ]);

        $project6->users()->attach([
            $collab4->id
        ]); 
    }
}
