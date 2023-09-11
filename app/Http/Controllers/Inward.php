<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inward as Inwards;
use Illuminate\Support\Facades\DB;
use App\Models\Items;

class Inward extends Controller
{

    public function showInwardForm(){

        $suppliers = DB::select('select * from supplier');
        return view('inward',['suppliers'=>$suppliers]);
    }

    public function addInward(Request $request){

       $request->validate(
            [
                'txt_supplier_code' => 'required',
                'txt_item_code' => 'required',
                'txt_item_qty' => 'required'
            ]
        );
        $inward = new Inwards;
        $time = date('Y-m-d H:i:s');
        foreach($request->input('txt_item_code') as $k=>$v){
            $inward->item_code = $v;
            $result = DB::insert('insert into inwards (item_code,supplier_code,item_qty,created_at,updated_at) values (?,?,?,?,?)', [$v,$request->txt_supplier_code[0],$request->txt_item_qty,$time,$time]);
        }
        return redirect()->back()->with('message','Inward added...!');

    }

    public function loadInwardList(){
        $records = DB::table('inwards')
            ->join('items', 'inwards.item_code', '=', 'items.item_code')
            ->join('supplier', 'inwards.supplier_code', '=', 'supplier.supplier_code')
            ->select('items.unit','supplier.supplier_name','inwards.id','inwards.item_code','inwards.item_qty','inwards.created_at', 'items.item_name','items.item_price')
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

    public function loadEditRecord(Request $request){
        if($request->ajax()){
            $result = DB::table('inwards')->where('id', $request->input('id'))->first();
            echo json_encode($result);
        }
    }

    public function updateInward(Request $request){
            $result = DB::update('update inwards set item_qty = ? where id = ?', [$request->input('txt_up_item_qty'),$request->input('hid_rec_id')]);
            return redirect()->back()->with('message','Inward updated...!');
    }

    public function deleteInward(Request $request){
        DB::delete("Delete FROM inwards where id=?",[$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }

    public function getItemsSupplierBase(Request $request){

        if($request->ajax()){

            $supplier_list = $request->input('supplier');
            if(!empty($supplier_list)) {

                $supplier ="'" . implode ( "', '", $supplier_list) . "'";
                $list = DB::select(
                        DB::raw("SELECT IT.item_code,IT.item_name,CASE WHEN O.outQty IS NOT NULL THEN (i.inQty-O.outQty) ELSE i.inQty END as balance FROM items as IT
                        INNER JOIN ( SELECT item_code,sum(item_qty) as inQty FROM `inwards` group by item_code ) i
                        ON i.item_code=IT.item_code
                        LEFT JOIN( SELECT item_code,sum(item_qty) as outQty FROM `outward` group by item_code ) AS O ON O.item_code=IT.item_code
                        WHERE IT.supplier_code IN(".$supplier.")
                        ")
                    );
                echo json_encode($list);
            }

        }
    }
}

