@extends('layouts.layout')
@section('title','Outward')


@section('body-content')
<section class="body-content">
    <div class="container mt-2 ">
        <h6 class="text-center mt-2"><b>Outward Report</b></h6>
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
        <form name="frmOutwardReport" id="frmOutwardReport" method="post" action="showOutwardReportForm">
            <div class="d-flex justify-content-center">
                <div class="row filter_form col-12 border border-1 mt-2">
                    <div class="col form-group ">
                        <label for="supplier" class="font-weight-bold">Supplier Name</label>
                            <select id="suppliers_list" class="form-control" name="txt_supplier_code[]" multiple="multiple">
                                @foreach ($suppliers as $k=>$v)
                                    <option value={{ $v->supplier_code }}>{{$v->supplier_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col form-group ">
                        <label for="items_code" class="font-weight-bold">Item Name</label>
                            <select id="items_list" class="form-control" name="txt_item_code[]" multiple="multiple">

                            </select>
                    </div>
                    <div class="col-2 form-group mt-4">
                        <input type="date" name="dt_from" class="form-control mt-2" id="dt_from">
                    </div>
                    <div class="col-2 form-group mt-4">
                        <input type="date" name="dt_to" class="form-control mt-2" id="dt_to">
                    </div>
                    <div class="col form-group mt-4">
                        <button type="button" name="btn_submit" class="btn btn-success gee_button mt-2" id="btn_generate">Submit</button>
                    </div>
                    @csrf
                </div>
            </div>
        </form>

    </div>

    <div class="container-fluid">
        <span class="badge badge-primary p-2  badge-pill mb-3"><b>Outward Report</b></span>
        <div class="row">
            <div class="col-12 ml-2">
                <table class="table table-bordered display compact" id="inward_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Supplier</th>
                            <th>HSN Code</th>
                            <th>Item Name</th>
                            <th>Inward Qty</th>
                            <th>Received On</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



</section>
<script>
$(document).ready(function () {

    // var table = $('#inward_table').DataTable();

    $('#suppliers_list').multiselect({
        buttonWidth : '250px',
    });
    $('#items_list').multiselect({
        buttonWidth : '250px',
    });



    $(document).on('click','#btn_generate',function(){

        var from_date = $('#dt_from').val();
        var to_date = $('#dt_to').val();
        var supplier = $('#suppliers_list').val();
        var item = $('#items_list').val();

        $('#inward_table').DataTable({
            "destroy": true,
            "dom": 'Bfrltip',
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax":{
                "url" :"/OutwardReport",
                "type" : "post",
                "data": {
                "_token": "{{ csrf_token() }}",
                "from_date":from_date,
                "to_date":to_date,
                "supplier":supplier,
                "item":item
                }
            }
        });
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
            success: function (response) {
                var tt = JSON.parse(response);
                var data =[];
                $.each(tt, function(key, value) {
                     data.push({label:value.item_name+' - '+value.balance+ ' available ', value: value.item_code});
                });
                $("#items_list").multiselect('dataprovider', data);
            }
        });
    });

});
</script>
@endsection
