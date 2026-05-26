<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $collab1 = User::create([
            'username' => 'Collab1', 
            'name' => 'Collaborator1', 
            'email' => 'collaborator1@example.com', 
            'password' => Hash::make('Collaborator1%')
        ]); 
        $collab2 = User::create([
            'username' => 'Collab2', 
            'name' => 'Collaborator2', 
            'email' => 'collaborator2@example.com', 
            'password' => Hash::make('Collaborator2%')
        ]); 
        $collab3 = User::create([
            'username' => 'Collab3', 
            'name' => 'Collaborator3', 
            'email' => 'collaborator3@example.com', 
            'password' => Hash::make('Collaborator3%')
        ]); 
        $collab4 = User::create([
            'username' => 'Collab4', 
            'name' => 'Collaborator4', 
            'email' => 'collaborator4@example.com', 
            'password' => Hash::make('Collaborator4%')
        ]); 
        $collab5 = User::create([
            'username' => 'Collab5', 
            'name' => 'Collaborator5', 
            'email' => 'collaborator5@example.com', 
            'password' => Hash::make('Collaborator5%')
        ]); 


        $project1 = Project::create([
            'leader_id' => $collab1->id, 
            'title' => 'AquaVerse',
            'description' => 'Mobile application that focuses on sea creatures education.',
            'progress' => 30,
            'accent' => '#7C2D8E',
            'icon' => 'fishing-hook', 
            'deadline' => Carbon::parse('06/12/2026')
        ]); 

        $project2 = Project::create([
            'leader_id' => $collab2->id, 
            'title' => 'MindSpace',
            'description' => 'MindSpace Mobile App for mental health and mood tracking.',
            'progress' => 50,
            'accent' => '#0056D2', 
            'icon' => 'heart-pulse',
            'deadline' => Carbon::parse('06/15/2026')
        ]); 
            
        $project3 = Project::create([
            'leader_id' => $collab3->id, 
            'title' => 'CookEase',
            'description' => 'CookEase Mobile App for easy recipes and meal planning.',
            'progress' => 10,
            'accent' => '#1F5D3A', 
            'icon' => 'cooking-pot', 
            'deadline' => Carbon::parse('06/19/2026')
        ]); 
            
        $project4 = Project::create([
            'leader_id' => $collab1->id, 
            'title' => 'PetPal',
            'description' => 'PetPal Mobile App for smart pet care management system.',
            'progress' => 70,
            'accent' => '#0EA5A4', 
            'icon' => 'cat', 
            'deadline' => Carbon::parse('06/23/2026')
        ]); 
        
        $project5 = Project::create([
            'leader_id' => $collab2->id, 
            'title' => 'TravelMate',
            'description' => 'TravelMate Mobile App for smart trip planning and itineraries.',
            'progress' => 100,
            'accent' => '#8B5A2B', 
            'icon' => 'backpack', 
            'deadline' => Carbon::parse('06/28/2026')
        ]); 
        
        $project6 = Project::create([
            'leader_id' => $collab4->id, 
            'title' => 'EcoTrack',
            'description' => 'EcoTrack App for tracking and reducing daily carbon footprint.',
            'progress' => 40,
            'accent' => '#F35C75', 
            'icon' => 'trees', 
            'deadline' => Carbon::parse('07/1/2026')
        ]); 

        $project1->members()->attach([
            $collab1->id, 
            $collab3->id,
            $collab4->id
        ]);

        $project2->members()->attach([
            $collab2->id,
            $collab5->id,
            $collab3->id, 
            $collab4->id
        ]);

        $project3->members()->attach([
            $collab3->id, 
        ]);

        $project4->members()->attach([
            $collab1->id, 
            $collab2->id,
            $collab5->id, 
            $collab4->id
        ]);

        $project5->members()->attach([
            $collab2->id,
            $collab1->id,
            $collab5->id, 
            $collab4->id
        ]);

        $project6->members()->attach([
            $collab4->id
        ]); 
    }
}
