<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Data\Models\Application;
use App\Data\Models\Network;
use App\Data\Models\User;
use Illuminate\Database\Seeder;

class SocialAccountsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public final function run(): void
    {
        $user_id = User::first()->id;

        $application = Application::create([
            'user_id' => $user_id,
            'name' => 'Social Bot #1',
        ]);

        Network::create([
            'application_id' => $application->id,
            'name' => 'linkedin',
            'configuration' => json_encode([
                'client_id' => config('social.linkedin.client_id'),
                'client_secret' => config('social.linkedin.client_secret'),
                'redirect' => config('social.linkedin.redirect_uri'),
                'scopes' => config('social.linkedin.scopes'),
            ]),
        ]);


        Network::create([
            'application_id' => $application->id,
            'name' => 'twitter',
            'configuration' => json_encode([
                'client_id' => config('social.twitter.client_id'),
                'client_secret' => config('social.twitter.client_secret'),
                'redirect' => config('social.twitter.redirect_uri'),
                'scopes' => config('social.twitter.scopes'),
            ]),
        ]);


        Network::create([
            'application_id' => $application->id,
            'name' => 'github',
            'configuration' => json_encode([
                'client_id' => config('social.github.client_id'),
                'client_secret' => config('social.github.client_secret'),
                'redirect' => config('social.github.redirect_uri'),
                'scopes' => config('social.github.scopes'),
            ]),
        ]);


        Network::create([
            'application_id' => $application->id,
            'name' => 'google',
            'configuration' => json_encode([
                'client_id' => config('social.google.client_id'),
                'client_secret' => config('social.google.client_secret'),
                'redirect' => config('social.google.redirect_uri'),
                'scopes' => config('social.google.scopes'),
            ]),
        ]);




        Network::create([
            'application_id' => $application->id,
            'name' => 'facebook',
            'configuration' => json_encode([
                'client_id' => config('social.facebook.client_id'),
                'client_secret' => config('social.facebook.client_secret'),
                'redirect' => config('social.facebook.redirect_uri'),
                'scopes' => config('social.facebook.scopes'),
            ]),
        ]);

    }
}
