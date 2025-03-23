@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header invoices-page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <ul class="breadcrumb invoices-breadcrumb">
                            <li class="breadcrumb-item invoices-breadcrumb-item">
                                <a href="{{ route('invoice/list/page') }}">
                                    <i class="fe fe-chevron-left"></i> Back to Invoice List
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <div class="invoices-create-btn">
                            <a class="invoices-preview-link" href="#" data-bs-toggle="modal" data-bs-target="#invoices_preview"><i class="fe fe-eye"></i> Preview</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices_details" class="btn delete-invoice-btn">Delete Invoice</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#save_invocies_details" class="btn save-invoice-btn">Save Draft</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card invoices-add-card">
                        <div class="card-body">
                            <form action="{{ route('invoice/update/save') }}" class="invoices-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $invoiceView->invoice_id }}">
                                <div class="invoices-main-form">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <select class="select select2s-hidden-accessible @error('full_name') is-invalid @enderror" style="width: 100%;" tabindex="-1" aria-hidden="true" id="customer_name" name="customer_name">
                                                    <option>{{ $invoiceView->customer_name }}</option>
                                                    @foreach($users as $key => $names)
                                                        <option value="{{ $names->name }}"data-teacher_id={{ $names->user_id }} {{ old('full_name') == $names->name ? "selected" :""}}>{{ $names->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Po Number</label>
                                                <input class="form-control" type="text" id="po_number" name="po_number" value="{{ $invoiceView->po_number }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-5 col-md-6 col-sm-12 col-12">
                                            <h4 class="invoice-details-title">Invoice details</h4>
                                            <div class="invoice-details-box">
                                                <div class="invoice-inner-head">
                                                    <span>Invoice No. <a>{{ $invoiceView->invoice_id }}</a></span>
                                                </div>
                                                <div class="invoice-inner-footer">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="invoice-inner-date">
                                                                <span>
                                                                    Date <input class="form-control datetimepicker" type="text" name="date" value="{{ date('d-m-Y') }}">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="invoice-inner-date invoice-inner-datepic">
                                                                <span>
                                                                    Due Date <input class="form-control datetimepicker" type="text" name="due_date" value="{{ $invoiceView->due_date }}">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-12 col-sm-12 col-12">
                                            <div class="inovices-month-info">
                                                <div class="form-group mb-0">
                                                    <label class="custom_check w-100">
                                                        @if(!empty($invoiceView->enable_tax))
                                                            <input type="checkbox" checked id="enableTax" name="enable_tax" value="Enable tax">
                                                        @else
                                                            <input type="checkbox" id="enableTax" name="enable_tax" value="Enable tax">
                                                        @endif
                                                        <span class="checkmark"></span> Enable tax
                                                    </label>
                                                    <label class="custom_check w-100">
                                                        @if(!empty($invoiceView->recurring_incoice))
                                                        <input type="checkbox" checked id="chkYes" name="recurring_incoice" value="Recurring Invoice">
                                                        @else
                                                        <input type="checkbox" id="chkYes" name="recurring_incoice" value="Recurring Invoice">
                                                        @endif
                                                        <span class="checkmark"></span> Recurring Invoice
                                                    </label>
                                                </div>
                                                @if(!empty($invoiceView->recurring_incoice))
                                                <div id="show">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select class="select" id="by_month" name="by_month">
                                                                    <option selected>{{ $invoiceView->by_month }}</option>
                                                                    <option value="March">March</option>
                                                                    <option value="April">April</option>
                                                                    <option value="May">May</option>
                                                                    <option value="June">June</option>
                                                                    <option value="July">July</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="month" value="{{ $invoiceView->month }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="invoice-item">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="invoice-info">
                                                <strong class="customer-text">Invoice From</strong>
                                                <textarea rows="1.5" class="form-control" name="invoice_from">{{ $invoiceView->invoice_from }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6">
                                            <div class="invoice-info">
                                                <strong class="customer-text">Invoice To</strong>
                                                <textarea rows="1.5" class="form-control" name="invoice_to">{{ $invoiceView->invoice_to }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice-add-table">
                                    <h4>Item Details</h4>
                                    <div class="table-responsive">
                                        <table class="table table-center add-table-items" id="invoice-add-table">
                                            <thead>
                                                <tr>
                                                    <th>Items</th>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Amount</th>
                                                    <th>Discount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoiceDetails as $key => $value)
                                                    <tr class="add-row">
                                                        <td hidden><input type="text" class="form-control" name="id[]" value="{{ $value->id }}"></td>
                                                        <td><input type="text" class="form-control" name="items[]" value="{{ $value->items }}"></td>
                                                        <td><input type="text" class="form-control" name="category[]" value="{{ $value->category }}"></td>
                                                        <td><input type="text" class="form-control" name="quantity[]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ $value->quantity }}"></td>
                                                        <td><input type="text" class="form-control price" name="price[]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ $value->price }}"></td>
                                                        <td><input type="text" class="form-control amount" name="amount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ $value->amount }}" ></td>
                                                        <td><input type="text" class="form-control discount" name="discount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ $value->discount }}"></td>
                                                        <td class="add-remove text-end">
                                                            @if ($key < 1 )
                                                                <a class="add-btn me-2"><i class="fas fa-plus-circle"></i></a>
                                                            @else 
                                                                <a class="remove-btn"><i class="fe fe-trash-2"></i></a>
                                                            @endif
                                                            <a class="copy-btn me-2"><i class="fe fe-copy"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 col-md-6">
                                        @if(empty($invoiceView->account_holder_name))
                                            <div class="invoice-fields">
                                                <h4 class="field-title">More Fields</h4>
                                                <div id="btn-add-bank-details" class="field-box">
                                                    <p>Payment Details</p>
                                                    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#bank_details">
                                                        <i class="fas fa-plus-circle me-2"></i>Add Bank Details
                                                    </a>
                                                </div>
                                                <div id="btn-remove-bank-details" class="field-box">
                                                    <p>Payment Details</p>
                                                    <a class="btn btn-danger">
                                                        <i class="fe fe-trash-2"></i> Remove Bank Details
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                        @endif
                                        @if(!empty($invoiceView->account_holder_name))
                                            <div id="bank-details-em" class="bank-inner-details">
                                        @else
                                            <div id="bank-details" class="bank-inner-details">
                                        @endif
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Account Holder Name</label>
                                                        <input type="text" class="form-control" id="auto_account_holder_name" name="account_holder_name" placeholder="Add Name" value="{{ $invoiceView->account_holder_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Bank name</label>
                                                        <input type="text" class="form-control" id="auto_bank_name" name="bank_name" placeholder="Add Bank name" value="{{ $invoiceView->bank_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>IFSC Code</label>
                                                        <input type="text" class="form-control" id="auto_ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="{{ $invoiceView->ifsc_code }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>Account Number</label>
                                                        <input type="text" class="form-control" id="auto_account_number" name="account_number" placeholder="Account Number" value="{{ $invoiceView->account_number }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="invoice-faq">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="faq-tab">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <p class="panel-title">
                                                                <a class="collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    <i class="fas fa-plus-circle me-1"></i> Add Terms & Conditions
                                                                </a>
                                                            </p>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                                            <div class="panel-body">
                                                                <textarea class="form-control" name="add_terms_and_conditions"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="faq-tab">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingThree">
                                                            <p class="panel-title">
                                                                <a class="collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    <i class="fas fa-plus-circle me-1"></i> Add Notes
                                                                </a>
                                                            </p>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                                            <div class="panel-body">
                                                                <textarea class="form-control" name="add_notes"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6">
                                        <div class="invoice-total-card">
                                            <h4 class="invoice-total-title">Summary</h4>
                                            <div class="invoice-total-box">
                                                <div class="invoice-total-inner">
                                                    <input type="hidden" name="taxable_amount" id="taxable_amount" value="{{ $invoiceView->taxable_amount }}">
                                                    <p>Taxable Amount <span id="">${{ $invoiceView->taxable_amount }}</span></p>
                                                    <p>Round Off
                                                        @if(!empty($invoiceView->round_off))
                                                            <input type="checkbox" name="round_off" id="status_1" class="check" checked value="{{ $invoiceView->round_off }}">
                                                            <label for="status_1" class="checktoggle">checkbox</label>
                                                            <span>${{ $invoiceView->round_off }}</span>
                                                        @else 
                                                        <input type="checkbox" name="round_off" id="status_1" class="check" value="54">
                                                        <label for="status_1" class="checktoggle">checkbox</label>
                                                        <span>$54</span>
                                                        @endif
                                                    </p>
                                                    <div class="links-info-one">
                                                        <div class="links-info"></div>
                                                    </div>
                                                    @if(!empty($AdditionalCharges))  
                                                        @foreach($AdditionalCharges as $key => $value)
                                                            <div class="service-amount">
                                                                <a href="#" class="service-trash">
                                                                    <i class="fe fe-minus-circle me-1"></i>Service Charge
                                                                </a> 
                                                                <span>${{ $value->service_charge }}</span>
                                                                <input type="hidden" name="service_charge[]" value="{{ $value->service_charge }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <a class="add-links add-links-bg">
                                                        <i class="fas fa-plus-circle me-1"></i> Additional Charges
                                                    </a>
                                                    <div class="links-info-discount">
                                                        <div class="links-cont-discount">
                                                            <a class="add-links-one">
                                                                <i class="fas fa-plus-circle me-1"></i> Add more Discount
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @if(!empty($InvoiceDiscount))  
                                                        @foreach($InvoiceDiscount as $key => $value)
                                                            <div class="service-amount">
                                                                <a href="#" class="service-trash-one">
                                                                    <i class="fe fe-minus-circle me-1"></i> Offer new
                                                                </a>
                                                                <span>${{ $value->offer_new }}%</span>
                                                                <input type="hidden" name="offer_new[]" value="{{ $value->offer_new }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="invoice-total-footer">
                                                    <h4>Total Amount <span id="total_amount">$<span class="total_amount" name="total_amount">{{ $invoiceView->total_amount }}</span></span></h4>
                                                    <input type="hidden" name="total_amount" value="{{ $invoiceView->total_amount }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="upload-sign">
                                            <div class="form-group service-upload">
                                                <span>Update Sign</span>
                                                <input type="file" name="upload_sign" multiple>
                                                <img class="img-fluid d-inline-block" src="{{ asset($invoiceView->upload_sign) }}" alt="sign" style="width: 20%;">
                                                <input type="hidden" name="upload_sign_unlink" value="{{ $invoiceView->upload_sign }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name_of_the_signatuaory" placeholder="Name of the Signatuaory" value="{{ $invoiceView->name_of_the_signatuaory }}">
                                            </div>
                                            <div class="form-group float-end mb-0">
                                                <button class="btn btn-primary" type="submit">Save Invoice</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade invoices-preview" id="invoices_preview" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card invoice-info-card">
                                <div class="card-body pb-0">
                                    <div class="invoice-item invoice-item-one">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="invoice-logo">
                                                    <img src="{{ URL::to('assets/img/logo.png') }}" alt="logo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="invoice-info">
                                                    <div class="invoice-head">
                                                        <h2 class="text-primary">Invoice</h2>
                                                        <p>Invoice Number : In983248782</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="invoice-item invoice-item-bg">
                                        <div class="invoice-circle-img">
                                            <img src="{{ URL::to('assets/img/invoice-circle1.png') }}" alt="" class="invoice-circle1">
                                            <img src="assets/img/invoice-circle2.png" alt=""class="invoice-circle2">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="invoice-info">
                                                    <strong class="customer-text-one">Billed to</strong>
                                                    <h6 class="invoice-name">Customer Name</h6>
                                                    <p class="invoice-details invoice-details-two">
                                                        9087484288 <br>
                                                        Address line 1, <br>
                                                        Address line 2 <br>
                                                        Zip code ,City - Country
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="invoice-info">
                                                    <strong class="customer-text-one">Invoice From</strong>
                                                    <h6 class="invoice-name">Company Name</h6>
                                                    <p class="invoice-details invoice-details-two">
                                                        9087484288 <br>
                                                        Address line 1, <br>
                                                        Address line 2 <br>
                                                        Zip code ,City - Country
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="invoice-info invoice-info-one border-0">
                                                    <p>Issue Date : 27 Jul 2022</p>
                                                    <p>Due Date : 27 Aug 2022</p>
                                                    <p>Due Amount : $ 1,54,22 </p>
                                                    <p>Recurring Invoice : 15 Months</p>
                                                    <p class="mb-0">PO Number : 54515454</p>
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
                                                                <th>Description</th>
                                                                <th>Category</th>
                                                                <th>Rate/Item</th>
                                                                <th>Quantity</th>
                                                                <th>Discount (%)</th>
                                                                <th class="text-end">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Dell Laptop</td>
                                                                <td>Laptop</td>
                                                                <td>$1,110</td>
                                                                <th>2</th>
                                                                <th>2%</th>
                                                                <td class="text-end">$400</td>
                                                            </tr>
                                                            <tr>
                                                                <td>HP Laptop</td>
                                                                <td>Laptop</td>
                                                                <td>$1,500</td>
                                                                <th>3</th>
                                                                <th>6%</th>
                                                                <td class="text-end">$3,000</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Apple Ipad</td>
                                                                <td>Ipad</td>
                                                                <td>$11,500</td>
                                                                <th>1</th>
                                                                <th>10%</th>
                                                                <td class="text-end">$11,000</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="invoice-payment-box">
                                                <h4>Payment Details</h4>
                                                <div class="payment-details">
                                                    <p>Debit Card XXXXXXXXXXXX-2541 HDFC Bank</p>
                                                </div>
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
                                                        <h4>Total Amount <span>$143,300.00</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-sign-box">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8">
                                                <div class="invoice-terms">
                                                    <h6>Notes:</h6>
                                                    <p class="mb-0">Enter customer notes or any other details</p>
                                                </div>
                                                <div class="invoice-terms mb-0">
                                                    <h6>Terms and Conditions:</h6>
                                                    <p class="mb-0">Enter customer notes or any other details</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <div class="invoice-sign text-end">
                                                    <img class="img-fluid d-inline-block"
                                                        src="{{ URL::to('assets/img/signature.png') }}" alt="sign">
                                                    <span class="d-block">{{ Session::get('name') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade bank-details" id="bank_details" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-header text-start mb-0">
                        <h4 class="mb-0">Add Bank Details</h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bank-inner-details">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Account Holder Name</label>
                                    <input type="text" class="form-control" id="account_holder_name" placeholder="Add Name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Bank name</label>
                                    <input type="text" class="form-control" id="bank_name" placeholder="Add Bank name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>IFSC Code</label>
                                    <input type="text" class="form-control" id="ifsc_code" placeholder="IFSC Code">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" id="account_number" placeholder="Account Number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="bank-details-btn">
                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                        <a id="save-item" class="btn bank-save-btn" class="close" data-bs-dismiss="modal" aria-label="Close">Save Item</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="delete_invoices_details" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Invoice Details</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <form action="{{ route('invoice/delete') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="invoice_id" value="{{ $invoiceView->invoice_id }}">
                                <input type="hidden" name="upload_sign" value="{{ $invoiceView->upload_sign }}">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary continue-btn submit-btn" style="border-radius: 5px !important;">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a href="#" data-bs-dismiss="modal"class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal custom-modal fade" id="save_invocies_details" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Save Invoice Details</h3>
                        <p>Are you sure want to save?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
                            </div>
                            <div class="col-6">
                                <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')

        {{-- show hide [Bank Details]--}}
        <script>
            $('#bank-details').hide();
            $('#btn-remove-bank-details').hide();
            $(function() {
                $("#save-item").click(function() {
                    if (!isNaN($("#account_holder_name").val())) {
                        $('#bank-details').hide();
                    } else {
                        $('#bank-details').show();
                        $('#btn-add-bank-details').hide();
                        $('#btn-remove-bank-details').show();
                        var account_holder_name = $('#account_holder_name').val();
                        var bank_name = $('#bank_name').val();
                        var ifsc_code = $('#ifsc_code').val();
                        var account_number = $('#account_number').val();

                        $('#auto_account_holder_name').val(account_holder_name);
                        $('#auto_bank_name').val(bank_name);
                        $('#auto_ifsc_code').val(ifsc_code);
                        $('#auto_account_number').val(account_number);
                    }
                });
                $("#btn-remove-bank-details").click(function() {
                    $('#bank-details').hide();
                    $('#btn-add-bank-details').show();
                    $('#btn-remove-bank-details').hide();
                });
            });
        </script>

        {{-- show hide [Recurring Invoice]--}}
        <script>
            $(function() {
                $("input[name='recurring_incoice']").click(function() {
                    if ($("#chkYes").is(":checked")) {
                        $("#show-invoices").show();
                    } else {
                        $("#show-invoices").hide();
                    }
                });
            });
        </script>

        {{-- add rows and remove [Item Details]--}}
        <script>
            $(".add-table-items").on('click', '.remove-btn', function() {
                $(this).closest('.add-row').remove();
                return false;
            });
            
            $(document).on("click", ".add-btn", function() {
                var experiencecontent =
                '<tr class="add-row">' +
                    '<td>' + '<input type="text" class="form-control" name="items[]">' + '</td>' +
                    '<td>' + '<input type="text" class="form-control" name="category[]">' + '</td>' +
                    '<td>' + '<input type="text" class="form-control" name="quantity[]">' + '</td>' +
                    '<td>' + '<input type="text" class="form-control price" name="price[]">' + '</td>' +
                    '<td>' + '<input type="text" class="form-control amount" name="amount[]">' + '</td>' +
                    '<td>' + '<input type="text" class="form-control discount" name="discount[]">' + '</td>' +
                    '<td class="add-remove text-end">' +
                        '<a class="add-btn me-2"><i class="fas fa-plus-circle"></i></a> ' +
                        '<a class="copy-btn me-2"><i class="fe fe-copy"></i></a>' +
                        '<a class="remove-btn"><i class="fe fe-trash-2"></i></a>' +
                    '</td>' +
                '</tr>';
                $(".add-table-items").append(experiencecontent);
                return false;
            });
        </script>

        <script>

            $('#invoice-add-table tbody').on("keyup",".price",function()
            {
                var parent = $(this).closest('tr');
                var price  = parseFloat($(parent).find('.price').val());
                $(parent).find('.price').val(price);
                GrandTotal();
            });

            function GrandTotal() {
                var sum = 0;
                $('.price').each(function() {
                    sum += Number($(this).val());
                });
                $(document).on("change keyup blur", ".discount", function() 
                {
                    var discount = parseFloat($('.discount').val());
                    var calculatedDiscount = (sum * discount) / 100;
                    var totalAmount = sum - calculatedDiscount;
                    if (!isNaN(totalAmount)) {
                        document.querySelector('.total_amount').innerText = totalAmount;
                    }
                }); 
            };
        </script>

        {{-- Summary --}}
        <script>
            $(document).on("click", ".add-links", function() {
                var experiencecontent = 
                '<div class="links-cont">' +
                    '<div class="service-amount">' +
                        '<a href="#" class="service-trash">' +
                            '<i class="fe fe-minus-circle me-1"></i>' +
                            'Service Charge ' +
                        '</a> ' +
                        '<span>$ 4</span><input name="service_charge[]" value="4" hidden>' +
                    
                    '</div>' +
                '</div>';
                $(".links-info-one").append(experiencecontent);
                return false;
            });

            $(".links-info-discount").on('click', '.service-trash-one', function() {
                $(this).closest('.links-cont-discount').remove();
                return false;
            });

            $(document).on("click", ".add-links-one", function() {
                var experiencecontent =
                '<div class="links-cont-discount">' +
                    '<div class="service-amount">' +
                        '<a href="#" class="service-trash-one">' +
                            '<i class="fe fe-minus-circle me-1"></i> Offer new' +
                        '</a>' +
                        '<span>$ 4 %</span><input name="offer_new[]" value="4"hidden>' +
                    '</div>' +
                '</div>';
                $(".links-info-discount").append(experiencecontent);
                return false;
            });

            $(document).on("click", ".add-links", function() {
                var experiencecontent = 
                '<div class="row form-row links-cont">' +
                    '<div class="form-group d-flex">' +
                        '<button class="btn social-icon">' +
                            '<i class="feather-github"></i>' +
                        '</button>' +
                        '<input type="text" class="form-control" placeholder="Social Link">' +
                        '<div>' +
                            '<a href="#" class="btn trash">' +
                                '<i class="feather-trash-2"></i>' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                '</div>';
                $(".settings-form").append(experiencecontent);
                return false;
            });
        </script>

    @endsection
@endsection
