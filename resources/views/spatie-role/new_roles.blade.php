@extends('layouts.app')
@section('title','Permissions')
@section('css')
<style type="text/css">
  .permissions_table tr th{
    font-size: 18px;
    text-align: center;
  }
  .permissions_table tr td{
    text-align: center;
  }
  .role_menu{
    color: #6e82a5;
    background-color: transparent;
    cursor: pointer;
    font-size: 16px;
  }
  .role_menu:hover{
    color:#9769ff;
    background-color: #ebeef2;
    font-weight: 500;
    font-size: 16px;
  }
  .role_menu_active{
    color:#9769ff;
    background-color: #ebeef2;
    font-weight: 500;
    font-size: 16px;
  }
  .rmenu:first-child{
    padding-left: 0px;
  } 
</style>
@endsection

@section('content')
<!-- <div class="row mt-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header"><h4>Roles</h4></div>
    </div>
  </div>
</div>
<hr/> -->
<div class="row">
    {{--  Roles Table--}}
    <div class="col-md-12">
      <div class="card">
          <div class="card-header" style="padding: 0px!important;background-color: #fff;">
          <div class="row">
            
              @isset($roles)
                @forelse ($roles as $role)

                    <div class="col-md-2 text-center @if(Request::get('role_id')) @if(Request::get('role_id') == $role->id) role_menu_active @else role_menu @endif @else role_menu @endif p-3 rmenu"><a href="{{ route('role.get', ['role_id' => $role->id ]) }}">{{ $role->slug ?? $role->name }}</a>
                  </div>
                @empty
                  <div class="col-md-12">
                    <div align="center" colspan="2"><p>No Roles</p></div>
                  </div>
                @endforelse
              @endisset
              
          </div>
        </div>
      </div>
    </div>
</div>
<hr/>


    {{--  Permissions Table--}}

    
<div class="row mt-1">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="background-color: #364a63;">
          <div class="row">
            <div class="col-md-10 pt-1">     
              @if(request('role_id') && $selected_role )
                <h4 style="color: #ebeef2;">{{ $selected_role->slug ?? $selected_role->name }} has Permissions</h4>
              @else
              <div class=""><h3> Permissions</h3></div>
              <p>Please select any appropriate Role</p>
              @endif
            </div>
            <div class="col-md-2 text-right">
             @if(request('role_id') && $selected_role )
              <a href="javascript:;" class="btn btn-info" onclick="event.preventDefault(); document.getElementById('assign_permission_form').submit();">Save</a>
              @endif
           </div>
          </div>
      </div>
  </div>
  </div>
  
</div>

