<?php

namespace App\Filament\Resources;

use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;
use Filament\Tables\Table;
use App\Data\Models\Network;
use App\Filament\Resources\Networks\Pages\CreateNetworks;
use App\Filament\Resources\Networks\Pages\EditNetworks;
use App\Filament\Resources\Networks\Pages\ListNetworks;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class Networks extends Resource
{
    protected static ?string $model = Network::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                JSONEditor::make('configuration')
            ]);
    }

    public static function table(TableAction|Table $table): Table
    {
        $account = Auth::user()->id;

        return $table
            ->columns([
                TextColumn::make('name')->icon('heroicon-o-lock-closed'),


            ])
            ->filters([
                //
            ])
            ->actions([
                TableAction::make('login')
                    ->icon('heroicon-o-lock-closed')
                    ->url(static fn(Network $network): string => route('social.login', [
                        'provider' => $network->name,
                        'account' => $account
                    ]))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNetworks::route('/'),
            'create' => CreateNetworks::route('/create'),
            'edit' => EditNetworks::route('/{record}/edit'),
        ];
    }
}
