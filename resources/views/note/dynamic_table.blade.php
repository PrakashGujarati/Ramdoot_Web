<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Note List</h5>
        </div>
        <table class="table" style="width: 100%;overflow-x: auto;">
            <thead>
                <tr>
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

                @if(count($note_details) > 0)
                    @foreach($note_details as $data)
                    <tr>
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->sub_title }}</td>
                        <td>
                            @if($data->url_type == 'file')
                            @if($data->url)
                            <img src="{{ asset('upload/note/url/'.$data->url) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->url }}
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/note/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td>{{ $data->pages }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->label }}</td>
                        <td>@if($data->release_date) {{ date('d-m-Y',strtotime($data->release_date)) }} @endif</td>
                        {{--<td>
                            <a href="{{ route('note.edit',$data->id) }}"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            <a href="javascript:;" data-url="{{ route('note.distroy',$data->id) }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>--}}
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
</div><!-- .card-preview -->