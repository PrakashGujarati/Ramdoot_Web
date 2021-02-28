<table class="table" id="exam_student_tale" style="border:1px solid #dbdfea;">
    <thead>
        <tr>
            <th>Exam</th>
            <th>Student</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
    	@if(count($examstudent_details) > 0)
    	@foreach($examstudent_details as $data)
        <tr>
            <td>{{ isset($data->exam->name) ? $data->exam->name:'' }}</td>
            <td>{{ isset($data->user->name) ? $data->user->name:'' }}</td>
            {{--<td>
            	<a href="#"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
            	<a href="javascript:;" data-url="#" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
            </td>--}}
        </tr>
        @endforeach
        @else
        <tr>
        	<td colspan="2">No Record Found.</td>
        </tr>
        @endif
    </tbody>
</table>