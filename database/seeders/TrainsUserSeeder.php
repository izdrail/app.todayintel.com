<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Waterhole\Layouts;
use Waterhole\Models\Channel;
use Waterhole\Models\Group;
use Waterhole\Models\Permission;
use Waterhole\Models\User;

class TrainsUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $guest = Group::firstOrCreate([
            'id' => Group::GUEST_ID,
            'name' => __('waterhole::install.group-guest'),
        ]);

        $member = Group::firstOrCreate([
            'id' => Group::MEMBER_ID,
            'name' => __('waterhole::install.group-member'),
        ]);

        $mod = Group::firstOrCreate([
            'name' => __('waterhole::install.group-moderator'),
            'is_public' => true,
        ]);

        // Channels WORLD, NATION, BUSINESS, TECHNOLOGY, ENTERTAINMENT, SPORTS, SCIENCE, HEALTH.
        $channels = [
            [
                'name' => "World",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Nation",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Business",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Technology",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Entertainment",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Sports",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Science",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
            [
                'name' => "Health",
                'description' => "",
                'answerable' => true,
                'show_similar_posts' => true,
            ],
        ];

        foreach ($channels as $data) {
            $data['slug'] = Str::slug($data['name']);

            $channel = Channel::firstOrCreate(
                Arr::only($data, 'slug'),
                Arr::except($data, ['slug', 'group', 'group_post']) + [
                    'layout' => Layouts\ListLayout::class,
                ],
            );

            if ($channel->wasRecentlyCreated) {
                $channel
                    ->permissions()
                    ->saveMany([
                        (new Permission(['ability' => 'view']))
                            ->recipient()
                            ->associate($data['group'] ?? $guest),
                        (new Permission(['ability' => 'post']))
                            ->recipient()
                            ->associate($data['group_post'] ?? ($data['group'] ?? $member)),
                        (new Permission(['ability' => 'comment']))
                            ->recipient()
                            ->associate($data['group'] ?? $member),
                        (new Permission(['ability' => 'moderate']))->recipient()->associate($mod),
                    ]);

                $channel->structure->update(['is_listed' => true]);
            }
        }


        //create admin user
        $data = [
            'name' => "Admin",
            'email' => "stefan@lzomedia.com",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ];

        User::create($data)
            ->groups()
            ->attach(Group::ADMIN_ID);

        //check if file exists --
        // Load users from CSV file
//        $csvFile = __DIR__ . '/content/trains-users.csv'; // Assuming the CSV file is named users.csv and located in the same folder as this Seeder class
//
//        if (($handle = fopen($csvFile, 'r')) !== false) {
//            while (($data = fgetcsv($handle, 100000, ',')) !== false) {
//                $user = [
//                    'name' => $data[0] . ' ' . $data[1], // Assuming firstname is in the first column and lastname is in the second column
//                    'email' => $data[2], // Assuming email is in the third column
//                    'password' => Hash::make('password'), // You may want to set a default password here
//                    'email_verified_at' => now(),
//                ];
//
//                User::updateOrCreate([
//                    'email' => $user['email']
//                ], $user)
//                    ->groups()
//                    ->attach(Group::MEMBER_ID);
//            }
//            fclose($handle);
//        }



    }
}
