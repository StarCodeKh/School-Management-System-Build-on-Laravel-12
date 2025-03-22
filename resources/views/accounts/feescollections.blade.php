@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Fees Collections</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Fees Collections</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Fees Collections</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <a href="{{ route('add/fees/collection/page') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Fees Type</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                            <th class="text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($feesInformation as $key => $value)
                                            <tr>
                                                <td>ST-{{ $value->student_id }}</td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a class="avatar avatar-sm me-2">
                                                            <img class="avatar-img rounded-circle"src="{{ URL::to('/images/'. $value->avatar) }}"alt="{{ $value->student_name }}">
                                                        </a>
                                                        <a>{{ $value->student_name }}</a>
                                                    </h2>
                                                </td>
                                                <td>{{ $value->gender }}</td>
                                                <td>{{ $value->fees_type }}</td>
                                                <td>${{ $value->fees_amount }}</td>
                                                <td>{{ $value->paid_date }}</td>
                                                <td class="text-end">
                                                    <span class="badge badge-success">Paid</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
