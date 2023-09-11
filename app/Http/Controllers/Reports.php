<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reports extends Controller
{
    public function showInwardReport(){
        $suppliers = DB::select('select * from supplier');
        return view('reports.inward_report',['suppliers'=>$suppliers]);
    }
    public function showOutwardReportForm(){
        $suppliers = DB::select('select * from supplier');
        return view('reports.outward_report',['suppliers'=>$suppliers]);
    }
    public function stockListForm(){
        return view('reports.stock_list');
    }
    public function showItemList(){
        return view('reports.item_list');
    }

    public function getPurchaseReport(Request $request){

        if($request->ajax()){

            $FromDate = ($request->input('from_date')) ? $request->input('from_date') : date('Y-m-d');
            $ToDate = ($request->input('to_date')) ? $request->input('to_date') : date('Y-m-d');
            $ItemList = "";
            $SupplierList = "";
            if($request->input('supplier')){
                $SupplierList = "AND iwd.supplier_code IN (". "'" . implode ( "', '", $request->input('supplier') ) . "'" .")";
            }
            if($request->input('item')){
                $SupplierList = "AND iwd.item_code IN (". "'" . implode ( "', '", $request->input('item') ) . "'" .")";
            }


            $list = DB::select(
                DB::raw("SELECT sp.supplier_name,iwd.id,iwd.item_code,sum(iwd.item_qty) AS item_qty,iwd.created_at,it.item_name,it.item_price
                    FROM inwards AS iwd
                    JOIN items AS it ON it.item_code = iwd.item_code
                    JOIN supplier AS sp ON sp.supplier_code = iwd.supplier_code
                    WHERE iwd.created_at BETWEEN '".$FromDate."' AND  '".$ToDate."'
                    ".$SupplierList."
                    ".$ItemList."
                    GROUP BY sp.supplier_name,iwd.id,iwd.item_code,iwd.item_qty,iwd.created_at,it.item_name,it.item_price
                    ORDER BY it.item_code DESC
                ")
            );
            $data =[];
            $i=1;
            foreach($list as $k=>$v){
                $arr =[];
                $arr[] = $i;
                $arr[] = $v->supplier_name;
                $arr[] = $v->item_code;
                $arr[] = $v->item_name;
                $arr[] = $v->item_qty;
                $arr[] = $v->created_at;
                $i++;
                $data[]=$arr;
            }
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }

    public function getOutwardReport(Request $request){

        if($request->ajax()){

            $FromDate = ($request->input('from_date')) ? $request->input('from_date') : date('Y-m-d');
            $ToDate = ($request->input('to_date')) ? $request->input('to_date') : date('Y-m-d');
            $ItemList = "";
            $SupplierList = "";
            if($request->input('supplier')){
                $SupplierList = "AND owd.supplier_code IN (". "'" . implode ( "', '", $request->input('supplier') ) . "'" .")";
            }
            if($request->input('item')){
                $SupplierList = "AND owd.item_code IN (". "'" . implode ( "', '", $request->input('item') ) . "'" .")";
            }


            $list = DB::select(
                DB::raw("SELECT sp.supplier_name,owd.id,owd.item_code,sum(owd.item_qty) AS item_qty,owd.created_at,it.item_name,it.item_price
                    FROM outward AS owd
                    JOIN items AS it ON it.item_code = owd.item_code
                    JOIN supplier AS sp ON sp.supplier_code = owd.supplier_code
                    WHERE owd.created_at BETWEEN '".$FromDate."' AND  '".$ToDate."'
                    ".$SupplierList."
                    ".$ItemList."
                    GROUP BY sp.supplier_name,owd.id,owd.item_code,owd.item_qty,owd.created_at,it.item_name,it.item_price
                    ORDER BY it.item_code DESC
                ")
            );
            $data =[];
            $i=1;
            foreach($list as $k=>$v){
                $arr =[];
                $arr[] = $i;
                $arr[] = $v->supplier_name;
                $arr[] = $v->item_code;
                $arr[] = $v->item_name;
                $arr[] = $v->item_qty;
                $arr[] = $v->created_at;
                $i++;
                $data[]=$arr;
            }
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }

    public function getItemList(Request $request){
        if($request->ajax()){
            $list = DB::select(
                DB::raw("select ti.item_code,ti.item_name,ti.unit,ti.item_price,sp.supplier_name
                        FROM items as ti
                        JOIN supplier as sp ON sp.supplier_code=ti.supplier_code
                        ORDER BY ti.item_name")
            );
            $data =[];
            $i=1;
            foreach($list as $k=>$v){
                $arr =[];
                $arr[] = $i;
                $arr[] = $v->item_code;
                $arr[] = $v->item_name;
                $arr[] = $v->unit;
                $arr[] = $v->item_price;
                $arr[] = $v->supplier_name;
                $i++;
                $data[]=$arr;
            }
            $output = ['data'=>$data];
            echo json_encode($output);
        }
    }

    public function stockReport(Request $request){

        if($request->ajax()){


            $list = DB::select(
                DB::raw("SELECT it.item_code,it.item_name,sum(iwd.item_qty) as ib,sum(owd.item_qty) as ob ,
                        CASE WHEN sum(iwd.item_qty) AND sum(owd.item_qty) >0 IS NOT NULL THEN (sum(iwd.item_qty)-sum(owd.item_qty)) ELSE sum(iwd.item_qty) END as balance
                        FROM items AS it
                        LEFT JOIN inwards as iwd ON iwd.item_code=it.item_code AND iwd.supplier_code=it.supplier_code
                        LEFT JOIN outward as owd ON owd.item_code=it.item_code AND owd.supplier_code=it.supplier_code
                        group by it.item_code,it.item_name")
            );
            $data =[];
            $i=1;
            foreach($list as $k=>$v){
                $arr =[];
                $arr[] = $i;
                $arr[] = $v->item_code;
                $arr[] = $v->item_name;
                $arr[] = (!$v->ib) ? '-'.$v->ob : $v->balance;
                $i++;
                $data[]=$arr;
            }
        }
        $output = ['data'=>$data];
        echo json_encode($output);
    }

    public function showChatForum(){
        return view('chat.chat');
    }
}
