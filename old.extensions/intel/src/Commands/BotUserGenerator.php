<?php

namespace extensions\cornatul-intel\src\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Waterhole\Models\User;

class BotUserGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:generate-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates fake users with some bio location and avatar from randomuser.me ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 0; $i < 300; $i++) {
            sleep(1);
            $this->info('Generating user ' . $i);
            $client = new \GuzzleHttp\Client();

            //https://randomuser.me/api/
            $response = $client->request('GET', 'https://randomuser.me/api/');
            $body = $response->getBody();
            $data = json_decode($body->getContents());

            $user = new User();
            $user->name = $data->results[0]->name->first . ' ' . $data->results[0]->name->last;
            $user->email = $data->results[0]->email;
            $user->password = \Illuminate\Support\Facades\Hash::make('password');
            $user->locale = 'en';
            $user->headline = 'Model train enthusiast';
            $user->bio = strip_tags(Inspiring::quote());
            $user->location = $data->results[0]->location->city . ', ' . $data->results[0]->location->country;
            $user->website = $data->results[0]->login->username . '.com';
            $user->avatar = $data->results[0]->picture->medium;
            $user->created_at = now();
            $user->last_seen_at = now();
            $user->show_online = true;
            $user->notification_channels = null;
            $user->notifications_read_at = now();
            $user->follow_on_comment = true;
            $user->suspended_until = null;


            $user->save();
        }
    }





}
