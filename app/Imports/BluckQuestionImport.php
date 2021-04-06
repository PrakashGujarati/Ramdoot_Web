<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BluckQuestionImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function model(array $row)
    {
        $request=$this->request;   
        return new Question([
            'board_id' => $row['board'],
            'medium_id' => $row['medium'],
            'standard_id' => $row['standard'],
            'semester_id' => $row['semester'],
            'subject_id' => $row['subject'],
            'unit_id' => $row['unit'],
            'question' => $row['question'],
           'note'    => $row['note'],
           'option_a' => $row['option_a'],
           'option_b' => $row['option_b'],
           'option_c' => $row['option_c'],
           'option_d' => $row['option_d'],
           'answer' => $row['answer'],
           'per_question_marks' => $row['per_question_marks'],
        ]);
    }
}
