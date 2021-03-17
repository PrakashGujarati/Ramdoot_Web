<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Standard List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Board</th>
                    <th>Medium</th>
                    <th>Standard</th>
                    <th>Section</th>
                    <th>Thumbnail</th>
                </tr>
            </thead>
            <tbody>

                @if(count($standard_details) > 0)
                    @foreach($standard_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ $data->standard }}</td>
                        <td>{{ $data->section }}</td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/standard/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
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