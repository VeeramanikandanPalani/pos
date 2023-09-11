@extends('layouts.layout')
@section('title','Item List')


@section('body-content')
<section class="body-content">
    <div class="container mt-2 ">
        <h6 class="text-center mt-2"><b>Material List</b></h6>
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

    </div>

    <div class="container-fluid">
        <span class="badge badge-primary p-2  badge-pill mb-3"><b>Material Report</b></span>
        <div class="row">
            <div class="col-12 ml-2">
                <table class="table table-bordered display compact" id="item_table" width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Item Unit</th>
                            <th>Item Price</th>
                            <th>Supplier Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}

</section>
<script>
$(document).ready(function () {


        $('#item_table').DataTable({
            "destroy": true,
            "dom": 'Bfrltip',
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax":{
                "url" :"/showItemListReport",
                "type" : "post",
                "data": {
                "_token": "{{ csrf_token() }}"
                }
            }
        });


});
</script>
@endsection
