<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Videos List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="datatable-init table">
            <thead>
                <tr>
                    <th>Board</th>
                    <th>Medium</th>
                    <th>Standard</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Unit</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Thumbnail</th>
                    <th>Duration</th>
                    <th>Label</th>
                    <th>Release Date</th>
                    <th>Action</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>

                @if(count($videos_details) > 0)
                    @foreach($videos_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>
                            @if($data->type == 'File')
                            @if($data->url)
                            <img src="{{ asset('upload/videos/url/'.$data->url) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->url }}
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/videos/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td>{{ $data->duration }}</td>
                        <td>{{ $data->label }}</td>
                        <td>@if($data->release_date) {{ date('d-m-Y',strtotime($data->release_date)) }} @endif</td>
                        <td>
                            <a href="javascript:;" data-id="" class=""><span class="nk-menu-icon info"><em class="icon ni ni-eye"></em></span></a>
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 edit-btn"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            <a href="javascript:;" data-id="{{ $data->id }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>
                        <td>
                            <a href="javascript:;" data-url="" class=""><span class="nk-menu-icon info"><em class="icon ni ni-arrow-up"></em></span></a>
                            <a href="javascript:;" data-url="" class=""><span class="nk-menu-icon info"><em class="icon ni ni-arrow-down"></em></span></a>
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