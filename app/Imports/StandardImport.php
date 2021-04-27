<?php

namespace App\Imports;

use App\Models\Standard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StandardImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Standard([
            'board_id' => $row['board_id'],
            'medium_id' => $row['medium_id'],
            'standard' => $row['standard'],
            'section' => $row['section'],
            'thumbnail' => $row['thumbnail'],
            'status' => $row['status'],
            'order_no' => $row['order_no'],
        ]);
    }
}
