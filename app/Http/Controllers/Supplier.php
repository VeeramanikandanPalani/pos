<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class Supplier extends Controller
{
    public function showSupplierForm(){
        $items  = DB::table('supplier')->max('supplier_code');
        $str = preg_replace("/[^0-9]/", "", $items );
        $num_padded = ($str) ? sprintf("%03d", $str+1) : sprintf("%03d", 1) ;
        return view('supplier',['sno'=> $num_padded]);
    }

    public function addSuppiler(Request $request)
    {
        $time = date('Y-m-d H:i:s');
        $isExist = DB::select('select supplier_code from supplier where supplier_code = ? AND status=?', [$request->txt_supplier_code,'0']);
        if(empty($isExist)) {
            DB::insert('insert into supplier (supplier_code, supplier_name,supplier_contact,supplier_email,supplier_address,created_at,updated_at,status) values (?, ?,?,?,?,?,?,?)',
            [$request->txt_supplier_code,$request->txt_supplier_name,$request->txt_contact,$request->txt_email,$request->txt_address,$time,$time,'0']);
            $message = "Supplier added..!";
        }else{
            $message = "Supplier already exist...!";
        }
        return redirect()->back()->with('message', $message);
    }
    public function loadSupplierList(){
        $posts = DB::table('supplier')
                ->where('status','0')
                ->orderBy('id', 'asc')
                ->get();
        $data =[];
        foreach($posts as $k=>$v){
            $arr =[];
            $arr[] = $v->id;
            $arr[] = $v->supplier_code;
            $arr[] = $v->supplier_name;
            $arr[] = $v->supplier_contact;
            $arr[] = $v->supplier_email;
            $arr[] = $v->supplier_address;
            $arr[] = "<i data-edit_id=".$v->id." class='btn btn_edit fa-solid fa-pen-to-square' data-toggle='modal' data-target='.bd-example-modal-lg'></i>";
            $arr[] = "<i data-delete_id=".$v->id." class='btn fa-solid fa-trash-can btn_delete'></i>";
            $data[] = $arr;
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }
    public function loadEditSupplier(Request $request){
        if($request->ajax()){
            $result = DB::table('supplier')
                    ->where('id', $request->input('id'))
                    ->where('status', '0')
                    ->first();
            echo json_encode($result);
        }
    }
    public function updateSupplier(Request $request){

        $sup_name = $request->input('txt_up_supplier_name');
        $sup_phone = $request->input('txt_up_supplier_phone');
        $sup_email = $request->input('txt_up_supplier_email');
        $sup_addr = $request->input('txt_up_supplier_addr');
        $result = DB::update("update supplier set supplier_name = ?,supplier_contact= ?,supplier_email=?,supplier_address=? where id = ?",
        [$sup_name,$sup_phone,$sup_email,$sup_addr,$request->input('hid_rec_id')]);
        return redirect()->back()->with('message','Supplier Details Updated...!');
    }
    public function deleteSupplier(Request $request){
        // DB::delete("Delete FROM supplier where id=?",[$request->input('id')]);
        DB::update('update supplier set status = 1 where id = ?', [$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }
}
