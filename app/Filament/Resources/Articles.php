<?php

namespace App\Filament\Resources;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use App\Data\Models\Article;
use App\Filament\Resources\Articles\Pages\CreateArticles;
use App\Filament\Resources\Articles\Pages\EditArticles;
use App\Filament\Resources\Articles\Pages\ListArticles;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 *
 */
class Articles extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';


    protected static ?string $label = "Articles";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->columnSpan('full')
                    ->placeholder('Title'),
                RichEditor::make('body')
                    ->label('Body')
                    ->columnSpan('full')
                    ->placeholder('Body'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->limit(75),
                TextColumn::make('status')->sortable()->icon('heroicon-o-check')->iconColor(static fn(Article $article): string => match ($article->status) {
                    'pending' => '#444444',
                    'processed' => '#5555',
                }),
                TextColumn::make('created_at')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => Article::PENDING,
                        'processed' => Article::PROCESSED,
                    ])
            ])
            ->actions([
                ViewAction::make(),
                TableAction::make('generate')
                    ->label('Generate')
                    ->url(static fn(Article $article): string => route('ai.generate', [
                        'article' => $article,
                    ]))
                    ->icon('heroicon-o-share'),
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
        //fix this
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticles::route('/create'),
            'edit' => EditArticles::route('/{record}/edit'),
        ];
    }

}
