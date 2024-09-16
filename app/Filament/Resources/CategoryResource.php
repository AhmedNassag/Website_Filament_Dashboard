<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use voku\helper\ASCII;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\SlugInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament.Name'))
                    ->required()
                    ->unique()
                    ->maxLength(255)
                    ->reactive() // Trigger event when input changes
                    ->afterStateUpdated(function (?string $state, callable $set) {
                        if ($state) {
                            // Replace spaces with hyphens, but keep Arabic characters intact
                            $slug = preg_replace('/\s+/u', '-', trim($state)); // Replace spaces with hyphens
                            $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-]+/u', '', $slug); // Remove non-Arabic and non-alphanumeric characters, allow hyphens
                            $set('slug', $slug); // Set the generated slug
                        }
                }),

                Textarea::make('slug')
                    ->label(__('filament.Slug'))
                    ->required()
                    ->unique(),

                TextInput::make('order')
                ->label(__('filament.Order'))
                ->numeric(),

                Select::make('parent_id')
                    ->label(__('filament.Category'))
                    ->options(function () {
                        return Category::pluck('name', 'id');
                    })
                    ->nullable()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label(__('filament.Order'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('filament.Slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('filament.Parent'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }




    // start translation of models
    public static function getNavigationLabel(): string
    {
        return __('filament.Categories');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Categories');
    }

    public static function getModelLabel(): string
    {
        return __('filament.Category');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

}