<hr/>
<div class="row">
    <div class="col-md-12">
      <div class="card">
          <table class="table table-striped permissions_table">
            <thead>
                <tr>
                  <th width="14%"><a href="javascript:;" class="btn btn-primary btn-sm checkall" data-id="uncheck">Check All</a></th>
                  <th>Module Name</th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData view_chk" data-id="uncheck" id="view_col" name="permissions"><label for="view_col" class="mb-0 pl-1">View</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData add_chk" data-id="uncheck" id="add_col" name="permissions"><label for="add_col" class="mb-0 pl-1">Add</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData edit_chk" data-id="uncheck" id="edit_col" name="permissions"><label for="edit_col" class="mb-0 pl-1">Edit</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData delete_chk" data-id="uncheck" id="delete_col" name="permissions"><label for="delete_col" class="mb-0 pl-1">Delete</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData note_chk" data-id="uncheck" id="note_col" name="permissions"><label for="note_col" class="mb-0 pl-1">Note</label></th>
                </tr>
            </thead>
            <tbody>
            @if(request('role_id') && $selected_role )  
              <form action="{{ route('role.assign_permission', [ 'role_id' => request('role_id') ]) }}" method="post" id="assign_permission_form">
              @csrf


                @php $get_details = [];
                  $row = 0;
                 @endphp   
                  @for($i=87;$i < 116;$i+=5)
                  <tr>
                  <td style="text-align: -webkit-center;">
                    <input type="checkbox" class="chk-col-blue checkboxData row main_row_{{ $row }}" data-row-id="{{ $row }}" data-id="uncheck_{{ $row }}" 
                    id="permission_checkbox" name="permissions1"><label for="permission_checkbox"></label>
                  </td>
                  <td><p>{{ str_replace("-add","",$permissions[$i]['name']) }}</p></td>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData view_check row_{{ $row }}" id="permission_checkbox" name="permissions[]" value="{{ $i }}" data-pid="{{$i}}" {{ in_array($i, $selected_role->getAllPermissions()->pluck('id')->toArray()) ? "checked":"" }}><label for="permission_checkbox" 
                    ></label>
                  </td>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData add_check row_{{ $row }}" id="permission_checkbox" name="permissions[]" value="{{ $i+1 }}" data-pid="{{$i+1}}"  {{ in_array($i+1, $selected_role->getAllPermissions()->pluck('id')->toArray()) ? "checked":"" }}><label for="permission_checkbox"></label>
                  </td>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData edit_check row_{{ $row }}" id="permission_checkbox" name="permissions[]" value="{{ $i+2 }}" data-pid="{{$i+2}}"  {{ in_array($i+2, $selected_role->getAllPermissions()->pluck('id')->toArray()) ? "checked":"" }}><label for="permission_checkbox"></label>
                  </td>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData delete_check row_{{ $row }}" id="permission_checkbox" name="permissions[]" value="{{ $i+3 }}" data-pid="{{$i+3}}"  {{ in_array($i+3, $selected_role->getAllPermissions()->pluck('id')->toArray()) ? "checked":"" }}><label for="permission_checkbox"></label>
                  </td>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData note_check row_{{ $row }}" id="permission_checkbox" name="permissions[]" value="{{ $i+4 }}" data-pid="{{$i+4}}"  {{ in_array($i+4, $selected_role->getAllPermissions()->pluck('id')->toArray()) ? "checked":"" }}><label for="permission_checkbox"></label>
                  </td>
                  </tr>
                  @php $row = $row + 1; @endphp
                  @endfor
                
             @endif   
            </tbody>
          </table>

      </div>
  </div>
</div>




@endsection

@section('scripts')
<script type="text/javascript">
  $('.checkall').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.checkall').attr('data-id','check');
      $('.checkall').text('Uncheck All');
      $('.checkboxData').prop('checked',true);
    }else{
      $('.checkall').attr('data-id','uncheck');
      $('.checkall').text('Check All');
      $('.checkboxData').prop('checked',false);
    }
  });

  $('.view_chk').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.view_chk').attr('data-id','check');
      $('.view_check').prop('checked',true);
    }else{
      $('.view_chk').attr('data-id','uncheck');
      $('.view_check').prop('checked',false);
    }
  });

  $('.add_chk').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.add_chk').attr('data-id','check');
      $('.add_check').prop('checked',true);
    }else{
      $('.add_chk').attr('data-id','uncheck');
      $('.add_check').prop('checked',false);
    }
  });

  $('.edit_chk').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.edit_chk').attr('data-id','check');
      $('.edit_check').prop('checked',true);
    }else{
      $('.edit_chk').attr('data-id','uncheck');
      $('.edit_check').prop('checked',false);
    }
  });

  $('.delete_chk').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.delete_chk').attr('data-id','check');
      $('.delete_check').prop('checked',true);
    }else{
      $('.delete_chk').attr('data-id','uncheck');
      $('.delete_check').prop('checked',false);
    }
  });

  $('.note_chk').click(function(){
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck"){
      $('.note_chk').attr('data-id','check');
      $('.note_check').prop('checked',true);
    }else{
      $('.note_chk').attr('data-id','uncheck');
      $('.note_check').prop('checked',false);
    }
  });

  $('.row').click(function(){
    var get_row = $(this).attr('data-row-id');
    var get_attr = $(this).attr('data-id');
    if(get_attr == "uncheck_"+get_row){
      $('.main_row_'+get_row).attr('data-id','check_'+get_row);
      $('.row_'+get_row).prop('checked',true);
    }else{
      $('.main_row_'+get_row).attr('data-id','uncheck_'+get_row);
      $('.row_'+get_row).prop('checked',false);
    }
  });
    

  
</script>
@endsection

