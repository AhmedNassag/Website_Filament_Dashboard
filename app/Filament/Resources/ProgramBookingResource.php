<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProgramBooking;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramBookingResource\Pages;
use App\Filament\Resources\ProgramBookingResource\RelationManagers;

class ProgramBookingResource extends Resource
{
    protected static ?string $model = ProgramBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('program_id')
                //     ->label(__('filament.program'))
                //     ->required()
                //     ->numeric(),
                Forms\Components\Select::make('program_id')
                    ->label(__('filament.program'))
                    ->required()
                    ->relationship('program', 'name'), // 'program' is the relation name and 'name' is the field you want to display
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('filament.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.name')
                    ->label(__('filament.program'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament.phone'))
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
                Tables\Actions\ActionGroup::make([
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
            'index' => Pages\ListProgramBookings::route('/'),
            // 'create' => Pages\CreateProgramBooking::route('/create'),
            'edit' => Pages\EditProgramBooking::route('/{record}/edit'),
        ];
    }


    public static function getPluralModelLabel(): string
    {
        return __('filament.Program_Bookings');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.Program_Bookings');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Program_Bookings');
    }

    public static function getModelLabel(): string
    {
        return __('filament.Program_Bookings');
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
}
