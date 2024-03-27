<?php

namespace App\Listeners;
use App\Events\ExtractArticleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

use Illuminate\Queue\InteractsWithQueue;

class ExtractArticleHandler implements ShouldQueue, ShouldHandleEventsAfterCommit
{

    use InteractsWithQueue;


    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public ?string $queue = 'default';


    /**
     * Reward a gift card to the customer.
     */
    final function handle(ExtractArticleEvent $event): void
    {
       dd($event->article->title);
    }
}


