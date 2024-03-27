<?php

namespace SaturnPHP\Intel\Jobs;

use SaturnPHP\Intel\Actions\GetAnswer;
use SaturnPHP\Intel\Channels\Heljan;
use SaturnPHP\Intel\Channels\Questions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Waterhole\Models\Post;
use \Illuminate\Support\Str;
use Waterhole\Models\User;

class GeneratePost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $instruction;
    protected string $context;
    protected int $channel;
    /**
     * Create a new job instance.
     */
    public function __construct(string $instruction, string $context, int $channel)
    {
        $this->instruction = $instruction;
        $this->context = $context;
        $this->channel = $channel;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            'messages' => [
                ['role' => 'system', 'content' => $this->instruction],
                ['role' => 'user', 'content' => $this->context]
            ]
        ];
        $answer = new GetAnswer();

        $response = $answer->execute($data);

        $this->saveAnswer($response);
    }


    /**
     * @param string $cloudflareResponse
     * @return void
     * @todo move this to a class or something
     */
    private function saveAnswer(string $cloudflareResponse): void
    {
        $cloudflareResponse = json_decode($cloudflareResponse);
        $title = Str::words($cloudflareResponse->result->response,rand(8,15));

        $post = new Post();
        $post->title = $title;
        $post->slug = Str::slug($title);
        $post->body = $cloudflareResponse->result->response;
        $post->channel_id = $this->channel;
        $post->user_id = User::all()->random()->id;
        $post->comment_count = 0;
        $post->score = 0;
        $post->is_locked = false;
        $post->is_pinned = false;
        $post->answer_id = null;
        $post->view_count = 1;
        $post->hotness = 12612.8204;
        $post->save();

    }
}
