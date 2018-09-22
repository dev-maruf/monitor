@extends('layouts.app')

@section('title', 'Log Viewer')

@section('css')
<link href="/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- <div class="block-header">
                <h2>Data Log In Viewer</h2>
            </div>      -->       
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Log Viewer [{{\Carbon\Carbon::parse($date)->format('d F Y')}}]</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>                                            
                                            <th>Time</th>
                                            <th>R Current</th>
                                            <th>S Current</th>
                                            <th>T Current</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Time</th>
                                            <th>R Current</th>
                                            <th>S Current</th>
                                            <th>T Current</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach(App\Device::where('key', $key)->first()->data()->whereDate('time', date($date))->orderBy('time', 'desc')->take(90000)->get() as $data)
                                        <tr>                                            
                                            <td>{{$data['time']}}</td>
                                            <td>{{$data['r']}}</td>
                                            <td>{{$data['s']}}</td>
                                            <td>{{$data['t']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
@endsection

@section('js')
<script src="/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script src="/js/pages/tables/jquery-datatable.js"></script>
@endsection