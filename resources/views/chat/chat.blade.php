@extends('layouts.layout')
@section('title','Item List')


@section('body-content')
<section class="body-content">
    &nbsp;
    <style>
        .card {
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
          max-width: 300px;
          margin: auto;
          text-align: center;
          font-family: arial;
        }

        .title {
          color: grey;
          font-size: 18px;
        }

        button {
          border: none;
          outline: 0;
          display: inline-block;
          padding: 8px;
          color: white;
          background-color: #000;
          text-align: center;
          cursor: pointer;
          width: 100%;
          font-size: 18px;
        }

        button:hover, a:hover {
          opacity: 0.7;
        }
        </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2" style="min-height:700px;background-color:#ddeaf7;">
                <div class="card mt-2">
                    <img src="{{'img/team2.jpg'}}" alt="John" style="width:100%">
                    <h5 class="mt-2"><strong>VEERA</strong></h>
                    <p class="title">System Analyst</p>
                    <p>Hexaware Technologies</p>
                    <p><button>Contact</button></p>
                </div>
            </div>
            <div class="col-7 border border-left">
                <div class="form-group">
                    <textarea rows="5" cols="30" class="form-control mt-2" placeholder="Post Something"></textarea>
                </div>
                <div class="col-2"  style="position: relative">
                    <button type="button" name="btn-post" id="btn-post" class="btn btn-success btn-sm" style="position: absolute;left: 625px;">Post</button>
                </div>
            </div>
            <div class="col-3">
                <h5>Recent Activities</h5>
                <div class="card mb-1">
                    <div class="card-body ">
                        <h6 class="text-left text-sm">#SR32323</h6>
                        <p class="text-left h6">Ticket is has been updated</p>
                        <p class="text-left h6"><?php echo now();?></p>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body ">
                        <h6 class="text-left text-sm">#SR32323</h6>
                        <p class="text-left h6">Ticket is has been updated</p>
                        <p class="text-left h6"><?php echo now();?></p>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-body ">
                        <h6 class="text-left text-sm">#SR32323</h6>
                        <p class="text-left h6">Ticket is has been updated</p>
                        <p class="text-left h6"><?php echo now();?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
$(document).ready(function () {




});
</script>
@endsection
