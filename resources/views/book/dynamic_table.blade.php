<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Book List</h5>
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
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>URL</th>
                    <th>Thumbnail</th>
                    <th>Pages</th>
                    <th>Description</th>
                    <th>Label</th>
                    <th>Release Date</th>
                </tr>
            </thead>
            <tbody>

                @if(count($book_details) > 0)
                    @foreach($book_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->sub_title }}</td>
                        <td>
                            @if($data->url_type == 'file')
                            @if($data->url)
                            <img src="{{ asset('upload/book/url/'.$data->url) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->url }}
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/book/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td>{{ $data->pages }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->label }}</td>
                        <td>@if($data->release_date) {{ date('d-m-Y',strtotime($data->release_date)) }} @endif</td>
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