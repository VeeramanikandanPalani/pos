<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Outward extends Controller
{

    public function showOutwardForm(){
        $suppliers = DB::select('select * from supplier');
        $customers = DB::select('select * from customer');
        return view('outward',['suppliers'=>$suppliers,'customers'=>$customers]);
    }

    public function addOutward(Request $request){


        $request->validate(
            [
                'txt_supplier_code' => 'required',
                'txt_item_code' => 'required',
                'txt_item_qty' => 'required',
                'txt_customer_code' => 'required'
            ]
        );
        $time = date('Y-m-d H:i:s');
        $customerList = $request->input('txt_customer_code');
        $cus_code = $customerList['0'];

        foreach($request->input('txt_supplier_code') as $sk=>$sv){
            foreach($request->input('txt_item_code') as $k=>$v){
                DB::insert('insert into outward (supplier_code,item_code,item_qty,customer_code,created_at,updated_at) values (?,?,?,?,?,?)', [$sv,$v,$request->txt_item_qty,$cus_code,$time,$time]);
            }
        }
        return redirect()->back()->with('message','Outward added...!');
    }
    public function loadOutwardList(){
        $records = DB::table('outward')
            ->join('items', 'outward.item_code', '=', 'items.item_code')
            ->join('supplier', 'outward.supplier_code', '=', 'supplier.supplier_code')
            ->select('items.unit','supplier.supplier_name','outward.id','outward.item_code','outward.item_qty','outward.created_at', 'items.item_name','items.item_price')
            ->orderBy('id', 'asc')
            ->get();
        $data =[];
        foreach($records as $k=>$v){
            $arr =[];
            $arr[] = $v->id;
            $arr[] = $v->supplier_name;
            $arr[] = $v->item_code;
            $arr[] = $v->item_name;
            $arr[] = $v->item_qty.$v->unit;
            $arr[] = '₹'.$v->item_price;
            $arr[] = '₹'.$v->item_qty * $v->item_price;
            $arr[] = $v->created_at;
            $arr[] = "<i data-edit_id=".$v->id." class='btn btn_edit fa-solid fa-pen-to-square' data-toggle='modal' data-target='.bd-example-modal-lg'></i>";
            $arr[] = "<i data-delete_id=".$v->id." class='btn fa-solid fa-trash-can btn_delete'></i>";
            $data[] = $arr;
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }
    // public function editOutward(){

    // }

    public function loadOneOutward(Request $request){
        if($request->ajax()){
            $result = DB::table('outward')->where('id', $request->input('id'))->first();
            echo json_encode($result);
        }
    }

    public function updateOutward(Request $request){
        $result = DB::update('update outward set item_qty = ? where id = ?', [$request->input('txt_up_item_qty'),$request->input('hid_rec_id')]);
        return redirect()->back()->with('message','Outward updated...!');
    }

    public function deleteOutward(Request $request){
        DB::delete("Delete FROM outward where id=?",[$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }
}
