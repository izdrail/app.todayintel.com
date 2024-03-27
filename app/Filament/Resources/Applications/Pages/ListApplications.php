<?php

namespace App\Filament\Resources\Applications\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Applications;
use Filament\Resources\Pages\ListRecords;

class ListApplications extends ListRecords
{
    protected static string $resource = Applications::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
