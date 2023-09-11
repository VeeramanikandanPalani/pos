<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Items extends Controller
{
    public function addItems(){
        $items  = DB::table('items')->max('item_code');
        $suppliers = DB::select('select * from supplier');
        $str = preg_replace("/[^0-9]/", "", $items );

        $num_padded = ($str) ? sprintf("%03d", $str+1) : sprintf("%03d", 1) ;

        return view('addItems',['sno'=> $num_padded,'suppliers'=>$suppliers]);
    }

    public function insertItems(Request $request){

        $time = date('Y-m-d H:i:s');
        $isExist = DB::select('select item_code from items where item_code = ?', [$request->txt_item_code]);
        if(empty($isExist)) {
            $result = DB::insert('insert into items (item_code,item_name,unit,item_price,item_gst,created_at,updated_at,supplier_code) values (?,?,?,?,?,?,?,?)', [$request->txt_item_code, $request->txt_item_name,$request->txt_item_unit,$request->txt_item_rate,$request->txt_item_gst,$time,$time,$request->txt_supplier_code[0]]);
            $message = "Item added...!";
        }else{
            $message = "Item already exist...!";
        }
        return redirect()->back()->with('message', $message);
    }

    public function loadItemsList(){

        $posts = DB::table('items')
                ->join('supplier', 'items.supplier_code', '=', 'supplier.supplier_code')
                ->select('items.unit','items.id','items.item_code','items.item_name','items.item_price','items.item_gst','items.created_at','supplier.supplier_name')
                ->orderBy('id', 'asc')
                ->get();
        $data =[];
        foreach($posts as $k=>$v){
            $arr =[];
            $arr[] = $v->id;
            $arr[] = $v->supplier_name;
            $arr[] = $v->item_code;
            $arr[] = $v->item_name;
            $arr[] = '₹'.$v->item_price;
            $arr[] = $v->unit;
            $arr[] = $v->item_gst.'%';
            $arr[] = "<i data-edit_id=".$v->id." class='btn btn_edit fa-solid fa-pen-to-square' data-toggle='modal' data-target='.bd-example-modal-lg'></i>";
            $arr[] = "<i data-delete_id=".$v->id." class='btn fa-solid fa-trash-can btn_delete'></i>";
            $data[] = $arr;
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }

    public function loadEditItem(Request $request){
        if($request->ajax()){
            $result = DB::table('items')->where('id', $request->input('id'))->first();
            echo json_encode($result);
        }
    }
    public function updateItem(Request $request){
        $result = DB::update('update items set item_price = ?,item_gst= ?,unit=? where id = ?', [$request->input('txt_up_item_rate'),$request->input('txt_up_gst'),$request->input('txt_up_item_unit'),$request->input('hid_rec_id')]);
        return redirect()->back()->with('message','Item updated...!');
    }

    public function deleteItems(Request $request){
        DB::delete("Delete FROM items where id=?",[$request->input('id')]);
        $output = ['data'=>'success'];
        echo json_encode($output);
    }
}
