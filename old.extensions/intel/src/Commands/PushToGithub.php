<?php

namespace SaturnPHP\Intel\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class PushToGithub extends Command
{
    protected $signature = 'github:push';
    protected $description = 'Push a file to GitHub repository';

    public function handle(): void
    {
        $token = '';
        $repoOwner = 'saturnphp'; // Replace with the repository owner's username
        $repoName = 'app.todayintel.com'; // Replace with the repository name

        $fileName = resource_path('js/chat.js');

        $client = new Client([
            'base_uri' => "https://api.github.com/repos/{$repoOwner}/{$repoName}/",
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        $response = $client->get('git/ref/heads/master');
        $commitSHA = json_decode($response->getBody(), true)['object']['sha'];


//        dd($commitSHA, $fileName);
        $response = $client->post('git/trees', [
            'json' => [
                'base_tree' => $commitSHA,
                'tree' => [
                    [
                        //the path is the repo path to publish the file
                        'path' => "resources/js/chat.js",
                        'mode' => '100644',
                        'type' => 'blob',
                        'content' => base64_encode(file_get_contents($fileName)),
                    ],
                ],
            ],
        ]);

        $treeSHA = json_decode($response->getBody(), true)['sha'];

        $response = $client->post('git/commits', [
            'json' => [
                'message' => 'Add file via API',
                'parents' => [$commitSHA],
                'tree' => $treeSHA,
            ],
        ]);

        $commit = json_decode($response->getBody(), true);
        $newCommitSHA = $commit['sha'];

        $client->patch('git/refs/heads/master', [
            'json' => [
                'sha' => $newCommitSHA,
            ],
        ]);
    }
}
