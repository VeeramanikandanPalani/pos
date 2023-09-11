@extends('layouts.layout')
@section('title','Items')


@section('body-content')
<section class="body-content">
    <div class="container  mt-3">
        @if ($errors->any())
        <ul>
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        @endif
        <h6 class="text-left mt-2 mb-3"><b>Add Items</b></h6>
        <div class="d-flex justify-content-center">
            <div class="row border border-1">
                <div class="filter_form col-12">
                    <form name="frmInward" id="frmInward" method="post" action="insertItems" class="form-inline">
                        <div class="col-3 form-group mb-2 pull-left">
                            <label for="supplier_code" class="font-weight-bold">Supplier Name</label>
                            <select id="suppliers_list" class="form-control" name="txt_supplier_code[]"  multiple="multiple">
                                @foreach ($suppliers as $k=>$v)
                                    <option value={{ $v->supplier_code }}>{{$v->supplier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 form-group mb-2">
                            <label for="item_code" class="font-weight-bold">Item Code</label>
                            <input type="text" class="form-control-sm w-100" id="txt_item_code" name="txt_item_code" value="A{{$sno}}"" readonly>
                        </div>
                        <div class="col-2  form-group mb-2">
                        <label for="item_name" class="font-weight-bold">Item Name</label>
                            <input type="text" class="form-control-sm w-100" id="txt_item_name" name="txt_item_name">
                        </div>
                        <div class="col-1  form-group mb-2">
                        <label for="item_name" class="font-weight-bold">Price</label>
                            <input type="text" class="form-control-sm w-100" id="txt_item_rate" name="txt_item_rate">
                        </div>
                        <div class="col-2  form-group mb-2">
                        <label for="item_name" class="font-weight-bold">Unit</label>
                            <select class="form-control-sm w-100" id="txt_item_unit" name="txt_item_unit">
                                <option value="Kg" selected>Kg</option>
                                <option value="Nos">Nos</option>
                                <option value="Ml">Ml</option>
                            </select>
                        </div>
                        <div class="col-1  form-group mb-2">
                        <label for="item_name" class="font-weight-bold">GST %</label>
                            <input type="text" class="form-control-sm w-100" id="txt_item_gst" name="txt_item_gst">
                        </div>
                        <div class="col-1  form-group  mt-4">
                            <button type="submit" name="btn_submit" class="btn btn-success gee_button mb-2" id="btn_submit">Add</button>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <span class="badge badge-pill badge-primary p-2 my-3"><b>Goods List</b></span>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered display compact mt-1" id="items_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Supplier</th>
                            <th>Item Code</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>GST</th>
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
            <form name="frmItemUpdate" id="frmItemUpdate" method="post" action="updateItem">
                    <div class="row p-2">
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Price</label>
                                <input type="text" class="form-control w-100" id="txt_up_item_rate" name="txt_up_item_rate">
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Unit</label>
                            <select class="form-control w-100" id="txt_up_item_unit" name="txt_up_item_unit">
                                <option value="Kg">Kg</option>
                                <option value="Nos">Nos</option>
                                <option value="ml">Ml</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">GST</label>
                                <input type="number" class="form-control w-100" id="txt_up_gst" name="txt_up_gst">
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

    $('#items_table').DataTable({
        "dom": 'Bfrltip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "scrollX":true,
        "ajax":{
            "url" :"/loadItemsList",
            "type" : "post",
        "data": {
            "_token": "{{ csrf_token() }}",
        },
        }
    });

    $(document).on('click','.btn_delete',function(){
        var dataId = $(this).attr("data-delete_id");
        $.ajax({
                type: "post",
                url: "/deleteItems",
                "data": {
                    "_token": "{{ csrf_token() }}",
                    "id":dataId
                 },
                success: function (response) {
                    var resp = JSON.parse(response);
                    if(resp.data =='success'){
                        alert("Record Deleted Successfully...!");
                        $('#items_table').DataTable().ajax.reload();
                    }
                }
            });
    });

    $(document).on('click','.btn_edit',function(){
        var dataId = $(this).attr("data-edit_id");
        $.ajax({
            type: "post",
            url: "/loadEditItem",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id":dataId
                },
            success: function (response) {
                var resp = JSON.parse(response);
                $('#txt_up_item_rate').val(resp.item_price);
                $('#txt_up_gst').val(resp.item_gst);
                $('#txt_up_item_unit').val(resp.unit);

                $('#hid_rec_id').val(resp.id);
            }
        });
    });

});
</script>
@endsection
