@extends('layouts.app')

@section('title', 'Device Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Device Manager</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">router</i>
                        </div>
                        <div class="content">
                            <div class="text">Device</div>
                            <div class="number count-to" data-from="0" data-to="{{Auth::user()->device()->count()}}" data-speed="10" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                       
            <div class="row clearfix">
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <div class="card"> 
                        <div class="header">
                            <h2>
                                ADD NEW DEVICE
                            </h2>
                        </div>                       
                        <div class="body">
                            <form method="POST" action="{{route('device.add')}}" id="device-form">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="device-name" name="name" required>
                                                <label class="form-label">Device Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="device-key" name="key" required>
                                                <label class="form-label">Device Key</label>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="submit" id="btn-form" class="btn btn-success btn-lg m-l-15 waves-effect">ADD</button>
                                        <button onclick="switchAdd()" type="button" id="btn-cancel" class="btn btn-warning btn-lg m-l-15 waves-effect">CANCEL</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>List</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Key</th>
                                            <th>View</th>                                            
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->device as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>{{ $data['key'] }}</td>                                            
                                            <td>
                                                <button onclick="window.location.href='{{route('log', ['key'=>$data['key']])}}'" class="btn btn-success waves-effect">LOG</button>
                                                <button onclick="window.location.href='{{route('show.graph', ['key'=>$data['key']])}}'" class="btn btn-info waves-effect">GRAPH</button>
                                            </td>
                                            <td>                                                                                                
                                                <button onclick="switchEdit({{$data['id']}}, '{{$data['name']}}', '{{$data['key']}}')" class="btn btn-warning waves-effect">Edit</button>
                                                <button onclick="deleteDevice({{$data['id']}})" class="btn btn-danger waves-effect">Delete</button>
                                            </td>                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->                
            </div>
        </div>
    </section>
@endsection

@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#btn-cancel').hide();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });    
    
    function deleteDevice($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
            $.ajax({
                type:'POST',
                url:'{{route('device.delete')}}',
                data:{
                    id: $id
                },
                success:function(data){
                    location.reload();
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    var err = JSON.parse(jqXHR.responseText);
                    alert(err.error);
                    // handleError(errorThrown);
                }
            });
        }
    }

    function switchEdit($id, $name, $key){
        console.log($id);
        console.log($name);        
        $('#btn-form').html('UPDATE');
        $('#btn-cancel').show();
        $('#update-id').remove();
        $("<input type='hidden' />")
            .attr("value", $id)
            .attr("name", "id")
            .attr("id", "update-id")
            .prependTo("#device-form");        
        $('#device-name').val($name);
        $('#device-key').val($key);
        $('.form-line').addClass("focused");
        $('#device-form').attr('action', "{{route('device.edit')}}");        
        $('html, body').animate({
            scrollTop: $(".block-header").offset().top
        }, 1000);
    }

    function switchAdd(){
        $('#btn-cancel').hide();
        $('#update-id').remove();
        $('#btn-form').html('ADD');
        $('#device-name').val("");
        $('#device-key').val("");
        $('.form-line').removeClass("focused");
        $('#device-form').attr('action', "{{route('device.add')}}");
    }
</script>
@endsection