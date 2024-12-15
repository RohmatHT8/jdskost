<?php

namespace App\Filament\Resources\UserRoomResource\Pages;

use App\Filament\Resources\UserRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserRoom extends EditRecord
{
    protected static string $resource = UserRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
