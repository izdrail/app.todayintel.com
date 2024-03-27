<?php

namespace App\Filament\Resources\Accounts\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Accounts;
use Filament\Resources\Pages\ListRecords;

class ListAccounts extends ListRecords
{
    protected static string $resource = Accounts::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
