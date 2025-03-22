@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Invoices</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="invoices.html">Invoice</a></li>
                            <li class="breadcrumb-item active">Invoices Cancelled</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('invoice/cancelled/page') }}" class="invoices-links active">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('invoice/grid/page') }}" class="invoices-links">
                            <i class="fa fa-th" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card report-card">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="app-listing">
                                <li>
                                    <div class="multipleSelection">
                                        <div class="selectBox">
                                            <p class="mb-0"><i class="fas fa-user-plus me-1 select-icon"></i> Select
                                                User</p>
                                            <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                        </div>
                                        <div id="checkBoxes">
                                            <form action="#">
                                                <p class="checkbox-title">Customer Search</p>
                                                <div class="form-custom">
                                                    <input type="text" class="form-control bg-grey"
                                                        placeholder="Enter Customer Name">
                                                </div>
                                                <div class="selectBox-cont">
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Brian Johnson
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Russell Copeland
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Greg Lynch
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> John Blair
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Barbara Moore
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Hendry Evan
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="username">
                                                        <span class="checkmark"></span> Richard Miles
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="multipleSelection">
                                        <div class="selectBox">
                                            <p class="mb-0"><i class="fas fa-calendar me-1 select-icon"></i> Select
                                                Date</p>
                                            <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                        </div>
                                        <div id="checkBoxes">
                                            <form action="#">
                                                <p class="checkbox-title">Date Filter</p>
                                                <div class="selectBox-cont selectBox-cont-one h-auto">
                                                    <div class="date-picker">
                                                        <div class="form-custom cal-icon">
                                                            <input class="form-control datetimepicker" type="text"
                                                                placeholder="Form">
                                                        </div>
                                                    </div>
                                                    <div class="date-picker pe-0">
                                                        <div class="form-custom cal-icon">
                                                            <input class="form-control datetimepicker" type="text"
                                                                placeholder="To">
                                                        </div>
                                                    </div>
                                                    <div class="date-list">
                                                        <ul>
                                                            <li><a href="#" class="btn date-btn">Today</a></li>
                                                            <li><a href="#" class="btn date-btn">Yesterday</a></li>
                                                            <li><a href="#" class="btn date-btn">Last 7 days</a>
                                                            </li>
                                                            <li><a href="#" class="btn date-btn">This month</a></li>
                                                            <li><a href="#" class="btn date-btn">Last month</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="multipleSelection">
                                        <div class="selectBox">
                                            <p class="mb-0"><i class="fas fa-book-open me-1 select-icon"></i> Select
                                                Status</p>
                                            <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                        </div>
                                        <div id="checkBoxes">
                                            <form action="#">
                                                <p class="checkbox-title">By Status</p>
                                                <div class="selectBox-cont">
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name">
                                                        <span class="checkmark"></span> All Invoices
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name">
                                                        <span class="checkmark"></span> Paid
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name">
                                                        <span class="checkmark"></span> Overdue
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name">
                                                        <span class="checkmark"></span> Draft
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name">
                                                        <span class="checkmark"></span> Recurring
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="name" checked>
                                                        <span class="checkmark"></span> Cancelled
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="multipleSelection">
                                        <div class="selectBox">
                                            <p class="mb-0"><i class="fas fa-bookmark me-1 select-icon"></i> By
                                                Category</p>
                                            <span class="down-icon"><i class="fas fa-chevron-down"></i></span>
                                        </div>
                                        <div id="checkBoxes">
                                            <form action="#">
                                                <p class="checkbox-title">Category</p>
                                                <div class="form-custom">
                                                    <input type="text" class="form-control bg-grey"
                                                        placeholder="Enter Category Name">
                                                </div>
                                                <div class="selectBox-cont">
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Advertising
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Food
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Marketing
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Repairs
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Software
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Stationary
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        <input type="checkbox" name="category">
                                                        <span class="checkmark"></span> Travel
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="report-btn">
                                        <a href="#" class="btn">
                                            <img src="assets/img/icons/invoices-icon5.png" alt="" class="me-2">
                                            Generate report
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card invoices-tabs-card border-0">
                <div class="card-body card-body pt-0 pb-0">
                    <div class="invoices-main-tabs">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-8">
                                <div class="invoices-tabs">
                                    <ul>
                                        <li><a href="{{ route('invoice/list/page') }}">All Invoice</a></li>
                                        <li><a href="{{ route('invoice/paid/page') }}">Paid</a></li>
                                        <li><a href="{{ route('invoice/overdue/page') }}">Overdue</a></li>
                                        <li><a href="{{ route('invoice/draft/page') }}">Draft</a></li>
                                        <li><a href="{{ route('invoice/recurring/page') }}">Recurring</a></li>
                                        <li><a class="active" href="{{ route('invoice/cancelled/page') }}">Cancelled</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="invoices-settings-btn">
                                    <a href="invoices-settings.html" class="invoices-settings-icon">
                                        <i class="feather feather-settings"></i>
                                    </a>
                                    <a href="{{ route('invoice/add/page') }}" class="btn">
                                        <i class="feather feather-plus-circle"></i> New Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card inovices-card">
                        <div class="card-body">
                            <div class="inovices-widget-header">
                                <span class="inovices-widget-icon">
                                    <img src="{{ URL::to('assets/img/icons/invoices-icon1.svg') }}" alt="">
                                </span>
                                <div class="inovices-dash-count">
                                    <div class="inovices-amount">$8,78,797</div>
                                </div>
                            </div>
                            <p class="inovices-all">All Invoices <span>50</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card inovices-card">
                        <div class="card-body">
                            <div class="inovices-widget-header">
                                <span class="inovices-widget-icon">
                                    <img src="{{ URL::to('assets/img/icons/invoices-icon2.svg') }}" alt="">
                                </span>
                                <div class="inovices-dash-count">
                                    <div class="inovices-amount">$4,5884</div>
                                </div>
                            </div>
                            <p class="inovices-all">Paid Invoices <span>60</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card inovices-card">
                        <div class="card-body">
                            <div class="inovices-widget-header">
                                <span class="inovices-widget-icon">
                                    <img src="{{ URL::to('assets/img/icons/invoices-icon3.svg') }}" alt="">
                                </span>
                                <div class="inovices-dash-count">
                                    <div class="inovices-amount">$2,05,545</div>
                                </div>
                            </div>
                            <p class="inovices-all">Unpaid Invoices <span>70</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card inovices-card">
                        <div class="card-body">
                            <div class="inovices-widget-header">
                                <span class="inovices-widget-icon">
                                    <img src="{{ URL::to('assets/img/icons/invoices-icon4.svg') }}" alt="">
                                </span>
                                <div class="inovices-dash-count">
                                    <div class="inovices-amount">$8,8,797</div>
                                </div>
                            </div>
                            <p class="inovices-all">Cancelled Invoices <span>80</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Invoice to</th>
                                            <th>Amount</th>
                                            <th>Created on</th>
                                            <th>Cancelled on</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="invoice">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a href="view-invoice.html" class="invoice-link">IN093439#@09</a>
                                            </td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html">
                                                        <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ URL::to('/images/photo_defaults.jpg') }}" alt="User Image"> StarCode Moore
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-primary">$1,54,220</td>
                                            <td>16 Mar 2022</td>
                                            <td>23 Mar 2022</td>
                                            <td class="text-end">
                                                <a href="edit-invoice.html"
                                                    class="btn btn-sm btn-white text-success me-2"><i
                                                        class="far fa-edit me-1"></i> Edit</a>
                                                <a class="btn btn-sm btn-white text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                        class="far fa-trash-alt me-1"></i>Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="invoice">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a href="view-invoice.html" class="invoice-link">IN093439#@10</a>
                                            </td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html">
                                                        <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ URL::to('/images/photo_defaults.jpg') }}" alt="User Image"> StarCode Moore
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-primary">$1,222</td>
                                            <td>14 Mar 2022</td>
                                            <td>18 Mar 2022</td>
                                            <td class="text-end">
                                                <a href="edit-invoice.html"
                                                    class="btn btn-sm btn-white text-success me-2"><i
                                                        class="far fa-edit me-1"></i> Edit</a>
                                                <a class="btn btn-sm btn-white text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                        class="far fa-trash-alt me-1"></i>Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="invoice">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a href="view-invoice.html" class="invoice-link">IN093439#@11</a>
                                            </td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html">
                                                        <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ URL::to('/images/photo_defaults.jpg') }}" alt="User Image"> StarCode Moore
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-primary">$3,470</td>
                                            <td>7 Mar 2022</td>
                                            <td>10 Mar 2022</td>
                                            <td class="text-end">
                                                <a href="edit-invoice.html"
                                                    class="btn btn-sm btn-white text-success me-2"><i
                                                        class="far fa-edit me-1"></i> Edit</a>
                                                <a class="btn btn-sm btn-white text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                        class="far fa-trash-alt me-1"></i>Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="invoice">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a href="view-invoice.html" class="invoice-link">IN093439#@12</a>
                                            </td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html">
                                                        <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ URL::to('/images/photo_defaults.jpg') }}" alt="User Image"> StarCode Moore
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-primary">$8,265</td>
                                            <td>24 Mar 2022</td>
                                            <td>30 Mar 2022</td>
                                            <td class="text-end">
                                                <a href="edit-invoice.html"
                                                    class="btn btn-sm btn-white text-success me-2"><i
                                                        class="far fa-edit me-1"></i> Edit</a>
                                                <a class="btn btn-sm btn-white text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                        class="far fa-trash-alt me-1"></i>Delete</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="invoice">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <a href="view-invoice.html" class="invoice-link">IN093439#@13</a>
                                            </td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html">
                                                        <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="{{ URL::to('/images/photo_defaults.jpg') }}" alt="User Image"> StarCode Moore
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-primary">$5,200</td>
                                            <td>17 Mar 2022</td>
                                            <td>20 Mar 2022</td>
                                            <td class="text-end">
                                                <a href="edit-invoice.html"
                                                    class="btn btn-sm btn-white text-success me-2"><i
                                                        class="far fa-edit me-1"></i> Edit</a>
                                                <a class="btn btn-sm btn-white text-danger" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#delete_paid"><i
                                                        class="far fa-trash-alt me-1"></i>Delete</a>
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

    <div class="modal custom-modal fade" id="delete_paid" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Invoice Cancelled</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary paid-continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-bs-dismiss="modal"
                                    class="btn btn-primary paid-cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
