<?php

namespace App\Exports;

use App\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorksheetsExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private  $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $worksheets=[];
        foreach ($this->data as $value) {
            $worksheets[] = array(
                'id' => $value->id,
                'board_id' => $value->board_id,
                'board_name' => isset($value->board->name) ? $value->board->name:'',
                'medium_id' => $value->medium_id,
                'medium_name' => isset($value->medium->medium_name) ? $value->medium->medium_name:'',
                'standard_id' => $value->standard_id,
                'standard' => isset($value->standard->standard) ? $value->standard->standard:'',
                'subject_id' => $value->subject_id,
                'subject_name' => isset($value->subject->subject_name) ? $value->subject->subject_name:'',
                "semester_id" => $value->semester_id,
                "semester_name" => isset($value->semester->semester) ? $value->semester->semester:'',
                'unit_id' => $value->unit_id,
                "unit_name" => isset($value->unit->title) ? $value->unit->title:'',
                "user_id" => $value->user_id,
                "title" => $value->title,
                'sub_title' => isset($value->sub_title) ? $value->sub_title:'',
                "url_type" => isset($value->url_type) ? $value->url_type:'',
                'url' => isset($value->url) ? $value->url:'',
                'thumbnail_file_type' => $value->thumbnail_file_type,
                'thumbnail' => isset($value->thumbnail) ? $value->thumbnail:'',
                'pages' => $value->pages,
                'label' => isset($value->label) ? $value->label:'',
                'description' => $value->description,
                'edition' => $value->edition,	
                'release_date' => $value->release_date,                
                'status' => $value->status,
                'order_no' => $value->order_no
            );
        }

        return collect([
            $worksheets
        ]);
    }


    public function headings(): array
    {
        return [
        	'Id',
            "Board Id",
            "Board Name",
            "Medium Id",
            "Medium Name",
	    	"Standard Id",
            "Standard Name",
	    	"Subject Id",
            "Subject Name",
	    	"Semester Id",
	    	"Semester Name",
	    	"Unit Id",
	    	"Unit Name",
	    	"User Id",
	    	"Title",
	        "Sub Title",
	        "URL File Type",
	        "URL",
            "Thumbnail File Type",
	    	"Thumbnail",
	        "Pages",
	        "Label",
	        "Description",
	        "Edition",
			"Release Date",        
	        "Status",
	        "Order No"
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
