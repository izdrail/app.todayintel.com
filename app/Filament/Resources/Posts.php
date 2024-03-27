<?php

namespace App\Filament\Resources;


use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use App\Agents\BlogAgent;
use App\Agents\GithubAgent;
use App\Agents\LinkedInAgent;
use App\Agents\TwitterAgent;
use App\Data\Models\Post;
use App\Filament\Resources\Posts\Pages\CreatePosts;
use App\Filament\Resources\Posts\Pages\EditPosts;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Pages\ShareAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 *
 */
class
Posts extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';


    protected static ?string $label = "Posts";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->label('Type')
                    ->columnSpan('full')
                    ->placeholder('Type'),
                RichEditor::make('content')
                    ->label('Content')
                    ->columnSpan('full')
                    ->placeholder('Content'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns((new Posts)->getColumns())
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        GithubAgent::class => 'Github',
                        BlogAgent::class => 'Blog',
                        TwitterAgent::class => 'Twitter',
                        LinkedInAgent::class => 'LinkedIn',

                    ]),

                SelectFilter::make('is_published')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Draft',
                    ])
            ])
            ->actions([
                ViewAction::make(),
                //todo fix this
                TableAction::make('share')
                    ->label('Share')
                    ->url(static fn(Post $post): string => route('social.share', [
                        'post' => $post,
                    ]))
                    ->icon('heroicon-o-share'),
            ]);
    }

    public static function getPages(): array
    {
        //fix this
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePosts::route('/create'),
            'edit' => EditPosts::route('/{record}/edit'),
            'share' => ShareAction::route('/{record}/share'),
        ];
    }



    private function getColumns(): array
    {
        return [
            ViewColumn::make('type')->view('filament.tables.columns.type'),
            ViewColumn::make('sentiment')->view('filament.tables.columns.sentiment'),
            TextColumn::make('article.title')
                ->wrap()
                ->sortable(),
            TextColumn::make('is_published')
                ->sortable(),
            TextColumn::make('updated_at')
                 ->sortable()->since(),
        ];
    }

}
