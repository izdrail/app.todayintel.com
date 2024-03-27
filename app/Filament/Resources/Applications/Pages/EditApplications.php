<?php

namespace App\Filament\Resources\Applications\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\Applications;
use Filament\Resources\Pages\EditRecord;

class EditApplications extends EditRecord
{
    protected static string $resource = Applications::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
