@extends('layouts.layout')
@section('title','Customer')


@section('body-content')
<section class="body-content">
    <div class="container  mt-3">
        @if ($errors->any())
        <ul>
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        @endif
        <div class=" d-flex  justify-content-center">
            <div class="col-5 filter_form border border-1">
            <form name="frmCustomers" id="frmCustomers" method="post" action="addCustomer">
                <div class="form-group mb-2">
                    <label for="item_code" class="font-weight-bold">Customer Code</label>
                    <input type="text" class="form-control-sm w-100" id="txt_customer_code" name="txt_customer_code" value="C{{$sno}}"" readonly >
                </div>
                <div class="form-group mb-2">
                    <label for="item_name" class="font-weight-bold">Customer Name</label>
                    <input type="text" class="form-control-sm w-100" id="txt_customer_name" name="txt_customer_name">
                </div>
                <div class="form-group mb-2">
                    <label for="item_name" class="font-weight-bold">Contact</label>
                    <input type="text" class="form-control-sm w-100" id="txt_contact" name="txt_contact">
                </div>
                <div class="form-group mb-2">
                    <label for="item_name" class="font-weight-bold">Email</label>
                    <input type="text" class="form-control-sm w-100" id="txt_email" name="txt_email">
                </div>
                <div class="form-group mb-2">
                    <label for="item_name" class="font-weight-bold">Address</label>
                    <textarea class="form-control w-100" id="txt_address" name="txt_address" rows="3" cols="30"></textarea>
                </div>
                <button type="submit" name="btn_submit" class="btn btn-success gee_button mb-2 text-right" id="btn_submit">Add</button>
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
    <div class="container-fluid">
        <span class="badge badge-primary  badge-pill p-2 mb-3"><b>Customer's List</b></span>
        <div class="row">
            <div class="col-12 border border-1">
                <table class="table table-bordered display compact mt-1" id="customers_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>customer Code</th>
                            <th>customer Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
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
            <form name="frmcustomerUpdate" id="frmcustomerUpdate" method="post" action={{"updateCustomer"}}>
                    <div class="row p-2 d-flex flex-column">
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Name</label>
                                <input type="text" class="form-control w-100" id="txt_up_customer_name" name="txt_up_customer_name">
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Phone</label>
                                <input type="text" class="form-control w-100" id="txt_up_customer_phone" name="txt_up_customer_phone">
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Email-ID</label>
                                <input type="text" class="form-control w-100" id="txt_up_customer_email" name="txt_up_customer_email">
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Address</label>
                                <input type="text" class="form-control w-100" id="txt_up_customer_addr" name="txt_up_customer_addr">
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


    $('#customers_table').DataTable({
        "dom": 'Bfrltip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "scrollX":true,
        "ajax":{
            "url" :"/loadCustomerList",
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
                url: "/deleteCustomer",
                "data": {
                    "_token": "{{ csrf_token() }}",
                    "id":dataId
                 },
                success: function (response) {
                    var resp = JSON.parse(response);
                    if(resp.data =='success'){
                        alert("customer deactivated successfully...!");
                        $('#customers_table').DataTable().ajax.reload();
                    }
                }
            });
    });

    $(document).on('click','.btn_edit',function(){
        var dataId = $(this).attr("data-edit_id");
        $.ajax({
            type: "post",
            url: "/loadEditCustomer",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id":dataId
                },
            success: function (response) {
                var resp = JSON.parse(response);
                $('#txt_up_customer_name').val(resp.customer_name);
                $('#txt_up_customer_phone').val(resp.customer_contact);
                $('#txt_up_customer_email').val(resp.customer_email);
                $('#txt_up_customer_addr').val(resp.customer_address);
                $('#hid_rec_id').val(resp.id);
            }
        });
    });

});
</script>
@endsection
