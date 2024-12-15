<?php

namespace App\Filament\Resources\UserRoomResource\Pages;

use App\Filament\Resources\UserRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRooms extends ListRecords
{
    protected static string $resource = UserRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
