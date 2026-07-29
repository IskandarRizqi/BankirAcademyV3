<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IhtParticipantImport implements ToCollection, WithHeadingRow
{
    public const REQUIRED_HEADERS = ['nama', 'email', 'nomor_handphone'];

    public Collection $rows;

    public function __construct()
    {
        $this->rows = collect();
    }

    public function collection(Collection $rows)
    {
        $firstRow = $rows->first();

        if (! $firstRow) {
            return;
        }

        $headers = array_keys($firstRow->toArray());

        // Ignore instruction sheets and keep the sheet containing participant headers.
        if (empty(array_diff(self::REQUIRED_HEADERS, $headers))) {
            $this->rows = $rows;
        }
    }
}
