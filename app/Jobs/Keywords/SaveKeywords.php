<?php

namespace App\Jobs\Keywords;

use App\Data\DTO\KeywordDTO;
use App\Data\Models\Keyword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Bus\UnitDispatcher;
use Lucid\Units\Job;

class SaveKeywords extends Job implements ShouldQueue
{
    public int $timeout = 90;

    use UnitDispatcher;


    //rewrite this to use model
    public function __construct(
        private readonly KeywordDTO $keywordDTO
    )
    {
    }

    final public function handle(): void
    {

        $data = $this->keywordDTO->toArray();

        ++$data['count'];

        Keyword::updateOrCreate(['keyword' => $data['keyword']], $data);

    }
}
