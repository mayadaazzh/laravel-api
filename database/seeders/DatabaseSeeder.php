<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        Post::create([
            'user_id' => '1',
            'title' => 'Aku adalh anak gembala',
            'news_content' => 'selalu riang serta geora karnq fd esafa',
        ]);
        Post::create([
            'user_id' => '1',
            'title' => 'Aku sfsefhfes',
            'news_content' => 'selalu riang serta geora karnq fd esafa',
        ]);
    }
}
