<div class="col-md-12">
    <div class="card-inner">
                <table class="datatable-init table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Type</th>
                            <th>DateTime</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($getData) > 0)
                        @foreach($getData as $data)
                        <tr>
                            <td>{{$data->user->name}}</td>
                            <td>{{$data->type}}</td>
                            <td>{{$data->upload_time}}</td>
                            <td>{{$data->operation}}</td>
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