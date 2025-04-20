@extends('layouts.layouts.dashboard_layout')
@section('body-area')
<title>Dashboard</title>

<div class="content container-fluid">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                        <h3 class="page-title">Welcome {{ auth()->user()->name }}!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
            
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                                <div class="dash-widget-info">
                                     <h3>{{ $concessionCount }}</h3>
                                    <span>Concessions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                                <div class="dash-widget-info">
                                <h3>{{ number_format($totalIncome ?? 0) }}</h3>
                                    <span>Total Income</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                                <div class="dash-widget-info">
                                <h3>{{ $totalOrders ?? 0 }}</h3>
                                    <span>Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                <h3>{{ $totalUsers ?? 0 }}</h3>
                                    <span>Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Total Income</h3>
                                        <div id="bar-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Orders Overview</h3>
                                        <div id="line-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
</div>


@endsection