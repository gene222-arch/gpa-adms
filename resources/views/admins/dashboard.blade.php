@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @role('super-admin')
                        <p>Super Admin</p>
                    @endrole

                    @can('all')
                        <p>Admin can do all</p>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
