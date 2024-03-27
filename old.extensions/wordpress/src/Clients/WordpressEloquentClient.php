<?php

namespace Cornatul\Wordpress\Clients;

use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\Connector\WordpressConnector;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Cornatul\Wordpress\WordpressRequests\CreateCategoryRequest;
use Cornatul\Wordpress\WordpressRequests\CreatePostRequest;
use Cornatul\Wordpress\WordpressRequests\CreateTagRequest;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

/**
 *
 */
final class WordpressEloquentClient
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;



}
