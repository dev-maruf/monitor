@extends('layouts.app')

@section('title', 'Home - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
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

        </div>
    </section>
@endsection