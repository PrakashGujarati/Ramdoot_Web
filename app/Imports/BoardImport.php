<?php

namespace App\Imports;

use App\Models\Board;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BoardImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Board([
            'name' => $row['name'],
            'sub_title' => $row['sub_title'],
            'abbreviation' => $row['full_form_of_boardorganisation'],
            'thumbnail' => $row['thumbnail'],
            'status' => $row['status'],
            'order_no' => $row['order_no'],
        ]);
    }
}
