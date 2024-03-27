<?php
declare(strict_types=1);
namespace  SaturnPHP\Intel\Actions;

use  SaturnPHP\Intel\Http\Requests\CreatePostRequest;

class CreateThreadAction
{

    public function __construct(private readonly CreatePostRequest $request)
    {
    }

    final public function handle(): void
    {
        $this->request->validated();

    }
}
