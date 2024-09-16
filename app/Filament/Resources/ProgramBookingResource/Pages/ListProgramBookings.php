<?php

namespace App\Filament\Resources\ProgramBookingResource\Pages;

use App\Filament\Resources\ProgramBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramBookings extends ListRecords
{
    protected static string $resource = ProgramBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
