<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Board List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Abbreviation</th>
                    <th>Thumbnail</th>
                </tr>
            </thead>
            <tbody>

                @if(count($boards_details) > 0)
                    @foreach($boards_details as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->abbreviation }}</td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/board/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
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