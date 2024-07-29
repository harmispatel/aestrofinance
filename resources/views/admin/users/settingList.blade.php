@extends('admin.layouts.admin-layout')

@section('title', 'Users')

@section('content')

    <div class="pagetitle">
        <h1>Users</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Category Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"> 
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{ trans('label.IntraDay') }}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100" id="UsersSettingTable">
                                                <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>ApiKey</th>
                                                        <th>Password</th>
                                                        <th>t otp</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


@endsection


{{-- Custom Script --}}
@section('page-js')


    <script type="text/javascript">
        $(function() {

            var table = $('#UsersSettingTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('settingDetail') }}",
                columns: [{
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'api_key',
                        name: 'api_key'
                    },
                    {
                        data: 't_otp',
                        name: 't_otp',

                    },
                    {
                        data: 'setting_password',
                        name: 'setting_password'

                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>

@endsection
