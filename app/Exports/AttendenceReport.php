<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendenceReport implements FromCollection,WithHeadings,ShouldAutoSize, WithEvents
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
        $mediums=[];
        if($this->data) {
        	foreach ($this->data as $key => $value) {
        		$mediums[] = array(
        			'date' => $value['date'],
	                'user_name' => $value['user_name'],
	                'mobile' => $value['mobile'],
	                'status' => $value['attendence']
	            );
        	}
        }

        return collect([
            $mediums
        ]);
    }

    public function headings(): array
    {
        return [
        	'Date',
            "User Name",
            "Mobile Number",
            "Status",
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
