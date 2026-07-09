<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
    }
}
