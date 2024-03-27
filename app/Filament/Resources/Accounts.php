<?php

namespace App\Filament\Resources;


use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use App\Data\Models\SocialAccount;
use App\Filament\Resources\Accounts\Pages\EditAccounts;
use App\Filament\Resources\Accounts\Pages\ListAccounts;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

/**
 *
 */
class Accounts extends Resource
{
    protected static ?string $model = SocialAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static ?string $label = "Accounts";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Name'),
                TextInput::make('provider')
                    ->label('Provider')
                    ->placeholder('Provider'),
                JSONEditor::make('data')
                    ->label('Data'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('provider'),
                TextColumn::make('updated_at'),

            ])
            ->filters([

            ])
            ->actions([
                EditAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        //fix this
        return [
            'index' => ListAccounts::route('/'),
            'edit' => EditAccounts::route('/{record}/edit'),
        ];
    }
}
