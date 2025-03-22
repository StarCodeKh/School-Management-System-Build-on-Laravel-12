@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card invoice-info-card">
                        <div class="card-body">
                            <div class="invoice-item invoice-item-one">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="invoice-logo">
                                            <img src="{{ URL::to('assets/img/logo.png') }}" alt="logo">
                                        </div>
                                        <div class="invoice-head">
                                            <h2>Invoice</h2>
                                            <p>Invoice Number : {{ $invoiceView->invoice_id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="invoice-info">
                                            <strong class="customer-text-one">Invoice From</strong>
                                            <h6 class="invoice-name">Company Name</h6>
                                            <p class="invoice-details">
                                                {!! nl2br(($invoiceView->invoice_to)) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-item invoice-item-two">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="invoice-info">
                                            <strong class="customer-text-one">Billed to</strong>
                                            <h6 class="invoice-name"></h6>
                                            <p class="invoice-details invoice-details-two">
                                                {!! nl2br(($invoiceView->invoice_from)) !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="invoice-info invoice-info2">
                                            <strong class="customer-text-one">Payment Details</strong>
                                            <p class="invoice-details">
                                                Debit Card <br>
                                                XXXXXXXXXXXX-{{ $invoiceView->account_number }} <br>
                                                {{  $invoiceView->bank_name }}
                                            </p>
                                            <div class="invoice-item-box">
                                                <p>Recurring : 15 Months</p>
                                                <p class="mb-0">PO Number : {{ $invoiceView->po_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="invoice-issues-box">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="invoice-issues-date">
                                            <p>Issue Date : 27 Jul 2022</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="invoice-issues-date">
                                            <p>Due Date : 27 Aug 2022</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="invoice-issues-date">
                                            <p>Due Amount : ₹ 1,54,22 </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="invoice-item invoice-table-wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="invoice-table table table-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Iteams</th>
                                                        <th>Category</th>
                                                        <th>Rate/Item</th>
                                                        <th>Quantity</th>
                                                        <th>Discount (%)</th>
                                                        <th class="text-end">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($invoiceDetails as $key => $value)
                                                        <tr>
                                                            <td>{{ $value->items }}</td>
                                                            <td>{{ $value->category }}</td>
                                                            <td>${{ $value->amount }}</td>
                                                            <th>{{ $value->quantity }}</th>
                                                            <th>{{ $value->discount }}%</th>
                                                            <td class="text-end">${{ $value->price }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-6 col-md-6">
                                    <div class="invoice-terms">
                                        <h6>Notes:</h6>
                                        <p class="mb-0">Enter customer notes or any other details</p>
                                    </div>
                                    <div class="invoice-terms">
                                        <h6>Terms and Conditions:</h6>
                                        <p class="mb-0">Enter customer notes or any other details</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="invoice-total-card">
                                        <div class="invoice-total-box">
                                            <div class="invoice-total-inner">
                                                <p>Taxable <span>$6,660.00</span></p>
                                                <p>Additional Charges <span>$6,660.00</span></p>
                                                <p>Discount <span>$3,300.00</span></p>
                                                <p class="mb-0">Sub total <span>$3,300.00</span></p>
                                            </div>
                                            <div class="invoice-total-footer">
                                                <h4>Total Amount <span>${{ $invoiceView->total_amount }}</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-sign text-end">
                                <img class="img-fluid d-inline-block" src="{{ Storage::url($invoiceView->upload_sign) }}" alt="sign" style="width: 10%;">
                                <span class="d-block">{{ $invoiceView->name_of_the_signatuaory }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
