<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 

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

        // AquaVerse (Project 1)
        // Members: C1, C3, C4 

        $task1 = Task::create([
            'title' => 'Design Landing Page',
            'description' => 'Create the landing page UI for AquaVerse.',
            'accent' => '#7C2D8E',
            'icon' => 'palette',
            'priority' => 'high',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-15'),
            'is_completed' => true,
            'project_id' => $project1->id,
        ]);
        $task1->users()->attach([$collab1->id, $collab3->id]);

        $task2 = Task::create([
            'title' => 'User Authentication',
            'description' => 'Implement login and registration.',
            'accent' => '#7C2D8E',
            'icon' => 'shield-lock',
            'priority' => 'urgent',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-05-25'),
            'is_completed' => false,
            'project_id' => $project1->id,
        ]);
        $task2->users()->attach([$collab4->id]);

        $task3 = Task::create([
            'title' => 'Marine Species Database',
            'description' => 'Populate the database with marine species.',
            'accent' => '#7C2D8E',
            'icon' => 'database',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-02'),
            'is_completed' => false,
            'project_id' => $project1->id,
        ]);
        $task3->users()->attach([$collab1->id]);

        $task4 = Task::create([
            'title' => 'Interactive Ocean Map',
            'description' => 'Build an interactive habitat map.',
            'accent' => '#7C2D8E',
            'icon' => 'map',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-08'),
            'is_completed' => false,
            'project_id' => $project1->id,
        ]);
        $task4->users()->attach([$collab3->id]);

        $task5 = Task::create([
            'title' => 'Quiz Module',
            'description' => 'Develop educational quizzes.',
            'accent' => '#7C2D8E',
            'icon' => 'brain',
            'priority' => 'medium',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-06-15'),
            'is_completed' => false,
            'project_id' => $project1->id,
        ]);
        $task5->users()->attach([$collab1->id, $collab4->id]);

        $task6 = Task::create([
            'title' => 'Application Testing',
            'description' => 'Perform functional testing.',
            'accent' => '#7C2D8E',
            'icon' => 'bug',
            'priority' => 'low',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-20'),
            'is_completed' => false,
            'project_id' => $project1->id,
        ]);
        $task6->users()->attach([$collab3->id]);


        // MindSpace (Project 2)
        // Members: C2, C3, C4, C5

        $task7 = Task::create([
            'title' => 'Mood Tracker UI',
            'description' => 'Design the mood tracking interface.',
            'accent' => '#0056D2',
            'icon' => 'smile',
            'priority' => 'medium',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-14'),
            'is_completed' => true,
            'project_id' => $project2->id,
        ]);
        $task7->users()->attach([$collab2->id]);

        $task8 = Task::create([
            'title' => 'Journal Feature',
            'description' => 'Allow users to write daily journals.',
            'accent' => '#0056D2',
            'icon' => 'book-open',
            'priority' => 'high',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-05-27'),
            'is_completed' => false,
            'project_id' => $project2->id,
        ]);
        $task8->users()->attach([$collab3->id, $collab5->id]);

        $task9 = Task::create([
            'title' => 'Reminder Notifications',
            'description' => 'Implement daily reminder notifications.',
            'accent' => '#0056D2',
            'icon' => 'bell',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-04'),
            'is_completed' => false,
            'project_id' => $project2->id,
        ]);
        $task9->users()->attach([$collab4->id]);

        $task10 = Task::create([
            'title' => 'Meditation Audio',
            'description' => 'Integrate guided meditation sessions.',
            'accent' => '#0056D2',
            'icon' => 'headphones',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-10'),
            'is_completed' => false,
            'project_id' => $project2->id,
        ]);
        $task10->users()->attach([$collab2->id, $collab4->id]);

        $task11 = Task::create([
            'title' => 'Analytics Dashboard',
            'description' => 'Display mood trends.',
            'accent' => '#0056D2',
            'icon' => 'chart-column',
            'priority' => 'high',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-06-18'),
            'is_completed' => false,
            'project_id' => $project2->id,
        ]);
        $task11->users()->attach([$collab3->id]);

        $task12 = Task::create([
            'title' => 'User Feedback System',
            'description' => 'Allow users to submit feedback.',
            'accent' => '#0056D2',
            'icon' => 'message-circle',
            'priority' => 'low',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-25'),
            'is_completed' => false,
            'project_id' => $project2->id,
        ]);
        $task12->users()->attach([$collab5->id]); 

        // CookEase (Project 3)
        // Members: C3

        $task13 = Task::create([
            'title' => 'Recipe Categories',
            'description' => 'Create recipe category management.',
            'accent' => '#1F5D3A',
            'icon' => 'utensils',
            'priority' => 'medium',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-12'),
            'is_completed' => true,
            'project_id' => $project3->id,
        ]);
        $task13->users()->attach([$collab3->id]);

        $task14 = Task::create([
            'title' => 'Meal Planner',
            'description' => 'Develop the weekly meal planner.',
            'accent' => '#1F5D3A',
            'icon' => 'calendar-days',
            'priority' => 'high',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-05-28'),
            'is_completed' => false,
            'project_id' => $project3->id,
        ]);
        $task14->users()->attach([$collab3->id]);

        $task15 = Task::create([
            'title' => 'Shopping List Generator',
            'description' => 'Generate grocery lists automatically.',
            'accent' => '#1F5D3A',
            'icon' => 'shopping-cart',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-03'),
            'is_completed' => false,
            'project_id' => $project3->id,
        ]);
        $task15->users()->attach([$collab3->id]);

        $task16 = Task::create([
            'title' => 'Nutrition Information',
            'description' => 'Display nutritional facts.',
            'accent' => '#1F5D3A',
            'icon' => 'apple',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-10'),
            'is_completed' => false,
            'project_id' => $project3->id,
        ]);
        $task16->users()->attach([$collab3->id]);

        $task17 = Task::create([
            'title' => 'Recipe Search',
            'description' => 'Implement search and filtering.',
            'accent' => '#1F5D3A',
            'icon' => 'search',
            'priority' => 'high',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-06-18'),
            'is_completed' => false,
            'project_id' => $project3->id,
        ]);
        $task17->users()->attach([$collab3->id]);

        $task18 = Task::create([
            'title' => 'Application Testing',
            'description' => 'Test all application modules.',
            'accent' => '#1F5D3A',
            'icon' => 'bug',
            'priority' => 'low',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-24'),
            'is_completed' => false,
            'project_id' => $project3->id,
        ]);
        $task18->users()->attach([$collab3->id]);

        // PetPal (Project 4)
        // Members: C1, C2, C4, C5

        $task19 = Task::create([
            'title' => 'Pet Profile Management',
            'description' => 'Allow users to create and manage pet profiles.',
            'accent' => '#0EA5A4',
            'icon' => 'paw-print',
            'priority' => 'medium',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-16'),
            'is_completed' => true,
            'project_id' => $project4->id,
        ]);
        $task19->users()->attach([$collab1->id]);

        $task20 = Task::create([
            'title' => 'Vaccination Reminder',
            'description' => 'Notify users about upcoming vaccinations.',
            'accent' => '#0EA5A4',
            'icon' => 'syringe',
            'priority' => 'high',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-05-28'),
            'is_completed' => false,
            'project_id' => $project4->id,
        ]);
        $task20->users()->attach([$collab2->id, $collab5->id]);

        $task21 = Task::create([
            'title' => 'Pet Health Records',
            'description' => 'Store and manage medical history for pets.',
            'accent' => '#0EA5A4',
            'icon' => 'file-heart',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-05'),
            'is_completed' => false,
            'project_id' => $project4->id,
        ]);
        $task21->users()->attach([$collab4->id]);

        $task22 = Task::create([
            'title' => 'Appointment Scheduler',
            'description' => 'Schedule veterinary appointments.',
            'accent' => '#0EA5A4',
            'icon' => 'calendar-check',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-12'),
            'is_completed' => false,
            'project_id' => $project4->id,
        ]);
        $task22->users()->attach([$collab1->id, $collab4->id]);

        $task23 = Task::create([
            'title' => 'Pet Growth Tracker',
            'description' => 'Track pet weight and growth history.',
            'accent' => '#0EA5A4',
            'icon' => 'chart-line',
            'priority' => 'medium',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-06-18'),
            'is_completed' => false,
            'project_id' => $project4->id,
        ]);
        $task23->users()->attach([$collab5->id]);

        $task24 = Task::create([
            'title' => 'Application QA Testing',
            'description' => 'Perform complete quality assurance testing.',
            'accent' => '#0EA5A4',
            'icon' => 'bug',
            'priority' => 'low',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-24'),
            'is_completed' => false,
            'project_id' => $project4->id,
        ]);
        $task24->users()->attach([$collab2->id]);

        // TravelMate (Project 5)
        // Members: C1, C2, C4, C5

        $task25 = Task::create([
            'title' => 'Trip Budget Calculator',
            'description' => 'Estimate travel expenses for users.',
            'accent' => '#8B5A2B',
            'icon' => 'wallet',
            'priority' => 'medium',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-10'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task25->users()->attach([$collab2->id]);

        $task26 = Task::create([
            'title' => 'Hotel Recommendation',
            'description' => 'Recommend hotels based on user preferences.',
            'accent' => '#8B5A2B',
            'icon' => 'hotel',
            'priority' => 'high',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-18'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task26->users()->attach([$collab1->id, $collab5->id]);

        $task27 = Task::create([
            'title' => 'Flight Search Integration',
            'description' => 'Integrate third-party flight search API.',
            'accent' => '#8B5A2B',
            'icon' => 'plane',
            'priority' => 'urgent',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-05-24'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task27->users()->attach([$collab4->id]);

        $task28 = Task::create([
            'title' => 'Travel Itinerary Planner',
            'description' => 'Generate customizable travel itineraries.',
            'accent' => '#8B5A2B',
            'icon' => 'map',
            'priority' => 'high',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-06-02'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task28->users()->attach([$collab2->id, $collab5->id]);

        $task29 = Task::create([
            'title' => 'Offline Map Support',
            'description' => 'Allow users to access maps without internet.',
            'accent' => '#8B5A2B',
            'icon' => 'map-pinned',
            'priority' => 'medium',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-06-10'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task29->users()->attach([$collab1->id]);

        $task30 = Task::create([
            'title' => 'Application Release',
            'description' => 'Prepare and publish the first stable release.',
            'accent' => '#8B5A2B',
            'icon' => 'rocket',
            'priority' => 'urgent',
            'status' => 'completed',
            'deadline' => Carbon::parse('2026-06-18'),
            'is_completed' => true,
            'project_id' => $project5->id,
        ]);
        $task30->users()->attach([
            $collab1->id,
            $collab2->id,
            $collab4->id,
            $collab5->id,
        ]);

        // EcoTrack (Project 6)
        // Members: C4

        $task31 = Task::create([
            'title' => 'Carbon Footprint Calculator',
            'description' => 'Calculate users\' daily carbon emissions.',
            'accent' => '#F35C75',
            'icon' => 'leaf',
            'priority' => 'urgent',
            'status' => 'in_progress',
            'deadline' => Carbon::parse('2026-05-20'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task31->users()->attach([$collab4->id]);

        $task32 = Task::create([
            'title' => 'Transportation Tracker',
            'description' => 'Track transportation habits and emissions.',
            'accent' => '#F35C75',
            'icon' => 'car',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-05-29'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task32->users()->attach([$collab4->id]);

        $task33 = Task::create([
            'title' => 'Energy Consumption Monitor',
            'description' => 'Record household energy usage.',
            'accent' => '#F35C75',
            'icon' => 'bolt',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-06'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task33->users()->attach([$collab4->id]);

        $task34 = Task::create([
            'title' => 'Weekly Sustainability Report',
            'description' => 'Generate personalized sustainability reports.',
            'accent' => '#F35C75',
            'icon' => 'chart-column',
            'priority' => 'medium',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-13'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task34->users()->attach([$collab4->id]);

        $task35 = Task::create([
            'title' => 'Achievement Badge System',
            'description' => 'Reward users for eco-friendly habits.',
            'accent' => '#F35C75',
            'icon' => 'award',
            'priority' => 'low',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-20'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task35->users()->attach([$collab4->id]);

        $task36 = Task::create([
            'title' => 'Final Application Testing',
            'description' => 'Conduct end-to-end testing before deployment.',
            'accent' => '#F35C75',
            'icon' => 'bug',
            'priority' => 'high',
            'status' => 'pending',
            'deadline' => Carbon::parse('2026-06-27'),
            'is_completed' => false,
            'project_id' => $project6->id,
        ]);
        $task36->users()->attach([$collab4->id]);

    }
}
