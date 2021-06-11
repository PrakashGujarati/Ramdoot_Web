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
                    <th>Minutes</th>
                </tr>
            </thead>
            <tbody>
                @if(count($getData) > 0)
                @php
                $totalInterval = 0;
                @endphp
                @for($i=0; $i < count($getData); $i++)
                <?php
                    $nextKey = $i+1;
                    if (($i != count($getData)-1)) {
                        $dateDifference = date_diff(date_create($getData[$i]->upload_time), date_create($getData[$nextKey]->upload_time));
                        $minutes = $dateDifference->days * 24 * 60;
                        $minutes += $dateDifference->h * 60;
                        $interval = $minutes+$dateDifference->i;
                    } else {
                        $interval = 0;
                    }
                    $totalInterval += $interval;
                ?>
                <tr>
                    <td>{{$getData[$i]->type}}</td>
                    <td>{{date_format(date_create($getData[$i]->upload_time), 'd-m-Y H:i:s')}}</td>
                    <td>{{$getData[$i]->operation}}</td>
                    <td>{{$role ? $role-> slug : ''}}</td>
                    <td>
                        <span class="@if($interval <= 5) text-success @else text-danger @endif">
                            @if($interval > 59)
                                {{ intdiv($interval, 60).' hours '. ($interval % 60).' minutes'}}
                            @elseif($interval < 1)
                                < 1 minute
                            @else
                                {{$interval}} minutes
                            @endif
                        </span>
                    </td>
                    <td>
                        <input type="hidden" name="log_ids[]" value="{{$getData[$i]->id}}">
                        <input type="number" class="form-control" name="minutes[]" value="{{$getData[$i]->minutes ? $getData[$i]->minutes : $interval}}">
                    </td>
                </tr>
                @endfor
                <tr>
                    <td colspan="3" align="center">Total : {{$totalInterval}} Minutes</td>
                    <td colspan="3" align="right">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            Save Minutes
                        </button>
                    </td>
                </tr>
                @else
                <tr>
                    <td>No Record Found.</td>
                </tr>
                @endif
            </tbody>
        </table>
        </form>
    </div>
</div>
