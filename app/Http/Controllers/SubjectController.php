<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Log;
use DB;

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

    /** Save Record */
    public function saveRecord(Request $request)
    {
        // Validate request input
        $request->validate([
            'subject_name' => 'required|string',
            'class'        => 'required|string',
        ]);
        
        DB::beginTransaction();
        try {
            // Create a new Subject record
            $saveRecord = new Subject;
            $saveRecord->subject_name = $request->subject_name;
            $saveRecord->class = $request->class;
            $saveRecord->save();

            // Commit the transaction
            DB::commit();

            // Log success
            Log::info('Subject record saved successfully', [
                'subject_name' => $request->subject_name,
                'class' => $request->class,
            ]);
            return redirect()->back()->with('success', 'Subject record saved successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to save Subject record', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to save Subject record: ' . $e->getMessage());
        }
    }

    /** subject edit view */
    public function subjectEdit($subject_id)
    {
        $subjectEdit = Subject::where('subject_id',$subject_id)->first();
        return view('subjects.subject_edit',compact('subjectEdit'));
    }

    /** Update Record */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            // Prepare update data
            $updateRecord = [
                'subject_name' => $request->subject_name,
                'class'        => $request->class,
            ];
    
            // Update the Subject record
            Subject::where('subject_id', $request->subject_id)->update($updateRecord);
    
            // Commit the transaction
            DB::commit();
    
            // Log success
            Log::info('Subject record updated successfully', [
                'subject_id'   => $request->subject_id,
                'subject_name' => $request->subject_name,
                'class'        => $request->class,
            ]);
            return redirect()->back()->with('success', 'Subject record updated successfully!');
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update Subject record', [
                'error'   => $e->getMessage(),
                'subject_id' => $request->subject_id,
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to update Subject record: ' . $e->getMessage());
        }
    }

    /** Delete Record */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            $subject = Subject::where('subject_id', $request->subject_id)->first();
            if ($subject) {
                Log::info('Subject record deleted', [
                    'subject_id'   => $request->subject_id,
                    'subject_name' => $subject->subject_name,
                ]);
                $subject->delete();
                DB::commit();
                return redirect()->back()->with('success', 'Subject record deleted successfully!');
            } else {
                Log::warning('Subject record not found for deletion', [
                    'subject_id' => $request->subject_id,
                ]);

                return redirect()->back()->with('error', 'Subject record not found!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete Subject record', [
                'error'   => $e->getMessage(),
                'subject_id' => $request->subject_id,
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to delete Subject record: ' . $e->getMessage());
        }
    }

}
