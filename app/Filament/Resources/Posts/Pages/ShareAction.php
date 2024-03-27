<?php

namespace App\Filament\Resources\Posts\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Posts;
use Filament\Resources\Pages\ListRecords;

class ShareAction extends ListRecords
{
    protected static string $resource = Posts::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function __construct()
    {
    }

    public function __invoke()
    {
        return $this->resource;
    }
}
