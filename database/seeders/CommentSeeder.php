<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\Comment\Models\Comment;
use Botble\Comment\Models\CommentUser;
use Botble\Comment\Repositories\Interfaces\CommentInterface;
use Faker\Factory;

class CommentSeeder extends BaseSeeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $files = $this->uploadFiles('authors');

        CommentUser::truncate();
        Comment::truncate();

        for ($i = 0; $i < 10; $i++) {
            CommentUser::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => bcrypt('12345678'),
                'avatar_id' => $files[$faker->numberBetween(0, 4)]['data']->id,
            ]);
        }

        $postIds = [1, 2, 3, 21, 22, 23];
        foreach ($postIds as $postId) {
            $commentIds = [];
            for ($i = 0; $i < 8; $i++) {
                $data = [
                    'ip_address' => $faker->ipv4(),
                    'user_id' => $faker->numberBetween(1, 10),
                    'reference_id' => $postId,
                    'reference_type' => Post::class,
                    'comment' => $faker->realText(100),
                    'user_type' => CommentUser::class,
                    'created_at' => $faker->dateTimeBetween('-1 months'),
                ];
                if ($i > 5) {
                    $data['parent_id'] = $faker->randomElement($commentIds);
                    $data['created_at'] = $faker->dateTimeBetween('-15 days');
                }
                $comment = app(CommentInterface::class)->storageComment($data);
                if ($i < 5) {
                    $commentIds[] = $comment->id;
                }
            }
        }
    }
}
