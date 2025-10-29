<?php

namespace App\Imports;

use App\Models\corporate;
use App\Models\CorporateModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CorporateImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            CorporateModel::updateOrCreate([
                'nama' => $row[1],
                'jenis' => 'bprs'
            ], [
                'alamat' => $row[2],
                'no_telp' => $row[3],
                'jenis' => 'bprs'
            ]);
        }
    }
}
