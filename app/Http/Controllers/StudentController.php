<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Student;
use DB;


class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student',compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid',compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        return view('student.add-student');
    }
    
    /** Save Record */
    public function studentSave(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|date',
            'roll'          => 'required|string|max:50',
            'blood_group'   => 'required|string|max:10',
            'religion'      => 'required|string|max:50',
            'email'         => 'required|email|unique:students,email',
            'class'         => 'required|string|max:50',
            'section'       => 'required|string|max:50',
            'admission_id'  => 'required|string|unique:students,admission_id',
            'phone_number'  => 'required|numeric|digits_between:8,15',
            'upload'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        DB::beginTransaction();
        try {
            if ($request->hasFile('upload')) {
                $filename = time().'_'.$request->file('upload')->getClientOriginalName();
                $request->file('upload')->move(public_path('student-photos'), $filename);
    
                // Save record
                $student = Student::create([
                    'first_name'    => $validated['first_name'],
                    'last_name'     => $validated['last_name'],
                    'gender'        => $validated['gender'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'roll'          => $validated['roll'],
                    'blood_group'   => $validated['blood_group'],
                    'religion'      => $validated['religion'],
                    'email'         => $validated['email'],
                    'class'         => $validated['class'],
                    'section'       => $validated['section'],
                    'admission_id'  => $validated['admission_id'],
                    'phone_number'  => $validated['phone_number'],
                    'upload'        => 'student-photos/'.$filename,
                ]);
    
                DB::commit();
                return redirect()->back()->with('success', 'Student has been added successfully!');
            }
    
            Log::warning('File Upload Missing', ['email' => $validated['email']]);
            return redirect()->back()->with('error', 'Upload file is required.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student Save Failed', ['error' => $e->getMessage(), 'email' => $validated['email'] ?? null]);
            return redirect()->back()->with('error', 'Failed to add new student: ' . $e->getMessage());
        }
    }
    
    /** View */
    public function studentEdit($id)
    {
        $studentEdit = Student::where('id',$id)->first();
        return view('student.edit-student',compact('studentEdit'));
    }

    /** Update Record */
    public function studentUpdate(Request $request)
    {
        $validated = $request->validate([
            'id'            => 'required|exists:students,id',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|date',
            'roll'          => 'required|string|max:50',
            'blood_group'   => 'required|string|max:10',
            'religion'      => 'required|string|max:50',
            'email'         => 'required|email|unique:students,email,' . $request->id,
            'class'         => 'required|string|max:50',
            'section'       => 'required|string|max:50',
            'admission_id'  => 'required|string|unique:students,admission_id,' . $request->id,
            'phone_number'  => 'required|numeric|digits_between:8,15',
            'upload'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_hidden'  => 'nullable|string', // The old image path
        ]);
    
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($validated['id']);
            $oldImagePath = $student->upload;
    
            if ($request->hasFile('upload')) {
                if (!empty($oldImagePath) && file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
                $upload_file = time() . '_' . $request->file('upload')->getClientOriginalName();
                $request->file('upload')->move(public_path('student-photos'), $upload_file);
            } else {
                $upload_file = $oldImagePath;
            }
    
            // Update the student record
            $student->update([
                'first_name'    => $validated['first_name'],
                'last_name'     => $validated['last_name'],
                'gender'        => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'roll'          => $validated['roll'],
                'blood_group'   => $validated['blood_group'],
                'religion'      => $validated['religion'],
                'email'         => $validated['email'],
                'class'         => $validated['class'],
                'section'       => $validated['section'],
                'admission_id'  => $validated['admission_id'],
                'phone_number'  => $validated['phone_number'],
                'upload'        => 'student-photos/' . $upload_file, // Update the upload field
            ]);
    
            DB::commit();
            return redirect()->back()->with('success', 'Updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student Update Failed', ['error' => $e->getMessage(), 'id' => $validated['id']]);
            return redirect()->back()->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    /** Delete Record */
    public function studentDelete(Request $request)
    {
        $validated = $request->validate([
            'id'     => 'required|exists:students,id',
            'upload' => 'nullable|string',
        ]);
    
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($validated['id']);
            $avatarPath = $student->upload;
            $student->delete();
            if (!empty($avatarPath)) {
                $fullPath = public_path($avatarPath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Student deleted successfully :)');
        
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Student Deletion Failed', ['error' => $e->getMessage(), 'id' => $validated['id']]);
            return redirect()->back()->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }    

    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = Student::where('id',$id)->first();
        return view('student.student-profile',compact('studentProfile'));
    }
}
