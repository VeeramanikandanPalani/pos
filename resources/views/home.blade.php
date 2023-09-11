@extends('layouts.layout')
@section('title','Home')


@section('body-content')
<section class="body-content">
    <h2 class="text-center mt-2">Inventory tacker</h2>
    <div class="container">
        <table class="table table-striped" id="tbl">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Veera</td>
                    <td>29</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>Geetha</td>
                    <td>29</td>
                    <td>30</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<script>
$(document).ready(function () {
    $('#tbl').DataTable();
});
</script>
@endsection
