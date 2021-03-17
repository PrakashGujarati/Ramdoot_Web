<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Medium List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Board</th>
                    <th>Medium</th>
                </tr>
            </thead>
            <tbody>

                @if(count($mediums_details) > 0)
                    @foreach($mediums_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ $data->medium_name }}</td>
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