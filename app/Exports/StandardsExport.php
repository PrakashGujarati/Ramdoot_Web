<?php

namespace App\Exports;

use App\Models\Standard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StandardsExport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
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
        $standards=[];
        foreach ($this->data as $value) {
            $standards[] = array(
                'id' => $value->id,
                'board_id' => $value->board_id,
                'board_name' => isset($value->board->name) ? $value->board->name:'',
                'medium_id' => $value->medium_id,
                'medium_name' => isset($value->medium->medium_name) ? $value->medium->medium_name:'',
                'standard' => $value->standard,
                'sub_title' => $value->sub_title,
                'section' => $value->section,
                'thumbnail_file_type' => $value->thumbnail_file_type,
                'thumbnail' => $value->thumbnail,
                'status' => $value->status,
                'order_no' => $value->order_no,
            );
        }

        return collect([
            $standards
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
	    	"Standard",
            "Sub Title",
	    	"Section",
            "Thumbnail File Type",
	    	"Thumbnail",
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
