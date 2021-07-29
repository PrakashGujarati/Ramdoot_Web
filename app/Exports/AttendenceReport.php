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

    public function __construct($data,$get_dates)
    {
        $this->data = $data;
        $this->get_dates = $get_dates;
    }

    public function collection()
    {
    	//dd($this->get_dates);
        $data_array=[];
        if($this->data) {
        	foreach ($this->data as $key => $value) {

        		$inner_data=[];
        		foreach ($this->get_dates as $key_dates => $value_dates) {
        			$inner_data[$value_dates] = $value[$value_dates];
        		}

        	$staticarr = ['user_name' => $value['user_name'],'mobile' => $value['mobile']];
        	//dd($inner_data,$staticarr);
        	$data_array[] = array_merge($staticarr,$inner_data);
        		
        	}
        }
        return collect([
            $data_array
        ]);
    }

    public function headings(): array
    {

    	$static_column = ['User Name','Mobile'];
    	$dynamic_column=[];
    	foreach ($this->get_dates as $key => $value) {
    		$dynamic_column[] = date('d-m-Y',strtotime($value));
    	}
    	$final_array = array_merge($static_column,$dynamic_column);
    	return $final_array;
        // return [
        // 	'Date',
        //     "User Name",
        //     "Mobile Number",
        //     "Status",
        // ];
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
