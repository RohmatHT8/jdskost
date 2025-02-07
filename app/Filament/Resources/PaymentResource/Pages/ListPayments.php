<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Export')
            ->label('Export Data')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(fn() => Excel::download(new PaymentsExport, 'payments.xlsx')),
        ];
    }
}
