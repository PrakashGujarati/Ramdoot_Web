<?php

namespace App\Imports;

use App\Models\Board;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;


class BoardImport implements ToModel,WithHeadingRow
{
    use Importable;

    
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
            'thumbnail_file_type' => $row['thumbnail_file_type'],
            'thumbnail' => $row['thumbnail'],
            'status' => $row['status'],
            'order_no' => $row['order_no'],
        ]);
    }
}
