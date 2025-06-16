<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PopularTopic;
use App\Models\User;

class PopularTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@surabayaai.com')->first();
        
        $topics = [
            [
                'question' => 'Apa asal usul nama Surabaya?',
                'display_text' => 'Asal usul nama Surabaya',
                'order' => 1,
            ],
            [
                'question' => 'Ceritakan tentang Pertempuran Surabaya',
                'display_text' => 'Pertempuran Surabaya',
                'order' => 2,
            ],
            [
                'question' => 'Siapa Bung Tomo?',
                'display_text' => 'Bung Tomo',
                'order' => 3,
            ],
            [
                'question' => 'Apa saja situs bersejarah penting di Surabaya?',
                'display_text' => 'Situs bersejarah',
                'order' => 4,
            ],
        ];
        
        foreach ($topics as $topic) {
            PopularTopic::create([
                'question' => $topic['question'],
                'display_text' => $topic['display_text'],
                'order' => $topic['order'],
                'is_active' => true,
                'created_by' => $admin ? $admin->id : null,
                'updated_by' => $admin ? $admin->id : null,
            ]);
        }
    }
}
