<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new Question([
            'board_id' => $row['board_id'],
            'board_name' => $row['board_name'],
            'medium_id' => $row['medium_id'],
            'medium_name' => $row['medium_name'],
            'standard_id' => $row['standard_id'],
            'subject_id' => $row['subject_id'],
            'subject_name' => $row['subject_name'],
            'semester_id' => $row['semester_id'],
            'semester_name' => $row['semester_name'],
            'unit_id' => $row['unit_id'],
            'unit_name' => $row['unit_name'],
            'question' => $row['question'],
            'note' => $row['note'],
            'option_a' => $row['option_a'],
            'option_b' => $row['option_b'],
            'option_c' => $row['option_c'],
            'option_d' => $row['option_d'],
            'answer' => $row['answer'],
            'per_question_marks' => $row['per_question_marks'],
            'level' => $row['level'],
            'status' => $row['status']
        ]);
    }
}
