<?php

namespace App\Filament\Resources\Accounts\Pages;

use Filament\Actions\DeleteAction;
use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;
use App\Filament\Resources\Accounts;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditAccounts extends EditRecord
{
    protected static string $resource = Accounts::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Name'),
                JSONEditor::make('data')
                    ->label('Data')
            ]);
    }

}
