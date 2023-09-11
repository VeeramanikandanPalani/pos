<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    public function showUserForm(){
        return view('addUserForm');
    }
    public function addNewUser(Request $request){
        $request->validate(
            [
                'txt_user_email' =>'required',
                'txt_password' =>'required'
            ]
        );

        $user = new UserInfo;
        $user->email = $request->input('txt_user_email');
        $user->password = Hash::make($request->input('txt_password'));
        $user->status = 1;
        $user->save();
        return redirect()->back()->with('message', 'User added successfully...!');
    }
    public function loadUserList(){

        $posts = DB::select('select * from users');
        $data =[];
        foreach($posts as $k=>$v){
            $arr =[];
            $arr[] = $v->id;
            $arr[] = $v->email;
            $arr[] = '******************';
            $arr[] = $v->created_at;
            $arr[] = ($v->status==1) ? 'Active' : 'Inactive';
            $arr[] = "<i data-edit_id=".$v->id." class='btn btn_edit fa-solid fa-pen-to-square' data-toggle='modal' data-target='.bd-example-modal-lg'></i>";
            $arr[] = "<i data-delete_id=".$v->id." class='btn fa-solid fa-trash-can btn_delete'></i>";
            $data[] = $arr;
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }
    public function loadEditUser(Request $request){
        if($request->ajax()){
            $result = DB::table('users')->where('id', $request->input('id'))->first();
            echo json_encode($result);
        }
    }
    public function updateUser(Request $request){
        $password = Hash::make($request->input('txt_up_pasword'));

        $result = DB::update('update users set email = ?,status= ? where id = ?', [$request->input('txt_up_mail'),$request->input('sel_status'),$request->input('hid_rec_id')]);

        return redirect()->back()->with('message','User updated...!');
    }

    public function deleteUser(Request $request){

        DB::delete("Delete FROM users where id=?",[$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }
}
