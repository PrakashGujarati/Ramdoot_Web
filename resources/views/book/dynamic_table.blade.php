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
                                <td>{{ isset($book_details->first()->board->name) ? $book_details->first()->board->name:'' }}</td>
                                <td>{{ isset($book_details->first()->medium->medium_name) ? $book_details->first()->medium->medium_name:'' }}</td>
                                <td>{{ isset($book_details->first()->standard->standard) ? $book_details->first()->standard->standard:'' }}</td>
                                <td>{{ isset($book_details->first()->subject->subject_name) ? $book_details->first()->subject->subject_name:'' }}</td>
                                <td>{{ isset($book_details->first()->semester->semester) ? $book_details->first()->semester->semester:'' }}</td>
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
                    <td>ON</td>
                    {{--<th>Board</th>
                    <th>Medium</th>
                    <th>Standard</th>
                    <th>Semester</th>
                    <th>Subject</th>--}}
                    <th>Unit</th>
                    <th>Title</th>
                    <th>Sub Title</th>
                    <th>URL</th>
                    <th>Thumbnail</th>
                    <th>Pages</th>
                    <th>Description</th>
                    <th>Label</th>
                    <th>Release Date</th>
                    <th>Action</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>

                @if(count($book_details) > 0)
                    @foreach($book_details as $data)
                    <tr>
                        <td>{{$data->order_no}}</td>
                        {{--<td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ isset($data->medium->medium_name) ? $data->medium->medium_name:'' }}</td>
                        <td>{{ isset($data->standard->standard) ? $data->standard->standard:'' }}</td>
                        <td>{{ isset($data->semester->semester) ? $data->semester->semester:'' }}</td>
                        <td>{{ isset($data->subject->subject_name) ? $data->subject->subject_name:'' }}</td>--}}
                        <td>{{ isset($data->unit->title) ? $data->unit->title:'' }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->sub_title }}</td>
                        <td>
                            @if($data->url_type == 'Server')
                            @if($data->url)
                            @php
                                $board_sub_title = App\Models\board::where(['id' => $data->board_id])->first();
                                $medium_sub_title = App\Models\Medium::where(['id' => $data->medium_id])->first();
                                $standard_sub_title = App\Models\Standard::where(['id' => $data->standard_id])->first();
                                $semester_sub_title = App\Models\Semester::where(['id' => $data->semester_id])->first();
                                $subject_sub_title = App\Models\Subject::where(['id' => $data->subject_id])->first();
                                $unit_sub_title = App\Models\Unit::where(['id' => $data->unit_id])->first();
                            @endphp
                            <a href="{{ asset('data/'.$data->board_id.'_'.$board_sub_title->sub_title.'/'.$data->medium_id.'_'.$medium_sub_title->sub_title.'/'.$data->standard_id.'_'.
                                $standard_sub_title->sub_title.'/'.$data->subject_id.'_'.$subject_sub_title->sub_title.'/'.$data->semester_id.'_'.$semester_sub_title->sub_title.'/'.$data->unit_id.'_'.
                                $unit_sub_title->sub_title.'/book/url/'.$data->url) }}">{{$data->unit->title}}</a>
                            @endif
                            @else
                            {{ $data->url }}
                            @endif
                        </td>
                        <td>
                            @if($data->thumbnail_file_type == 'Server')
                            @if($data->thumbnail)
                            <img src="{{ asset('data/'.$data->board_id.'_'.$board_sub_title->sub_title.'/'.
                                $data->medium_id.'_'.$medium_sub_title->sub_title.'/'.$data->standard_id.'_'.
                                $standard_sub_title->sub_title.'/'.$data->subject_id.'_'.$subject_sub_title->sub_title.'/'.$data->semester_id.'_'.$semester_sub_title->sub_title.'/'.$data->unit_id.'_'.
                                $unit_sub_title->sub_title.'/book/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                            @else
                            {{ $data->thumbnail }}
                            @endif
                        </td>
                        <td>{{ $data->pages }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->label }}</td>
                        <td>@if($data->release_date) {{ date('d-m-Y',strtotime($data->release_date)) }} @endif</td>
                        <td>
                            @if($data->status == "Active")
                            <a href="javascript:;" data-id="{{ $data->id }}" class="status_change" data-status='Active'><span class="nk-menu-icon info"><em class="icon ni ni-eye-fill"></em></span></a>
                            @else
                            <a href="javascript:;" data-id="{{ $data->id }}" class="status_change" data-status='Inactive'><span class="nk-menu-icon info"><em class="icon ni ni-eye-off-fill"></em></span></a>
                            @endif

                            @canany(['Book-edit'])
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 edit-btn"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            @endcanany
                            @canany(['Book-delete'])
                            <a href="javascript:;" data-id="{{ $data->id }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                            @endcanany
                        </td>
                        <td>
                            @canany(['Book-edit'])
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