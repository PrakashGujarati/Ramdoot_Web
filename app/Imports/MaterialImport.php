<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Material([
            'board_id' => $row['board_id'],
            'medium_id' => $row['medium_id'],
            'standard_id' => $row['standard_id'],
            'subject_id' => $row['subject_id'],
            'semester_id' => $row['semester_id'],
            'unit_id' => $row['unit_id'],
            'user_id' => $row['user_id'],
            'question' => $row['question'],
            'answer' => $row['answer'],
            'marks' => $row['marks'],
            'image' => $row['image'],
            'image_file_type' => $row['image_file_type'],
            'label' => $row['label'],
            'question_type' => $row['questiontype_id'],
            'level' => $row['level'],
            'status' => $row['status'],
            'order_no' => $row['order_no']
        ]);
    }
}
