<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnitSampleExport implements FromCollection
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
        $units=[];
        foreach ($this->data as $value) {
            $units[] = array(
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
                "title" => $value->title,
                'sub_title' => isset($value->sub_title) ? $value->sub_title:'',
                "url_type" => isset($value->url_type) ? $value->url_type:'',
                'url' => isset($value->url) ? $value->url:'',
                'thumbnail' => isset($value->thumbnail) ? $value->thumbnail:'',
                'pages' => $value->pages,
                'description' => $value->description,
                'status' => $value->status,
                'order_no' => $value->order_no
            );
        }

        return collect([
            $units
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
	        "Title",
	        "Sub Title",
	        "Url Type",
	        "URL",
	    	"Thumbnail",
	        "Pages",
	        "Description",
	        "Status",
	        "Order No",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(14);
            },
        ];
    }
}
