<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament.name'))  // Arabic for "Name"
                    ->required(),
                TextInput::make('short_description')
                    ->label(__('filament.short_description'))  // Arabic for "Short Description"
                    ->required(),
                Textarea::make('description')
                    ->label(__('filament.description'))  // Arabic for "Description"
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label(__('filament.name')),
                TextColumn::make('short_description')->sortable()->searchable()->limit(25)->label(__('filament.short_description')),
                TextColumn::make('description')->limit(50)->limit(50)->label(__('filament.description')),
                TextColumn::make('created_at')->label('Created At')->dateTime()->label(__('filament.Created_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.Service');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.Services');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Services');
    }

    public static function getModelLabel(): string
    {
        return __('filament.Service');
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }
}
