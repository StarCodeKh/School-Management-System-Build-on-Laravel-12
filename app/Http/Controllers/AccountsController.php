<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeesType;
use App\Models\FeesInformation;
use App\Models\User;
use Log;

class AccountsController extends Controller
{
    /** index page */
    public function index()
    {
        $feesInformation = FeesInformation::join('users', 'fees_information.student_id', 'users.id')
            ->select('fees_information.*','users.avatar')
            ->get();
        return view('accounts.feescollections',compact('feesInformation'));
    }

    /** add Fees Collection */
    public function addFeesCollection()
    {
        $users    = User::whereIn('role_name',['Student'])->get();
        $feesType = FeesType::all();
        return view('accounts.add-fees-collection',compact('users','feesType'));
    }

    /** Save Record */
    public function saveRecord(Request $request)
    {
        // Validate the request
        $request->validate([
            'student_id'   => 'required|string',
            'student_name' => 'required|string',
            'gender'       => 'required|string',
            'fees_type'    => 'required|string',
            'fees_amount'  => 'required|string',
            'paid_date'    => 'required|string',
        ]);

        try {
            // Create new record
            $saveRecord = new FeesInformation;
            $saveRecord->student_id   = $request->student_id;
            $saveRecord->student_name = $request->student_name;
            $saveRecord->gender       = $request->gender;
            $saveRecord->fees_type    = $request->fees_type;
            $saveRecord->fees_amount  = $request->fees_amount;
            $saveRecord->paid_date    = $request->paid_date;
            $saveRecord->save();

            // Log success message
            Log::info('New fees record saved successfully', [
                'student_id'   => $request->student_id,
                'student_name' => $request->student_name,
                'fees_type'    => $request->fees_type,
            ]);
            return redirect()->back()->with('success', 'Fees record saved successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to save fees record', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to save fees record. Please try again.');
        }
    }
}
