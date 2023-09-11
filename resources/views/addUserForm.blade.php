
@extends('layouts.layout')
@section('title','User')


@section('body-content')
<section class="body-content">
    <div class="container  mt-3">
        @if ($errors->any())
        <ul>
            {!! implode('',$errors->all('<li>:message</li>')) !!}
        @endif
        <h6 class="text-left mt-2 mb-3"><b>Add User</b></h6>
        <div class="d-flex justify-content-center align-items-center ">
                        <div class="row filter_form col-8 border border-1">
                        <form name="frmUser" id="frmUser" method="post" action="addNewUser" class="form-inline">
                        <div class="form-group p-2 mb-2">
                            <label for="item_code" class="font-weight-bold">Email-ID</label>
                            <input type="email" class="form-control-sm w-100" id="txt_user_email" name="txt_user_email" >
                        </div>
                        <div class="form-group p-2 mb-2">
                            <label for="item_code" class="font-weight-bold">Password</label>
                            <input type="password" class="form-control-sm w-100" id="txt_password" name="txt_password">
                        </div>
                        <div class="form-group  p-2 mt-4">
                            <button type="submit" name="btn_submit" class="btn btn-sm btn-success gee_button mb-2" id="btn_submit">Add</button>
                        </div>
                        @csrf
                    </form>
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
        </div>
    </div>
    <div class="container-fluid">
        <span class="badge badge-pill badge-primary p-2 mb-3"><b>User List</b></span>
        <div class="row">
            <div class="col-12 border border-1">
                <table class="table table-bordered display compact mt-1" id="users_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Created On</th>
                            <th>Status</th>
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
            <form name="frmUserUpdate" id="frmUserUpdate" method="post" action="updateUser">
                    <div class="row p-2">
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Email</label>
                                <input type="text" class="form-control w-100" id="txt_up_mail" name="txt_up_mail">
                        </div>
                        <div class="col form-group">
                            <label for="up_item_qty" class="font-weight-bold">Status</label>
                            <select class="form-control w-100" id="sel_status" name="sel_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col form-group mt-4">

                            <input type="hidden" id="hid_rec_id" name="hid_rec_id">
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



    $('#users_table').DataTable({
        "dom": 'Bfrltip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "scrollX":true,
        "ajax":{
            "url" :"/loadUserList",
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
                url: "/deleteUser",
                "data": {
                    "_token": "{{ csrf_token() }}",
                    "id":dataId
                 },
                success: function (response) {
                    var resp = JSON.parse(response);
                    if(resp.data =='success'){
                        alert("Record Deleted Successfully...!");
                        $('#users_table').DataTable().ajax.reload();
                    }
                }
            });
    });

    $(document).on('click','.btn_edit',function(){
        var dataId = $(this).attr("data-edit_id");
        $.ajax({
            type: "post",
            url: "/loadEditUser",
            "data": {
                "_token": "{{ csrf_token() }}",
                "id":dataId
                },
            success: function (response) {
                var resp = JSON.parse(response);
                $('#txt_up_mail').val(resp.email);
                $('#sel_status').val(resp.status);
                $('#hid_rec_id').val(resp.id);
            }
        });
    });

});
</script>
@endsection
