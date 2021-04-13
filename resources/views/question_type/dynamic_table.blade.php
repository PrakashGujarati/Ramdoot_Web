<div class="card card-preview">
    <div class="card-inner">
        <div class="card-head">
            <h5 class="card-title">Question Type List</h5>
        </div>
        <div class="" style="width: 100%;overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Question Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @if(count($question_type_details) > 0)
                    @foreach($question_type_details as $data)
                    <tr>
                        <td>{{ isset($data->question_type) ? $data->question_type:'' }}</td>
                        <td>
                            @canany(['QuestionType-edit'])
                            <a href="javascript:;" data-hidden-id="{{ $data->id }}" class="edit_question_type"><span class="nk-menu-icon success"><em class="icon ni ni-edit"></em></span></a>
                            @endcanany
                            @canany(['QuestionType-edit'])
                            <a href="javascript:;" data-hidden-id="{{ $data->id }}" data-url="{{ route('question_type.distroy') }}" class="distroy"><span class="nk-menu-icon danger"><em class="icon ni ni-trash"></em></span></a>
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