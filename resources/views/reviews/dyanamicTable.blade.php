<div class="col-md-12">
    <div class="card-inner">
                <table class="datatable-init table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Type</th>
                            <th>DateTime</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($getData) > 0)
                        @foreach($getData as $data)
                        <tr>
                            <td>{{$data->user->name}}</td>
                            <td>{{$data->type}}</td>
                            <td>{{$data->review_time}}</td>
                            <td>
                                @if($data->status == 'Pending')
                                    <a href="{{route('accept.review',$data->id)}}" class="btn btn-info">Accept</a>
                                    <a href="{{route('reject.review',$data->id)}}" class="btn btn-danger">Reject</a> 
                                @else
                                    {{$data->status}}
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