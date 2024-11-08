<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TasksSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Belajar Biologi',
                'status' => 0, 
            ],
            [
                'judul' => 'Belajar Matematika',
                'status' => 1, 
            ],
        ];

        
        foreach ($data as $task) {
            $this->db->table('tasks')->insert($task);
        }
    }
}
