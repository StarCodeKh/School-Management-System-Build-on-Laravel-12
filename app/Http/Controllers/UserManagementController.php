<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Session;
use Auth;
use Log;
use DB;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('usermanagement.list_users');
    }

    /** user view */
    public function userView($id)
    {
        $users = User::where('user_id',$id)->first();
        $role  = DB::table('role_type_users')->get();
        return view('usermanagement.user_update',compact('users','role'));
    }

    /** User Update */
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
            {
                $user_id       = $request->user_id;
                $name          = $request->name;
                $email         = $request->email;
                $role_name     = $request->role_name;
                $position      = $request->position;
                $phone         = $request->phone_number;
                $date_of_birth = $request->date_of_birth;
                $department    = $request->department;
                $status        = $request->status;
    
                $image_name = $request->hidden_avatar;
                $image = $request->file('avatar');
    
                if($image_name == 'photo_defaults.jpg') {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/'), $image_name);
                    }
                } else {
                    if($image != '') {
                        $oldImagePath = public_path('/images/') . $image_name;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/'), $image_name);
                    }
                }
    
                $update = [
                    'user_id'       => $user_id,
                    'name'          => $name,
                    'role_name'     => $role_name,
                    'email'         => $email,
                    'position'      => $position,
                    'phone_number'  => $phone,
                    'date_of_birth' => $date_of_birth,
                    'department'    => $department,
                    'status'        => $status,
                    'avatar'        => $image_name,
                ];
    
                User::where('user_id', $request->user_id)->update($update);
            } else {
                Log::warning('Unauthorized user update attempt', [
                    'user_id' => $request->user_id,
                    'role'    => Session::get('role_name'),
                ]);
                return redirect()->back()->with('error', 'User update failed: Unauthorized access.');
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'User updated successfully :)');
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('User update failed', [
                'error'  => $e->getMessage(),
                'user_id' => $request->user_id,
                'request_data' => $request->except(['avatar']),
            ]);
    
            return redirect()->back()->with('error', 'User update failed. Please try again.');
        }
    }
    
    /** user delete */
    public function userDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            if (Session::get('role_name') === 'Super Admin' || Session::get('role_name') === 'Admin')
            {
                if ($request->avatar == 'photo_defaults.jpg')
                {
                    User::destroy($request->user_id);
                } else {
                    User::destroy($request->user_id);
                    unlink('images/'.$request->avatar);
                }
            } else {
                return redirect()->back()->with('error', 'User deleted fail :(');
            }

            DB::commit();
            return redirect()->back()->with('success', 'User deleted successfully :)');
    
        } catch(\Exception $e) {
            Log::info($e);
            DB::rollback();
            return redirect()->back()->with('error', 'User deleted fail :(');
        }
    }

    /** change password */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        DB::commit();
        return redirect()->intended('home')->with('success', 'User change successfully :)');
    }

    /** get users data */
    public function getUsersData(Request $request)
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

        $users =  DB::table('users');
        $totalRecords = $users->count();

        $totalRecordsWithFilter = $users->where(function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
            $query->orWhere('email', 'like', '%' . $searchValue . '%');
            $query->orWhere('position', 'like', '%' . $searchValue . '%');
            $query->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            $query->orWhere('status', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'name') {
            $columnName = 'name';
        }
        $records = $users->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
                $query->orWhere('email', 'like', '%' . $searchValue . '%');
                $query->orWhere('position', 'like', '%' . $searchValue . '%');
                $query->orWhere('phone_number', 'like', '%' . $searchValue . '%');
                $query->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data_arr = [];
        
        foreach ($records as $key => $record) {
            $modify = '
                <td class="text-right">
                    <div class="dropdown dropdown-action">
                        <a href="" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v ellipse_color"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="'.url('users/add/edit/'.$record->user_id).'">
                                <i class="far fa-edit me-2"></i> Edit
                            </a>
                            <a class="dropdown-item" href="'.url('users/delete/'.$record->id).'">
                            <i class="fas fa-trash-alt m-r-5"></i> Delete
                        </a>
                        </div>
                    </div>
                </td>
            ';
            $avatar = '
                <td>
                    <h2 class="table-avatar">
                        <a class="avatar-sm me-2">
                            <img class="avatar-img rounded-circle avatar" data-avatar='.$record->avatar.' src="/images/'.$record->avatar.'"alt="'.$record->name.'">
                        </a>
                    </h2>
                </td>
            ';
            if ($record->status === 'Active') {
                $status = '<td><span class="badge bg-success-dark">'.$record->status.'</span></td>';
            } elseif ($record->status === 'Disable') {
                $status = '<td><span class="badge bg-danger-dark">'.$record->status.'</span></td>';
            }  elseif ($record->status === 'Inactive') {
                $status = '<td><span class="badge badge-warning">'.$record->status.'</span></td>';
            } else {
                $status = '<td><span class="badge badge-secondary">'.$record->status.'</span></td>';
            }

            $modify = '
                <td class="text-end"> 
                    <div class="actions">
                        <a href="'.url('view/user/edit/'.$record->user_id).'" class="btn btn-sm bg-danger-light">
                            <i class="far fa-edit me-2"></i>
                        </a>
                        <a class="btn btn-sm bg-danger-light delete user_id" data-bs-toggle="modal" data-user_id="'.$record->user_id.'" data-bs-target="#delete">
                        <i class="fe fe-trash-2"></i>
                        </a>
                    </div>
                </td>
            ';
           
            $data_arr [] = [
                "user_id"      => $record->user_id,
                "avatar"       => $avatar,
                "name"         => $record->name,
                "email"        => $record->email,
                "position"     => $record->position,
                "phone_number" => $record->phone_number,
                "join_date"    => $record->join_date,
                "status"       => $status, 
                "modify"       => $modify, 
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
}
