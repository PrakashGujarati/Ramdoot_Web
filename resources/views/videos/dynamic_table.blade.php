<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>Board</th>
                                <th>Medium</th>
                                <th>Standard</th>
                                <th>Subject</th>
                                <th>Semester</th>
                            </tr>
                            <tr>
                                <td>{{ isset($videos_details->first()->board->name) ? $videos_details->first()->board->name:'' }}</td>
                                <td>{{ isset($videos_details->first()->medium->medium_name) ? $videos_details->first()->medium->medium_name:'' }}</td>
                                <td>{{ isset($videos_details->first()->standard->standard) ? $videos_details->first()->standard->standard:'' }}</td>
                                <td>{{ isset($videos_details->first()->subject->subject_name) ? $videos_details->first()->subject->subject_name:'' }}</td>
                                <td>{{ isset($videos_details->first()->semester->semester) ? $videos_details->first()->semester->semester:'' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="datatable-init table">
            <thead>
                <tr>
                    <th>Order No</th>
                    {{--<th>Board</th>
                    <th>Medium</th>
                    <th>Standard</th>
                    <th>Semester</th>
                    <th>Subject</th>--}}
                    <th>Unit</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Thumbnail</th>
                    <th>Duration</th>
                    <th>Label</th>
                    <th>Release Date</th>
                    <th>Start Time</th>
                    <th>Action</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>

                @if(count($videos_details) > 0)
                    @foreach($videos_details as $data)
                    <tr>
                        <td>{{$data->order_no}}</td>
                        {{--<td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>--}}
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>
                            @php $path = get_subtitle($data->unit_id);  @endphp
                            @if($data->url_type == 'file')
                            @if($data->url_type)
                            <img src="{{ asset($path.'/videos/url/'.$data->url) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->url_type }}
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail_file_type == 'Server')
                            @if($data->thumbnail)
                            <img src="{{ asset($path.'/videos/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->thumbnail }}
                            @endif
                        </td>
                        <td>{{ $data->duration }}</td>
                        <td>{{ $data->label }}</td>
                        <td>@if($data->release_date) {{ date('d-m-Y',strtotime($data->release_date)) }} @endif</td>
                        <td>{{ $data->start_time ?? '' }}</td>
                        <td>
                            @if($data->status == "Active")
                            <a href="javascript:;" data-id="{{ $data->id }}" class="status_change" data-status='Active'><span class="nk-menu-icon info"><em class="icon ni ni-eye-fill"></em></span></a>
                            @else
                            <a href="javascript:;" data-id="{{ $data->id }}" class="status_change" data-status='Inactive'><span class="nk-menu-icon info"><em class="icon ni ni-eye-off-fill"></em></span></a>
                            @endif
                            @canany(['Video-edit'])
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 edit-btn"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            @endcanany
                            @canany(['Video-delete'])
                            <a href="javascript:;" data-id="{{ $data->id }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                            @endcanany
                        </td>
                        <td>
                            @canany(['Video-edit'])
                            <a href="javascript:;" data-url="" class="above_order" data-order_no="{{$data->order_no}}"><span class="nk-menu-icon info"><em class="icon ni ni-arrow-up"></em></span></a>
                            <a href="javascript:;" data-url="" class="below_order" data-order_no="{{$data->order_no}}"><span class="nk-menu-icon info"><em class="icon ni ni-arrow-down"></em></span></a>
                            @endcanany
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