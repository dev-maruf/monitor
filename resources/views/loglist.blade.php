@extends('layouts.app')

@section('title', 'Log Viewer')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$dev->name}}                            
                        </h2>                        
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DATE</th>
                                    <th>ACTION</th>    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dev->data()->orderBy('time', 'desc')->get()->groupBy(function($time){
                                    return \Carbon\Carbon::parse($time->time)->format('Y-m-d');
                                }) as $data)
                                <tr>
                                @php
                                $date = \Carbon\Carbon::parse($data[0]->time)->format('Y-m-d');
                                @endphp
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$date}}</td>
                                    <td><button onclick="window.location.href='{{route('log.detail', ['key'=>$dev['key'], 'date'=>$date])}}'" class="btn btn-success waves-effect">LOG</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endcontent