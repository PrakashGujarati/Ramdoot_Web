<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;



class QuestionBlankExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function array(): array
    {
        return [
            [
            	"Board",
            	"Medium",
            	"Standard",
            	"Semester",
            	"Subject",
            	"Unit",
	        	"Question",
	        	"note",
	            "option_a",
	            "option_b",
	            "option_c",
	            "option_d",
	            "answer",
	            "per_question_marks",
	        ],
	            [
	        	$this->request->board_id,
	        	$this->request->medium_id,
	        	$this->request->standard_id,
	        	$this->request->semester_id,
	        	$this->request->subject_id,
	        	$this->request->unit_id,
	        	"Question Data",
	        	"Note Data",
	            "option_a",
	            "option_b",
	            "option_c",
	            "option_d",
	            "answer",
	            "per_question_marks",
	        ]
        ];
    }
}
