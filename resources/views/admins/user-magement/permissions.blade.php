@extends('layouts.admin')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ trimSpecialChars($permission) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
