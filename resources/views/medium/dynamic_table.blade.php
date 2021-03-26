<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Medium List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="datatable-init table">
            <thead>
                <tr>
                    <th>Board</th>
                    <th>Medium</th>
                    <th>Action</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>

                @if(count($mediums_details) > 0)
                    @foreach($mediums_details as $data)
                    <tr>
                        <td>{{ isset($data->board->name) ? $data->board->name:'' }}</td>
                        <td>{{ $data->medium_name }}</td>
                        <td>
                            <a href="javascript:;" data-url="" class=""><span class="nk-menu-icon info"><em class="icon ni ni-eye"></em></span></a>
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