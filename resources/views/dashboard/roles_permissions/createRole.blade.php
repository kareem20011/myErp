@extends('layouts.admin')
@section('title')
Create Role
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create Role</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <div class="card card-primary m-3">
    <!-- form start -->
    <form action="{{ route('roles.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ old('name') }}">
        </div>
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <!-- Select All Permissions -->
        <div class="form-group">
          <label>
            <input type="checkbox" id="select-all"> Select All Permissions
          </label>
        </div>

        <table class="table table-hover">
          <tbody>
            @if(count($permissions) > 0)
            @foreach ($permissions as $group => $groupPermissions)
            <tr>
              <th>
                <!-- Select All for Group -->
                <label>
                  <input type="checkbox" class="select-group" data-group="{{ $group }}">{{ ucfirst($group) }}
                </label>
              </th>
              <!-- Loop through actions (view, create, update, delete) -->
              @foreach (['view', 'create', 'update', 'delete'] as $action)
              <td>
                @php
                $permissionId = $groupPermissions->firstWhere('name', $action)->id ?? null;
                $hasPermission = has_permission($action, $group);
                $isCreatedByUser = $permissionId
                  ? auth()->user()->id === $groupPermissions->firstWhere('id', $permissionId)->created_by
                  : false;
                $isChecked = isset($role) && $role->permissions->contains('id', $permissionId);
                @endphp

                @if($permissionId)
                <input type="checkbox"
                  name="permissions[]"
                  id="permissions.{{$group}}.{{$action}}"
                  value="{{ $permissionId }}"
                  class="permission-checkbox"
                  data-group="{{ $group }}"
                  {{ $isChecked ? 'checked' : '' }}
                  {{ !$hasPermission && !$isCreatedByUser ? 'disabled' : '' }}>
                @else
                <input type="checkbox"
                  name="permissions[]"
                  id="permissions.{{$group}}.{{$action}}"
                  value=""
                  class="permission-checkbox"
                  data-group="{{ $group }}"
                  disabled>
                @endif
                <label for="permissions.{{$group}}.{{$action}}">{{ $action }}</label>
              </td>
              @endforeach
            </tr>
            @endforeach
            @error('permissions')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            @else
            <tr>
              <h3 class="alert alert-warning">No permission found! Create permissions first!</h3>
            </tr>
            @endif
          </tbody>
        </table>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
document.addEventListener("DOMContentLoaded", function () {
  const selectAll = document.getElementById("select-all");
  const groupCheckboxes = document.querySelectorAll(".select-group");
  const permissionCheckboxes = document.querySelectorAll(".permission-checkbox");

  // Select All Permissions
  selectAll.addEventListener("change", function () {
    const isChecked = this.checked;
    groupCheckboxes.forEach(cb => cb.checked = isChecked);
    permissionCheckboxes.forEach(cb => cb.checked = isChecked);
  });

  // Select Group Permissions
  groupCheckboxes.forEach(groupCheckbox => {
    groupCheckbox.addEventListener("change", function () {
      const group = this.dataset.group;
      const groupPermissions = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
      groupPermissions.forEach(cb => cb.checked = this.checked);
      checkGlobalSelect();
    });
  });

  // Individual Permission Checkbox
  permissionCheckboxes.forEach(permissionCheckbox => {
    permissionCheckbox.addEventListener("change", function () {
      const group = this.dataset.group;
      const groupCheckbox = document.querySelector(`.select-group[data-group="${group}"]`);
      const groupPermissions = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
      const allChecked = Array.from(groupPermissions).every(cb => cb.checked);
      groupCheckbox.checked = allChecked;
      checkGlobalSelect();
    });
  });

  // Check Global Select-All Status
  function checkGlobalSelect() {
    const allGroupsChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
    const allPermissionsChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
    selectAll.checked = allGroupsChecked && allPermissionsChecked;
  }
});
</script>

@endsection
