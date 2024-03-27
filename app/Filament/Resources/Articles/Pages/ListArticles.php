<?php

namespace App\Filament\Resources\Articles\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Articles;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = Articles::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
