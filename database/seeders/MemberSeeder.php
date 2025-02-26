<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\Comment\Models\Comment;
use Botble\Member\Models\Member;
use Botble\Member\Models\MemberActivityLog;
use Botble\Slug\Models\Slug;
use Faker\Factory;
use Illuminate\Support\Str;

class MemberSeeder extends BaseSeeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $files = $this->uploadFiles('members');

        Slug::where('reference_type', Member::class)->delete();
        Member::truncate();
        Comment::truncate();
        MemberActivityLog::truncate();

        $member = Member::create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'user@thesky9.com',
            'password' => bcrypt('12345678'),
            'dob' => $faker->dateTime,
            'phone' => $faker->phoneNumber,
            'description' => $faker->realText(100),
            'avatar_id' => $files[$faker->numberBetween(1, 5)]['data']->id,
            'confirmed_at' => now(),
        ]);

        Slug::create([
            'reference_type' => Member::class,
            'reference_id' => $member->id,
            'key' => Str::slug($member->name),
            'prefix' => 'author',
        ]);

        for ($i = 0; $i < 10; $i++) {
            $member = Member::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt('12345678'),
                'dob' => $faker->dateTime,
                'phone' => $faker->phoneNumber,
                'description' => $faker->realText(100),
                'avatar_id' => $files[$faker->numberBetween(0, 4)]['data']->id,
                'confirmed_at' => now(),
            ]);

            Slug::create([
                'reference_type' => Member::class,
                'reference_id' => $member->id,
                'key' => Str::slug($member->name),
                'prefix' => 'author',
            ]);
        }

        foreach (Post::get() as $post) {
            $post->author_id = $faker->numberBetween(1, 10);
            $post->author_type = Member::class;
            $post->save();
        }
    }
}
