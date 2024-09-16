<?php

namespace App\Filament\Resources\ServiceReservationResource\Pages;

use App\Filament\Resources\ServiceReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceReservations extends ListRecords
{
    protected static string $resource = ServiceReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
