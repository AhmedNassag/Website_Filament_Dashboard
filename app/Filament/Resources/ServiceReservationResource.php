<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceReservationResource\Pages;
use App\Filament\Resources\ServiceReservationResource\RelationManagers;
use App\Models\ServiceReservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceReservationResource extends Resource
{
    protected static ?string $model = ServiceReservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('filament.name')),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->label(__('filament.email')),

                Forms\Components\TextInput::make('mobile')
                    ->required()
                    ->maxLength(20) // Adjust length as needed
                    ->label(__('filament.Mobile')),

                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name') // Adjust 'name' if the related model uses a different column
                    ->required()
                    ->label(__('filament.Service')),

                Forms\Components\Select::make('status')
                    ->options([
                        'تم' => 'تم',
                        'لم يتم' => 'لم يتم',
                    ])
                    ->required()
                    ->label(__('filament.status')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name')),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.email')),

                Tables\Columns\TextColumn::make('service.name') // Adjust 'name' if the related model uses a different column
                    ->label(__('filament.Service')),

                Tables\Columns\TextColumn::make('service.Mobile') // Adjust 'name' if the related model uses a different column
                    ->label(__('filament.Mobile')),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament.status')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.Created_at'))
                    ->dateTime(),
            ])
            ->filters([
                // Define any filters you need
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListServiceReservations::route('/'),
            // 'create' => Pages\CreateServiceReservation::route('/create'),
            // 'edit' => Pages\EditServiceReservation::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.Service Reservation');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.Services Reservation');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Services Reservation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.Service Reservation');
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }
}
