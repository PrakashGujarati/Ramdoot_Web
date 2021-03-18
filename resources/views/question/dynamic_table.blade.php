<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Question List</h5>
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
                    <th>Option A</th>
                    <th>Option B</th>
                    <th>Option C</th>
                    <th>Option D</th>
                    <th>Answer</th>
                    <th>Note</th>
                    <th>Per Question Marks</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>

                @if(count($question_details) > 0)
                    @foreach($question_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->question }}</td>
                        <td>{{ $data->option_a }}</td>
                        <td>{{ $data->option_b }}</td>
                        <td>{{ $data->option_c }}</td>
                        <td>{{ $data->option_d }}</td>
                        <td>{{ $data->answer }}</td>
                        <td>{{ $data->note }}</td>
                        <td>{{ $data->per_question_marks }}</td>
                        <td>{{ $data->level }}</td>
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