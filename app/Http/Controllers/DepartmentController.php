<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /** index page department */
    public function indexDepartment()
    {
        return view('department.add-department');
    }
    
    /** edit record */
    public function editDepartment($department_id)
    {
        $department = Department::where('department_id',$department_id)->first();
        return view('department.edit-departmen',compact('department'));
    }

    /** department list */
    public function departmentList()
    {
        return view('department.list-department');
    }

    /** get data list */
    public function getDataList(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); // total number of rows per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = $search_arr['value']; // Search value

        $departments =  DB::table('departments');
        $totalRecords = $departments->count();

        $totalRecordsWithFilter = $departments->where(function ($query) use ($searchValue) {
            $query->where('department_id', 'like', '%' . $searchValue . '%');
            $query->orWhere('department_name', 'like', '%' . $searchValue . '%');
            $query->orWhere('head_of_department', 'like', '%' . $searchValue . '%');
            $query->orWhere('department_start_date', 'like', '%' . $searchValue . '%');
            $query->orWhere('no_of_students', 'like', '%' . $searchValue . '%');
        })->count();

        $records = $departments->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('department_id', 'like', '%' . $searchValue . '%');
                $query->orWhere('department_name', 'like', '%' . $searchValue . '%');
                $query->orWhere('head_of_department', 'like', '%' . $searchValue . '%');
                $query->orWhere('department_start_date', 'like', '%' . $searchValue . '%');
                $query->orWhere('no_of_students', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data_arr = [];
        
        foreach ($records as $key => $record) {

            $modify = '
                <td class="text-end"> 
                    <div class="actions">
                        <a href="'.url('department/edit/'.$record->department_id).'" class="btn btn-sm bg-danger-light">
                            <i class="far fa-edit me-2"></i>
                        </a>
                        <a class="btn btn-sm bg-danger-light delete department_id" data-bs-toggle="modal" data-department_id="'.$record->id.'" data-bs-target="#delete">
                        <i class="fe fe-trash-2"></i>
                        </a>
                    </div>
                </td>
            ';

            $data_arr [] = [
                "department_id"         => $record->department_id,
                "department_name"       => $record->department_name,
                "head_of_department"    => $record->head_of_department,
                "department_start_date" => $record->department_start_date,
                "no_of_students"        => $record->no_of_students,
                "modify"                => $modify,
            ];
        }

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];
        return response()->json($response);
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'department_name'       => 'required|string',
            'head_of_department'    => 'required|string',
            'department_start_date' => 'required|string',
            'no_of_students'        => 'required|string',
        ]);

        try {

            $saveRecord = new Department;
            $saveRecord->department_name       = $request->department_name;
            $saveRecord->head_of_department    = $request->head_of_department;
            $saveRecord->department_start_date = $request->department_start_date;
            $saveRecord->no_of_students        = $request->no_of_students;
            $saveRecord->save();
   
            Toastr::success('Has been add successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            Toastr::error('fail, Add new record  :)','Error');
            return redirect()->back();
        }
    }

    /** update record */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            
            $updateRecord = [
                'department_name'       => $request->department_name,
                'head_of_department'    => $request->head_of_department,
                'department_start_date' => $request->department_start_date,
                'no_of_students'        => $request->no_of_students,
            ];

            Department::where('department_id',$request->department_id)->update($updateRecord);
            // Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            // Toastr::error('Fail, update record:)','Error');
            return redirect()->back();
        }
    }

    /** department delete record */
    public function deleteRecord(Request $request) 
    {
        DB::beginTransaction();
        try {

            Department::destroy($request->department_id);
            DB::commit();
            // Toastr::success('Department deleted successfully :)','Success');
            return redirect()->back();
    
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            // Toastr::error('Department deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
