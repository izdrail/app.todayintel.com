<?php

namespace App\Filament\Resources\Posts\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Posts;
use Filament\Resources\Pages\EditRecord;

class EditPosts extends EditRecord
{
    protected static string $resource = Posts::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }



}
