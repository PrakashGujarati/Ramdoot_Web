@extends('layouts.app')
@section('title','Permissions')
@section('css')
@endsection

@section('content')
<div class="row">
    {{--  Roles Table--}}
    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h3>Roles</h3></div>
        <div class="ribbon-content">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>Sr</th>
                <th>Name</th>
                {{-- <th>DiplayName</th> --}}
              </tr>
              </thead>
              <tbody>
              @isset($roles)
                @forelse ($roles as $role)
                  <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td>
                        <span style="cursor: pointer">
                            <a href="{{ route('role.get', ['role_id' => $role->id ]) }}">
                                {{ $role->slug ?? $role->name }}
                            </a>
                        </span>
                    </td>
                    {{-- <td>{{ $role->slug }}</td> --}}
                  </tr>
                @empty
                  <tr>
                    <td align="center" colspan="2"><p>No Roles</p></td>
                  </tr>
                  
                @endforelse
              @endisset

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{--  Permissions Table--}}
    <div class="col-md-8">
      <div class="card">
        @if(request('role_id') && $selected_role )
          <div class="row"><div class="col-md-8"> </div></div>
          <div class="row"
               style="cursor:pointer;margin: 10px;" >
               <div class="col-md-10">
                <h4>{{ $selected_role->slug ?? $selected_role->name }} has Permissions</h4>
               </div>
               <div class="col-md-2">
                  <a href="javascript:;" class="btn btn-info" onclick="event.preventDefault(); document.getElementById('assign_permission_form').submit();">Save</a>
               </div>
          </div>
          <hr>
          <div class="card-body">
            <form action="{{ route('role.assign_permission', [ 'role_id' => request('role_id') ]) }}" method="post" id="assign_permission_form">
              @csrf
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    {{-- <th>Permission</th> --}}
                    
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4"><a href="javascript:;" class="btn btn-primary btn-sm checkall">Check All</a></td>
                    </tr>
                  @forelse ($permissions as $permission)
                    <td>
                      <input type="checkbox" class="chk-col-blue checkboxData"
                             id="permission_checkbox_{{$permission->id}}"
                             name="permissions[{{$permission->name}}]"
                          {{ in_array($permission->name , $selected_role->getAllPermissions()->pluck('name')->toArray()) ? "checked":"" }}
                      >
                      <label for="permission_checkbox_{{$permission->id}}">
                        @if($permission->slug)
                          {{$permission->slug}}
                        @else
                          {{$permission->name}}
                        @endif
                      </label>
                    </td>
                    @if ( $loop->iteration % 4 == 0 )
                      <tr> @endif
                        @empty
                          <p> Role does not have any permissions yet </p>
                      @endforelse
                  </tbody>
                </table>
              </div>

              {{-- <button type="submit" class="btn btn-info waves-effect waves-light m-t-10"> Save</button> --}}
            </form>
          </div>
        @else
          <div class="card->header"><h3> Permissions</h3></div>
          <hr>
          <p>Please select any appropriate Role</p>
        @endif
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

