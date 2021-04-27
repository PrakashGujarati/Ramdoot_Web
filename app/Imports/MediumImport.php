<?php

namespace App\Imports;

use App\Models\Medium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MediumImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Medium([
            'board_id' => $row['board_id'],
            'medium_name' => $row['medium_name'],
            'status' => $row['status'],
            'order_no' => $row['order_no']
        ]);
    }
}
