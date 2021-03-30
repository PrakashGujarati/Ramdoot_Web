<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Board List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table datatable-init">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Abbreviation</th>
                    <th style="width:100px;">Thumbnail</th>
                    <th style="width:130px;">Action</th>
                    <th style="width:120px;">Position</th>
                </tr>
            </thead>
            <tbody>

                @if(count($boards_details) > 0)
                    @foreach($boards_details as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->abbreviation }}</td>
                        <td style="width:100px;">
                            @if($data->thumbnail)
                            <img src="{{ asset('upload/board/thumbnail/'.$data->thumbnail) }}" class="thumbnail" height="50" width="50">
                            @endif
                        </td>
                        <td style="width:130px;">
                            @if($data->status == "Active")
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 status_change" data-status='Active'><span class="nk-menu-icon info"><em class="icon ni ni-eye-fill"></em></span></a>
                            @else
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 status_change" data-status='Inactive'><span class="nk-menu-icon info"><em class="icon ni ni-eye-off-fill"></em></span></a>
                            @endif
                            <a href="javascript:;" data-id="{{ $data->id }}" class="mr-1 edit-btn"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            <a href="javascript:;" data-id="{{ $data->id }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
                        </td>
                        <td style="width:120px;">
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