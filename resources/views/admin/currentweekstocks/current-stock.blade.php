@extends('admin.layouts.admin-layout')

@section('title', 'Gann Stokes')

@section('content')

    <div class="pagetitle">
        <h1>Gann Stokes</h1>
        <div class="row">
            <div class="col-md_8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Gann Stokes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md_4" style="text-align: right;">
                <a href="{{ route('gannStokes.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md_12">
                <div class="card">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Gann Stokes</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('label.Id') }}</th>
                                                        <th>Stokes</th>
                                                        <th data-angle="45">45 Degree</th>
                                                        <th data-angle="90">90 Degree</th>
                                                        <th data-angle="135">135 Degree</th>
                                                        <th data-angle="180">180 Degree</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $ganstocks->id }}</td>
                                                        <td>{{ $ganstocks->stokes }}</td>
                                                        <td data-angle="45">{{ $ganstocks->d_45 }}</td>
                                                        <td data-angle="90">{{ $ganstocks->d_90 }}</td>
                                                        <td data-angle="135">{{ $ganstocks->d_135 }}</td>
                                                        <td data-angle="180">{{ $ganstocks->d_180 }}</td>
                                                        <td><a href="{{ route('gannStokes.view', ['id' => encrypt($ganstocks->id)]) }}" class="btn btn-sm btn-primary me-1"> <i class="bi bi-eye" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
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
    
    </script>
@endsection
