<?php

namespace App\Filament\Resources\Articles\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Posts;
use Filament\Resources\Pages\EditRecord;

class EditArticles extends EditRecord
{
    protected static string $resource = Posts::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
