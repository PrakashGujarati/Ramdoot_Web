<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Material List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Board</th>
                    <th>Medium</th>
                    <th>Standard</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Unit</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Marks</th>
                    <th>Label</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>

                @if(count($material_details) > 0)
                    @foreach($material_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->question }}</td>
                        <td>{{ $data->answer }}</td>
                        <td>{{ $data->marks }}</td>
                        <td>{{ $data->label }}</td>
                        <td>
                            @if($data->image)
                            <img src="{{ asset('upload/material/thumbnail/'.$data->image) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No Record Found.</td>
                    </tr>
                @endif

            </tbody>
        </table>
        </div>
    </div>
</div><!-- .card-preview -->