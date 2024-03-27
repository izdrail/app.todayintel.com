<?php

namespace App\Filament\Resources\Posts\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Posts;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = Posts::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
