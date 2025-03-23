<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use DB;


class TeacherController extends Controller
{
    /** add teacher page */
    public function teacherAdd()
    {
        $users = User::where('role_name','Teachers')->get();
        return view('teacher.add-teacher',compact('users'));
    }

    /** teacher list */
    public function teacherList()
    {
        $listTeacher = Teacher::join('users', 'teachers.teacher_id','users.user_id')
                    ->select('users.date_of_birth','users.join_date','users.phone_number','teachers.*')->get();
        return view('teacher.list-teachers',compact('listTeacher'));
    }

    /** teacher Grid */
    public function teacherGrid()
    {
        $teacherGrid = Teacher::all();
        return view('teacher.teachers-grid',compact('teacherGrid'));
    }

    /** Save Record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'experience'    => 'required|string',
            'date_of_birth' => 'required|string',
            'qualification' => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'zip_code'      => 'required|string',
            'country'       => 'required|string',
        ]);
        
        try {
            // Create a new Teacher record
            $saveRecord = new Teacher;
            $saveRecord->full_name     = $request->full_name;
            $saveRecord->teacher_id    = $request->teacher_id;
            $saveRecord->gender        = $request->gender;
            $saveRecord->experience    = $request->experience;
            $saveRecord->qualification = $request->qualification;
            $saveRecord->date_of_birth = $request->date_of_birth;
            $saveRecord->phone_number  = $request->phone_number;
            $saveRecord->address       = $request->address;
            $saveRecord->city          = $request->city;
            $saveRecord->state         = $request->state;
            $saveRecord->zip_code      = $request->zip_code;
            $saveRecord->country       = $request->country;
            $saveRecord->save();
    
            return redirect()->back()->with('success', 'Teacher record saved successfully!');
            
        } catch(\Exception $e) {
            // Log error
            Log::error('Failed to save Teacher record', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Failed to save Teacher record: ' . $e->getMessage());
        }
    }

    /** Edit Record */
    public function editRecord($teacher_id)
    {
        $teacher = Teacher::join('users', 'teachers.teacher_id','users.user_id')
                    ->select('users.date_of_birth','users.join_date','users.phone_number','teachers.*')
                    ->where('users.user_id', $teacher_id)->first();
        return view('teacher.edit-teacher',compact('teacher'));
    }

    /** Update Record */
    public function updateRecordTeacher(Request $request)
    {
        // Validate request data
        $request->validate([
            'full_name'     => 'required|string',
            'gender'        => 'required|string',
            'date_of_birth' => 'required|string',
            'qualification' => 'required|string',
            'experience'    => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'city'          => 'required|string',
            'state'         => 'required|string',
            'zip_code'      => 'required|string',
            'country'       => 'required|string',
        ]);
    
        DB::beginTransaction();
        try {
            // Prepare the data to be updated
            $updateRecord = [
                'full_name'     => $request->full_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'qualification' => $request->qualification,
                'experience'    => $request->experience,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
                'city'          => $request->city,
                'state'         => $request->state,
                'zip_code'      => $request->zip_code,
                'country'       => $request->country,
            ];

            Teacher::where('id', $request->id)->update($updateRecord);
            DB::commit();
            return redirect()->back()->with('success', 'Teacher record updated successfully!');
    
        } catch(\Exception $e) {
            DB::rollback();
            Log::error('Failed to update Teacher record', [
                'error' => $e->getMessage(),
                'teacher_id' => $request->id,
                'update_data' => $updateRecord,
            ]);
            return redirect()->back()->with('error', 'Failed to update Teacher record: ' . $e->getMessage());
        }
    }

    /** Delete Record */
    public function teacherDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $teacherId = $request->id;
            $teacher = Teacher::findOrFail($teacherId);
            Teacher::destroy($teacherId);
            DB::commit();
            return redirect()->back()->with('success', 'Teacher record deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete Teacher record', [
                'error' => $e->getMessage(),
                'teacher_id' => $request->id,
            ]);
            return redirect()->back()->with('error', 'Failed to delete Teacher record: ' . $e->getMessage());
        }
    }

}
