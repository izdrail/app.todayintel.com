<?php

namespace App\Filament\Resources\Networks\Pages;


use Filament\Actions\CreateAction;
use App\Filament\Resources\Networks;
use Filament\Resources\Pages\ListRecords;

class ListNetworks extends ListRecords
{
    protected static string $resource = Networks::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
