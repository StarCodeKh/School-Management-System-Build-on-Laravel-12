<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Subject;

class SubjectController extends Controller
{
    /** index page */
    public function subjectList()
    {
        $subjectList = Subject::all();
        return view('subjects.subject_list',compact('subjectList'));
    }

    /** subject add */
    public function subjectAdd()
    {
        return view('subjects.subject_add');
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string',
            'class'        => 'required|string',
        ]);
        
        DB::beginTransaction();
        try {
                $saveRecord = new Subject;
                $saveRecord->subject_name   = $request->subject_name;
                $saveRecord->class          = $request->class;
                $saveRecord->save();

                // Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            Toastr::error('fail, Add new record:)','Error');
            return redirect()->back();
        }
    }

    /** subject edit view */
    public function subjectEdit($subject_id)
    {
        $subjectEdit = Subject::where('subject_id',$subject_id)->first();
        return view('subjects.subject_edit',compact('subjectEdit'));
    }

    /** update record */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $updateRecord = [
                'subject_name' => $request->subject_name,
                'class'        => $request->class,
            ];

            Subject::where('subject_id',$request->subject_id)->update($updateRecord);
            // Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            Toastr::error('Fail, update record:)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            Subject::where('subject_id',$request->subject_id)->delete();
            DB::commit();
            // Toastr::success('Deleted record successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            // Toastr::error('Deleted record fail :)','Error');
            return redirect()->back();
        }
    }

}
