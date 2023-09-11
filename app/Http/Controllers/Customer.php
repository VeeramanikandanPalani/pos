<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Customer extends Controller
{
    public function showCustomerForm(){
        $items  = DB::table('customer')->max('customer_code');
        $str = preg_replace("/[^0-9]/", "", $items );
        $num_padded = ($str) ? sprintf("%03d", $str+1) : sprintf("%03d", 1) ;
        return view('customer',['sno'=> $num_padded]);
    }

    public function addCustomer(Request $request)
    {
        $time = date('Y-m-d H:i:s');
        $isExist = DB::select('select customer_code from customer where customer_code = ? AND status=?', [$request->txt_customer_code,'0']);
        if(empty($isExist)) {
            DB::insert('insert into customer (customer_code, customer_name,customer_contact,customer_email,customer_address,created_at,updated_at,status) values (?, ?,?,?,?,?,?,?)',
            [$request->txt_customer_code,$request->txt_customer_name,$request->txt_contact,$request->txt_email,$request->txt_address,$time,$time,'0']);
            $message = "Customer added..!";
        }else{
            $message = "Customer already exist...!";
        }
        return redirect()->back()->with('message', $message);
    }
    public function loadCustomerList(){
        $posts = DB::table('customer')
                ->where('status','0')
                ->orderBy('id', 'asc')
                ->get();
        $data =[];
        foreach($posts as $k=>$v){
            $arr =[];
            $arr[] = $v->id;
            $arr[] = $v->customer_code;
            $arr[] = $v->customer_name;
            $arr[] = $v->customer_contact;
            $arr[] = $v->customer_email;
            $arr[] = $v->customer_address;
            $arr[] = "<i data-edit_id=".$v->id." class='btn btn_edit fa-solid fa-pen-to-square' data-toggle='modal' data-target='.bd-example-modal-lg'></i>";
            $arr[] = "<i data-delete_id=".$v->id." class='btn fa-solid fa-trash-can btn_delete'></i>";
            $data[] = $arr;
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }
    public function loadEditCustomer(Request $request){
        if($request->ajax()){
            $result = DB::table('customer')
                    ->where('id', $request->input('id'))
                    ->where('status', '0')
                    ->first();
            echo json_encode($result);
        }
    }
    public function updateCustomer(Request $request){

        $cus_name = $request->input('txt_up_customer_name');
        $cus_phone = $request->input('txt_up_customer_phone');
        $cus_email = $request->input('txt_up_customer_email');
        $cus_addr = $request->input('txt_up_customer_addr');
        $result = DB::update("update customer set customer_name = ?,customer_contact= ?,customer_email=?,customer_address=? where id = ?",
        [$cus_name,$cus_phone,$cus_email,$cus_addr,$request->input('hid_rec_id')]);
        return redirect()->back()->with('message','customer Details Updated...!');
    }
    public function deleteCustomer(Request $request){
        DB::update('update customer set status = 1 where id = ?', [$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }
}
