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
                  <th width="12%"><a href="javascript:;" class="btn btn-primary btn-sm checkall">Check All</a></th>
                  <th>Module Name</th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData" id="view_col" name="permissions"><label for="view_col" class="mb-0 pl-1">View</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData" id="add_col" name="permissions"><label for="add_col" class="mb-0 pl-1">Add</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData" id="edit_col" name="permissions"><label for="edit_col" class="mb-0 pl-1">Edit</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData" id="delete_col" name="permissions"><label for="delete_col" class="mb-0 pl-1">Delete</label></th>
                  <th><input type="checkbox" class="chk-col-blue checkboxData" id="delete_col" name="permissions"><label for="delete_col" class="mb-0 pl-1">Note</label></th>
                </tr>
            </thead>
            <tbody>
            @if(request('role_id') && $selected_role )  
              <form action="{{ route('role.assign_permission', [ 'role_id' => request('role_id') ]) }}" method="post" id="assign_permission_form">
              @csrf

                @forelse ($permissions as $key =>  $permission)
                @php $get_details = App\Models\Permission::where(['module_name' => $permission->module_name])->get(); @endphp

                <tr>
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox" name="permissions1"><label for="permission_checkbox"></label>
                  </td>
                  <td>{{ $permission->module_name }}</td>

                  @foreach($get_details as $get_detail)
                  @if($get_detail->name == "view")
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox_{{ $get_detail->id }}" name="permissions[]" value="{{ $get_detail->id }}"><label for="permission_checkbox_{{ $get_detail->id }}"></label>
                  </td>
                  @endif
                  @if($get_detail->name == "add")
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox_{{ $get_detail->id }}" name="permissions[]" value="{{ $get_detail->id }}"><label for="permission_checkbox"></label>
                  </td>
                  @endif
                  @if($get_detail->name == "edit")
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox_{{ $get_detail->id }}" name="permissions[]" value="{{ $get_detail->id }}"><label for="permission_checkbox"></label>
                  </td>
                  @endif
                  @if($get_detail->name == "delete")
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox_{{ $get_detail->id }}" name="permissions[]" value="{{ $get_detail->id }}"><label for="permission_checkbox_{{ $get_detail->id }}"></label>
                  </td>
                  @endif
                  @if($get_detail->name == "note")
                  <td>
                    <input type="checkbox" class="chk-col-blue checkboxData" id="permission_checkbox_{{ $get_detail->id }}" name="permissions[]" value="{{ $get_detail->id }}"><label for="permission_checkbox_{{ $get_detail->id }}"></label>
                  </td>
                  @endif
                  @endforeach
                </tr>
                @empty
                <p> Role does not have any permissions yet </p>
                @endforelse
                </form>
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
    $('.checkboxData').prop('checked',true);
  });
</script>
@endsection

