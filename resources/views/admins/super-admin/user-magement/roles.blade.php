@extends('layouts.admin')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Permissions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions->map->name as $permission)
                            <span class="badge badge-primary p-2">{{ $permission }}</span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
