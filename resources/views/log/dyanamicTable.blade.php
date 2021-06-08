<div class="col-md-12">
    <div class="card-inner">
                <table class="datatable-init table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>DateTime</th>
                            <th>Operation</th>
                            <th>Role</th>
                            <th>Interval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($getData) > 0)
                        <?php
                            $dateTime1 = date_create($getData[0]->upload_time);
                        ?>
                        @foreach($getData as $data)
                        <?php
                            $dateDifference = date_diff($dateTime1, date_create($data->upload_time));
                            $minutes = $dateDifference->days * 24 * 60;
                            $minutes += $dateDifference->h * 60;
                            $interval = $minutes+$dateDifference->i;
                        ?>
                        <tr>
                            <td>{{$data->type}}</td>
                            <td>{{$data->upload_time}}</td>
                            <td>{{$data->operation}}</td>
                            <td>{{$role ? $role->slug : ''}}</td>
                            <td>
                                <span class="@if($interval <= 5) text-success @else text-danger @endif">
                                    {{$interval}} minutes
                                </span>
                            </td>
                        </tr>
                        <?php
                            $dateTime1 = date_create($data->upload_time);
                        ?>
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
