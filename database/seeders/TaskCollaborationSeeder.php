<?php

namespace Database\Seeders;

use App\Models\TaskCollaboration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskCollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [

            // AquaVerse

            [
                'task_id' => 1,
                'user_id' => 4,
                'status' => 'completed',
                'reward_earned' => 30,
                'joined_at' => Carbon::parse('2026-08-05'),
                'completed_at' => Carbon::parse('2026-08-15'),
            ],

            [
                'task_id' => 3,
                'user_id' => 3,
                'status' => 'completed',
                'reward_earned' => 25,
                'joined_at' => Carbon::parse('2026-08-20'),
                'completed_at' => Carbon::parse('2026-09-01'),
            ],

            [
                'task_id' => 6,
                'user_id' => 1,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-07-18'),
                'completed_at' => null,
            ],

            // MindSpace

            [
                'task_id' => 8,
                'user_id' => 2,
                'status' => 'in_progress',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-07-12'),
                'completed_at' => null,
            ],

            [
                'task_id' => 10,
                'user_id' => 5,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-08-01'),
                'completed_at' => null,
            ],

            // CookEase

            [
                'task_id' => 14,
                'user_id' => 2,
                'status' => 'pending',
                'reward_earned' => 0,
                'joined_at' => null,
                'completed_at' => null,
            ],

            [
                'task_id' => 15,
                'user_id' => 5,
                'status' => 'completed',
                'reward_earned' => 18,
                'joined_at' => Carbon::parse('2026-07-28'),
                'completed_at' => Carbon::parse('2026-08-03'),
            ],

            [
                'task_id' => 17,
                'user_id' => 1,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-06-10'),
                'completed_at' => null,
            ],

            [
                'task_id' => 18,
                'user_id' => 4,
                'status' => 'pending',
                'reward_earned' => 0,
                'joined_at' => null,
                'completed_at' => null,
            ],

            // PetPal

            [
                'task_id' => 20,
                'user_id' => 1,
                'status' => 'completed',
                'reward_earned' => 22,
                'joined_at' => Carbon::parse('2026-07-18'),
                'completed_at' => Carbon::parse('2026-07-27'),
            ],

            [
                'task_id' => 21,
                'user_id' => 2,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-07-29'),
                'completed_at' => null,
            ],

            [
                'task_id' => 23,
                'user_id' => 1,
                'status' => 'completed',
                'reward_earned' => 15,
                'joined_at' => Carbon::parse('2026-07-05'),
                'completed_at' => Carbon::parse('2026-07-17'),
            ],

            [
                'task_id' => 24,
                'user_id' => 5,
                'status' => 'pending',
                'reward_earned' => 0,
                'joined_at' => null,
                'completed_at' => null,
            ],

            // TravelMate

            [
                'task_id' => 26,
                'user_id' => 2,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-08-10'),
                'completed_at' => null,
            ],

            [
                'task_id' => 27,
                'user_id' => 5,
                'status' => 'pending',
                'reward_earned' => 0,
                'joined_at' => null,
                'completed_at' => null,
            ],

            [
                'task_id' => 28,
                'user_id' => 1,
                'status' => 'completed',
                'reward_earned' => 28,
                'joined_at' => Carbon::parse('2026-06-18'),
                'completed_at' => Carbon::parse('2026-07-01'),
            ],

            [
                'task_id' => 30,
                'user_id' => 3,
                'status' => 'completed',
                'reward_earned' => 50,
                'joined_at' => Carbon::parse('2026-06-01'),
                'completed_at' => Carbon::parse('2026-06-17'),
            ],

            // EcoTrack

            [
                'task_id' => 31,
                'user_id' => 1,
                'status' => 'completed',
                'reward_earned' => 35,
                'joined_at' => Carbon::parse('2026-07-05'),
                'completed_at' => Carbon::parse('2026-07-19'),
            ],

            [
                'task_id' => 32,
                'user_id' => 2,
                'status' => 'accepted',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-08-15'),
                'completed_at' => null,
            ],

            [
                'task_id' => 34,
                'user_id' => 5,
                'status' => 'in_progress',
                'reward_earned' => 0,
                'joined_at' => Carbon::parse('2026-07-05'),
                'completed_at' => null,
            ],

            [
                'task_id' => 36,
                'user_id' => 2,
                'status' => 'pending',
                'reward_earned' => 0,
                'joined_at' => null,
                'completed_at' => null,
            ],

        ];

        foreach ($records as $record) {
            TaskCollaboration::create($record);
        }
    }
}
