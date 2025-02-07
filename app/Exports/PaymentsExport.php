<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payment::select(
            'no',
            'amount',
            'note',
            'date'
        )
            ->where('status', 'approve')
            ->get()
            ->makeHidden('anual_payment');
    }

    public function headings(): array
    {
        return ["No", "Amount", "Note", "Date"];
    }
}
