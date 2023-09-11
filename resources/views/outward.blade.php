@extends('layouts.layout')
@section('title','Outward')


@section('body-content')
<section class="body-content">
    <div class="container mt-2 ">
        <h6 class="text-center mt-2"><b>Add Outward</b></h6>
        @if ($errors->any())
        <ul>
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        </ul>
        @endif
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        <form name="frmInward" id="frmInward" method="post" action="addOutward">
            <div class="d-flex justify-content-center">
                <div class="row filter_form col-12 border border-1 mt-2">
                    <div class="col-3 form-group ">
                        <label for="item_code" class="font-weight-bold">Supplier Name</label>
                            <select id="suppliers_list" class="form-control" name="txt_supplier_code[]" multiple="multiple">
                                @foreach ($suppliers as $k=>$v)
                                    <option value={{ $v->supplier_code }}>{{$v->supplier_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-3 form-group ">
                        <label for="items_code" class="font-weight-bold">Item Name</label>
                            <select id="items_list" class="form-control" name="txt_item_code[]" multiple="multiple">
                            </select>
                    </div>
                    <div class="col-3 form-group">
                        <label for="item_code" class="font-weight-bold">Customer Name</label>
                            <select id="customers_list" class="form-control" name="txt_customer_code[]" multiple="multiple">
                                @foreach ($customers as $k=>$v)
                                    <option value={{ $v->customer_code }}>{{$v->customer_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col form-group">
                        <label for="item_qty" class="font-weight-bold">Quantity</label>
                            <input type="number" class="form-control " id="txt_item_qty" name="txt_item_qty">
                    </div>
                    <div class="col form-group mt-4">
                        <button type="submit" name="btn_submit" class="btn btn-success gee_button mt-2" id="btn_submit">Add</button>
                    </div>
                    @csrf
                </div>
            </div>
        </form>

    </div>

    <div class="container-fluid">
        <span class="badge badge-primary p-2  badge-pill mb-3"><b>Outward List</b></span>
        <div class="row">
            <div class="col-12 ml-2">
                <table class="table table-bordered display compact" id="inward_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Supplier</th>
                            <th>HSN Code</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Received On</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form name="frmInwardUpdate" id="frmOutwardUpdate" method="post" action="updateOutward">
                    <div class="row p-2">
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Quantity</label>
                                <input type="number" class="form-control w-100" id="txt_up_item_qty" name="txt_up_item_qty">
                                <input type="hidden" class="form-control w-100" id="hid_rec_id" name="hid_rec_id" value="">
                        </div>
                        <div class="col form-group mt-4">
                            <button type="submit" name="btn_update" class="btn btn-success gee_button mt-2" id="btn_update">Update</button>
                        </div>
                        @csrf
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<script>
$(document).ready(function () {

    $('#suppliers_list').multiselect({
        buttonWidth : '250px',
    });
    $('#items_list').multiselect({
        buttonWidth : '250px',
    });
    $('#customers_list').multiselect({
        buttonWidth : '250px',
    });
    $('#inward_table').DataTable({
        "dom": 'Bfrltip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ajax":{
            "url" :"/loadOutwardList",
            "type" : "post",
            "data": {
            "_token": "{{ csrf_token() }}",
            }
        }
    });


    $(document).on('change','#suppliers_list',function(){
        var list = $('#suppliers_list').val();
        $.ajax({
            type: "post",
            url: "getItemsSupplierBase",
            "data": {
                "_token": "{{ csrf_token() }}",
                "supplier":list
             },
            "success": function (response) {
                var tt = JSON.parse(response);
                var data =[];
                $.each(tt, function(key, value) {
                     data.push({label:value.item_name+' - '+value.balance+ ' available ', value: value.item_code});
                });
                $("#items_list").multiselect('dataprovider', data);
            }
        });
    });


    $(document).on('click','.btn_delete',function(){
        var dataId = $(this).attr("data-delete_id");
        $.ajax({
            type: "post",
            url: "/deleteOutward",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id":dataId
                },
            success: function (response) {
                var resp = JSON.parse(response);
                if(resp.data =='success'){
                    alert("Record Deleted Successfully...!");
                    $('#inward_table').DataTable().ajax.reload();
                }
            }
        });
    });

    $(document).on('click','.btn_edit',function(){
        var dataId = $(this).attr("data-edit_id");
        $.ajax({
            type: "post",
            url: "/loadOneOutward",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id":dataId
                },
            success: function (response) {
                var resp = JSON.parse(response);
                $('#txt_up_item_qty').val(resp.item_qty);
                $('#hid_rec_id').val(resp.id);
            }
        });
    });



});
</script>
@endsection
