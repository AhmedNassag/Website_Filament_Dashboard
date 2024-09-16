<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Filament\Resources\ProgramResource\RelationManagers;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label(__('filament.category'))
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.name'))
                    ->required()
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

                Forms\Components\TextInput::make('slug')
                    ->label(__('filament.slug'))
                    ->required(),
                Forms\Components\TextInput::make('short_description')
                    ->label(__('filament.short_description'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label(__('filament.price'))
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\RichEditor::make('description')
                ->label(__('filament.description'))
                ->required()
                ->columnSpan('full')
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'h2',
                    'h3',
                    'link',
                    'orderedList',
                    'redo',
                    'underline',
                    'undo',
                ])
                // Forms\Components\TextInput::make('slug')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('filament.category'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->label(__('filament.short_description'))
                    ->searchable(),
                // Tables\Columns\TextColumn::make('description')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('filament.price'))
                    ->money()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('slug')
                //     ->searchable(),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.programs');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.programs');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.programs');
    }

    public static function getModelLabel(): string
    {
        return __('filament.programs');
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

}
