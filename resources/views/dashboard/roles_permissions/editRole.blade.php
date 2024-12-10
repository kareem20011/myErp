@extends('layouts.admin')
@section('title')
Edit role | {{ $row->name }}
@endsection
@section('admin.content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card card-primary m-3">
        <form action="{{ route('roles.update', $row->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ $row->name }}">
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="select-all">
                    <label class="form-check-label" for="select-all">Select All</label>
                </div>

                <table class="table table-hover">
                    <tbody>
                        @foreach ($permissions as $group => $groupPermissions)
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input select-group" id="group-{{ $group }}" data-group="{{ $group }}">
                                    <label class="form-check-label" for="group-{{ $group }}">{{ $group }}</label>
                                </div>
                            </th>
                            @foreach (['view', 'create', 'update', 'delete'] as $action)
                            <td>
                                @php
                                $permissionId = $groupPermissions->firstWhere('name', $action)->id ?? null;
                                $hasPermission = has_permission($action, $group);
                                $isCreatedByUser = $permissionId
                                    ? auth()->user()->id === $groupPermissions->firstWhere('id', $permissionId)->created_by
                                    : false;
                                @endphp

                                @if($permissionId)
                                <input type="checkbox"
                                    name="permissions[]"
                                    id="permissions.{{$group}}.{{$action}}"
                                    value="{{ $permissionId }}"
                                    class="form-check-input permission-checkbox group-{{ $group }}"
                                    {{ $row->permissions->contains('id', $permissionId) ? 'checked' : '' }}
                                    {{ !$hasPermission && !$isCreatedByUser ? 'disabled' : '' }}>
                                @else
                                <input type="checkbox"
                                    name="permissions[]"
                                    id="permissions.{{$group}}.{{$action}}"
                                    value=""
                                    class="form-check-input permission-checkbox group-{{ $group }}"
                                    disabled>
                                @endif
                                <label for="permissions.{{$group}}.{{$action}}">{{ $action }}</label>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('select-all').addEventListener('change', function() {
    const checked = this.checked;
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = checked;
    });
    document.querySelectorAll('.select-group').forEach(groupCheckbox => {
        groupCheckbox.checked = checked;
    });
});

document.querySelectorAll('.select-group').forEach(groupCheckbox => {
    groupCheckbox.addEventListener('change', function() {
        const group = this.getAttribute('data-group');
        const checked = this.checked;
        document.querySelectorAll(`.group-${group}`).forEach(checkbox => {
            checkbox.checked = checked;
        });
    });
});
</script>
@endsection
