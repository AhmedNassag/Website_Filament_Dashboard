<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\AboutUs;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AboutUsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AboutUsResource\RelationManagers;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('main_description')
                    ->label(__('filament.description'))
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                // Forms\Components\TextInput::make('title')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('description')
                //     ->required()
                //     ->maxLength(65535)
                //     ->columnSpanFull(),
                Repeater::make('details')
                    ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('filament.title'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('description')
                        ->label(__('filament.description'))
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                       ])->columnSpanFull()
                    ->columns(2)
                            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('main_description')
                    ->label(__('filament.description'))
                    ->searchable(),
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.about_us');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.about_us');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.about_us');
    }

    public static function getModelLabel(): string
    {
        return __('filament.about_us');
    }

    public static function getNavigationSort(): ?int
    {
        return 7;
    }
}
