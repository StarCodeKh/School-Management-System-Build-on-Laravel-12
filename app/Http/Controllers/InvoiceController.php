<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\InvoiceDetails;
use App\Models\InvoiceDiscount;
use App\Models\InvoiceTotalAmount;
use App\Models\InvoiceCustomerName;
use App\Models\InvoicePaymentDetails;
use App\Models\InvoiceAdditionalCharges;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /** index page */
    public function invoiceList()
    {
        $invoiceList = InvoiceDetails::join('invoice_customer_names as icn', 'invoice_details.invoice_id', 'icn.invoice_id')
            ->join('invoice_total_amounts as ita', 'invoice_details.invoice_id', 'ita.invoice_id')
            ->select('invoice_details.invoice_id', 'invoice_details.category', 'icn.customer_name', 'ita.total_amount')
            ->distinct('invoice_details.invoice_id')
            ->get();
        $invoiceList = $invoiceList->unique('invoice_id')->values();
        return view('invoices.list_invoices',compact('invoiceList'));
    }

    /** invoice paid page */
    public function invoicePaid()
    {
        return view('invoices.tab.paid_invoices');
    }

    /** incoice overdue page*/
    public function invoiceOverdue()
    {
        return view('invoices.tab.overdue_invoices');
    }

    /** invoice draft */
    public function invoiceDraft()
    {
        return view('invoices.tab.draft_invoices');
    }

    /** recurring invoices.blade */
    public function invoiceRecurring()
    {
        return view('invoices.tab.recurring_invoices');
    }

    /** invoice cancelled */
    public function invoiceCancelled()
    {
        return view('invoices.tab.cancelled_invoices');
    }

    /** invoice grid */
    public function invoiceGrid()
    {
        $invoiceList = InvoiceDetails::join('invoice_customer_names as icn', 'invoice_details.invoice_id', 'icn.invoice_id')
            ->join('invoice_total_amounts as ita', 'invoice_details.invoice_id', 'ita.invoice_id') // Add this line for the additional join
            ->select('invoice_details.invoice_id','icn.customer_name','ita.total_amount')
            ->distinct('icn.invoice_id')
            ->get();
        return view('invoices.grid_invoice',compact('invoiceList'));
    }
    
    /** invoice add page */
    public function invoiceAdd()
    {
        $users = User::whereIn('role_name',['Student','Client'])->get();
        return view('invoices.invoice_add',compact('users'));
    }

    /** save record incoice */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'po_number'  => 'required|string',
            'due_date'   => 'required|string',
            'items.*'    => 'required|string',
            'category.*' => 'required|string',
            'quantity.*' => 'required|string',
            'price.*'    => 'required|string',
            'amount.*'   => 'required|string',
            'discount.*' => 'required|string',
            'name_of_the_signatuaory' => 'required|string',
        ]);
        
        DB::beginTransaction();
        try {

            $customerName                    = new InvoiceCustomerName;
            $customerName->customer_name     = $request->customer_name;
            $customerName->po_number         = $request->po_number;
            $customerName->date              = $request->date;
            $customerName->due_date          = $request->due_date;
            $customerName->enable_tax        = $request->enable_tax;
            $customerName->recurring_incoice = $request->recurring_incoice;
            $customerName->by_month          = $request->by_month;
            $customerName->month             = $request->month;
            $customerName->invoice_from      = $request->invoice_from;
            $customerName->invoice_to        = $request->invoice_to;
            $customerName->save();

            /** invoice id last record */
            $invoiceId = InvoiceCustomerName::select('invoice_id')->orderBy('id', 'DESC')->first();

            foreach ($request->items as $key => $values) {
                $InvoiceDetails             = new InvoiceDetails;
                $InvoiceDetails->invoice_id = $invoiceId->invoice_id;
                $InvoiceDetails->items      = $request->items[$key];
                $InvoiceDetails->category   = $request->category[$key];
                $InvoiceDetails->quantity   = $request->quantity[$key];
                $InvoiceDetails->price      = $request->price[$key];
                $InvoiceDetails->amount     = $request->amount[$key];
                $InvoiceDetails->discount   = $request->discount[$key];
                $InvoiceDetails->save();
            }

            if ($request->hasFile('upload_sign')) {
                $file        = $request->file('upload_sign');
                $upload_sign = $file->store('public/upload_sign','local'); // 'local' disk corresponds to the storage/app directory    
            } else {
                $upload_sign = 'NULL';
            }

            /** InvoiceTotalAmount */
            $InvoiceTotalAmount                          = new InvoiceTotalAmount;
            $InvoiceTotalAmount->invoice_id              = $invoiceId->invoice_id;
            $InvoiceTotalAmount->taxable_amount          = $request->taxable_amount;
            $InvoiceTotalAmount->round_off               = $request->round_off;
            $InvoiceTotalAmount->total_amount            = $request->total_amount;
            $InvoiceTotalAmount->upload_sign             = $upload_sign;
            $InvoiceTotalAmount->name_of_the_signatuaory = $request->name_of_the_signatuaory;
            $InvoiceTotalAmount->save();

            /** InvoiceAdditionalCharges */
            if(!empty($request->service_charge)) {
                foreach ($request->service_charge as $key => $values) {
                    $InvoiceAdditionalCharges                 = new InvoiceAdditionalCharges;
                    $InvoiceAdditionalCharges->invoice_id     = $invoiceId->invoice_id;
                    $InvoiceAdditionalCharges->service_charge = $request->service_charge[$key];
                    $InvoiceAdditionalCharges->save();
                }
            }
            /** InvoiceDiscount */
            if (!empty($request->offer_new)) {
                foreach ($request->offer_new as $key => $values) {
                    $InvoiceDiscount             = new InvoiceDiscount;
                    $InvoiceDiscount->invoice_id = $invoiceId->invoice_id;
                    $InvoiceDiscount->offer_new  = $request->offer_new[$key];
                    $InvoiceDiscount->save();
                }
            }

            /** InvoicePaymentDetails */
            $InvoicePaymentDetails                            = new InvoicePaymentDetails;
            $InvoicePaymentDetails->invoice_id                = $invoiceId->invoice_id;
            $InvoicePaymentDetails->account_holder_name       = $request->account_holder_name;
            $InvoicePaymentDetails->bank_name                 = $request->bank_name;
            $InvoicePaymentDetails->ifsc_code                 = $request->ifsc_code;
            $InvoicePaymentDetails->account_number            = $request->account_number;
            $InvoicePaymentDetails->add_terms_and_Conditions  = $request->add_terms_and_Conditions;
            $InvoicePaymentDetails->add_notes                 = $request->add_notes;
            $InvoicePaymentDetails->save();

            // Toastr::success('Has been add successfully :)','Success');
            DB::commit();
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            // Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }

    /** invoice edit */
    public function invoiceEdit($invoice_id)
    {
        $invoiceView = InvoiceDetails::join('invoice_customer_names as icn', 'invoice_details.invoice_id', 'icn.invoice_id')
            ->join('invoice_total_amounts as ita', 'invoice_details.invoice_id', 'ita.invoice_id')
            ->join('invoice_payment_details as ipd', 'invoice_details.invoice_id', 'ipd.invoice_id')
            ->select('invoice_details.*','icn.customer_name','icn.po_number',
            'icn.date','icn.due_date','icn.enable_tax','icn.recurring_incoice','icn.by_month'
            ,'icn.month','icn.invoice_from','icn.invoice_to','ita.*','ita.name_of_the_signatuaory','ipd.*')
            ->distinct('invoice_details.invoice_id')
            ->where('icn.invoice_id',$invoice_id)
            ->first();

        $users = User::all();
        $invoiceDetails    = InvoiceDetails::where('invoice_id',$invoice_id)->get();
        $AdditionalCharges = InvoiceAdditionalCharges::where('invoice_id',$invoice_id)->get();
        $InvoiceDiscount   = InvoiceDiscount::where('invoice_id',$invoice_id)->get();

        return view('invoices.invoice_edit',compact('invoiceView','users','invoiceDetails','AdditionalCharges','InvoiceDiscount'));
    }

    /** update record */
    public function updateRecord(Request $request)
    {
        try {

            $customerName                    = InvoiceCustomerName::where('invoice_id',$request->invoice_id)->firstOrFail();
            $customerName->customer_name     = $request->customer_name;
            $customerName->po_number         = $request->po_number;
            $customerName->date              = $request->date;
            $customerName->due_date          = $request->due_date;
            $customerName->enable_tax        = $request->enable_tax;
            $customerName->recurring_incoice = $request->recurring_incoice;
            $customerName->by_month          = $request->by_month;
            $customerName->month             = $request->month;
            $customerName->invoice_from      = $request->invoice_from;
            $customerName->invoice_to        = $request->invoice_to;
            $customerName->save();

            foreach ($request->items as $key => $values) {
                $InvoiceDetails             = InvoiceDetails::where('invoice_id',$request->invoice_id)->firstOrFail();
                $InvoiceDetails->items      = $request->items[$key];
                $InvoiceDetails->category   = $request->category[$key];
                $InvoiceDetails->quantity   = $request->quantity[$key];
                $InvoiceDetails->price      = $request->price[$key];
                $InvoiceDetails->amount     = $request->amount[$key];
                $InvoiceDetails->discount   = $request->discount[$key];
                $InvoiceDetails->save();
            }

            /** InvoiceAdditionalCharges */
            if(!empty($request->service_charge)) {
                foreach ($request->service_charge as $key => $values) {
                    $InvoiceAdditionalCharges                 = InvoiceAdditionalCharges::where('invoice_id',$request->invoice_id)->firstOrFail();
                    $InvoiceAdditionalCharges->service_charge = $request->service_charge[$key];
                    $InvoiceAdditionalCharges->save();
                }
            }
            /** InvoiceDiscount */
            if (!empty($request->offer_new)) {
                foreach ($request->offer_new as $key => $values) {
                    $InvoiceDiscount             = InvoiceDiscount::where('invoice_id',$request->invoice_id)->firstOrFail();
                    $InvoiceDiscount->offer_new  = $request->offer_new[$key];
                    $InvoiceDiscount->save();
                }
            }

            $InvoicePaymentDetails                            = InvoicePaymentDetails::where('invoice_id',$request->invoice_id)->firstOrFail();
            $InvoicePaymentDetails->account_holder_name       = $request->account_holder_name;
            $InvoicePaymentDetails->bank_name                 = $request->bank_name;
            $InvoicePaymentDetails->ifsc_code                 = $request->ifsc_code;
            $InvoicePaymentDetails->account_number            = $request->account_number;
            $InvoicePaymentDetails->add_terms_and_Conditions  = $request->add_terms_and_Conditions;
            $InvoicePaymentDetails->add_notes                 = $request->add_notes;
            $InvoicePaymentDetails->save();

            if(!empty($request->upload_sign)) {
                $file = $request->upload_sign_unlink;
                if (Storage::exists($file)) {
                    unlink(Storage::path($file));
                }
            } 
            if ($request->hasFile('upload_sign')) {
                $file        = $request->file('upload_sign');
                $upload_sign = $file->store('public/upload_sign','local'); // 'local' disk corresponds to the storage/app directory    
            } else {
                $upload_sign = $request->upload_sign_unlink;
            }
            
            /** InvoiceTotalAmount */
            $InvoiceTotalAmount                          = InvoiceTotalAmount::where('invoice_id',$request->invoice_id)->firstOrFail();
            $InvoiceTotalAmount->taxable_amount          = $request->taxable_amount;
            $InvoiceTotalAmount->round_off               = $request->round_off;
            $InvoiceTotalAmount->total_amount            = $request->total_amount;
            $InvoiceTotalAmount->upload_sign             = $upload_sign;
            $InvoiceTotalAmount->name_of_the_signatuaory = $request->name_of_the_signatuaory;
            $InvoiceTotalAmount->save();

            // Toastr::success('Has been updated successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::info($e);
            // Toastr::error('fail, update record  :)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            InvoiceCustomerName::where('invoice_id',$request->invoice_id)->delete();
            InvoiceDetails::where('invoice_id',$request->invoice_id)->delete();
            InvoiceTotalAmount::where('invoice_id',$request->invoice_id)->delete();
            InvoiceAdditionalCharges::where('invoice_id',$request->invoice_id)->delete();
            InvoiceDiscount::where('invoice_id',$request->invoice_id)->delete();
            InvoicePaymentDetails::where('invoice_id',$request->invoice_id)->delete();

            $file = $request->upload_sign;
            if (Storage::exists($file)) {
                unlink(Storage::path($file));
            }

            DB::commit();
            Toastr::success('Record deleted successfully :)','Success');
            return redirect()->route('invoice/list/page');
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Record deleted fail :)','Error');
            return redirect()->back();
        }

    }

    /** invoice view */
    public function invoiceView($invoice_id)
    {
        $invoiceView = InvoiceDetails::join('invoice_customer_names as icn', 'invoice_details.invoice_id', 'icn.invoice_id')
            ->join('invoice_total_amounts as ita', 'invoice_details.invoice_id', 'ita.invoice_id')
            ->join('invoice_payment_details as ide', 'invoice_details.invoice_id', 'ide.invoice_id')
            ->select('invoice_details.*','icn.customer_name','ita.total_amount',
            'icn.due_date','icn.po_number','icn.enable_tax','ita.round_off','icn.recurring_incoice',
            'icn.by_month','icn.month','icn.invoice_from','icn.invoice_to'
            ,'ide.bank_name','ide.account_number','ita.total_amount','ita.upload_sign','ita.name_of_the_signatuaory')
            ->distinct('invoice_details.invoice_id')
            ->where('icn.invoice_id',$invoice_id)
            ->first();
        $invoiceDetails = InvoiceDetails::where('invoice_id',$invoice_id)->get();

        return view('invoices.invoice_view',compact('invoiceView','invoiceDetails'));
    }

    /** invoice settings */
    public function invoiceSettings()
    {
        return view('invoices.settings.settings_invoices');
    }

    /** invoice settingst tax */
    public function invoiceSettingsTax()
    {
        return view('invoices.settings.settings_tax');
    }

    /** invoice settings bank */
    public function invoiceSettingsBank()
    {
        return view('invoices.settings.settings_bank');
    }
}
