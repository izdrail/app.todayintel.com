<?php

namespace App\Filament\Resources\Networks\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Networks;
use Filament\Resources\Pages\EditRecord;

class EditNetworks extends EditRecord
{
    protected static string $resource = Networks::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
