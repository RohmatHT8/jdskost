<?php

use Carbon\Carbon;

if (! function_exists('formatDateIndo')) {
    /**
     * Format tanggal dalam format 'Jumat 22 November 2024'.
     *
     * @param  string $date
     * @return string
     */
    function formatDateIndo($date)
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY');
    }

    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
