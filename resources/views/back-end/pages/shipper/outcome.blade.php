@extends('back-end.layouts.app')
@section('content')
    <div class="title-block">
        <h3 class="title"> Outcome
            <a href="#" onclick="javascript:window.top.close();" style="font-size: 13px;color: red;">Close</a>
        </h3>
    </div>
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-12 col-xl-12 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title"> Personal Information </h4>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-3">
                                @if($shipper->avatar)
                                    <img
                                        class="profile-avatar"
                                        style="width:100%; border: 1px solid darkgray; "
                                        src="{{ url("storage/{$shipper->avatar}") }}"
                                    />
                                @else
                                    <i
                                        style="width:100%; border: 1px solid darkgray; font-size: 17em; text-align: center"
                                        class="fa fa-user-circle-o"
                                        aria-hidden="true"
                                        class="profile-avatar"
                                    >

                                    </i>
                                @endif
                            </div>
                            <div class="col-sm-9">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>First Name: </td>
                                            <td>{{$shipper->user->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Last Name: </td>
                                            <td>{{$shipper->user->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email: </td>
                                            <td>{{$shipper->user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone: </td>
                                            <td>{{$shipper->user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Identity card: </td>
                                            <td>{{$shipper->identity_card}}</td>
                                        </tr>
                                        <tr>
                                            <td>Rating: </td>
                                            <td>{{$shipper->rating}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type: </td>
                                            <td>{{$shipper->is_default ? "Default Shipper" : "Normal Shipper"}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-6 col-md-6 col-xl-6 history-col">
                <div class="card sameheight-item dashboard-page">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title">Stats</h4>
                        </div>
                    </div>
                    <div class="card-block stats">
                        <div class="row row-sm stats-container">
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> {{$totalDeliveredOrder}} </div>
                                    <div class="name"> Total delivered orders </div>
                                </div>

                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> {{$totalCancelledOrder}} </div>
                                    <div class="name"> Cancelled order </div>
                                </div>

                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> {{$totalIncome}} VND</div>
                                    <div class="name"> Total income </div>
                                </div>

                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> {{$dailyIncome}} VND</div>
                                    <div class="name"> daily income </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-6 col-md-6 col-xl-6 history-col">
                <div class="card sameheight-item">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title">Income</h4>
                            <p class="title-description">
                                From: {{date( 'Y-m-d', strtotime( 'monday this week' ) )}} --- To: {{date( 'Y-m-d', strtotime( 'next monday' ) )}}
                            </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Total Income:</td>
                                    <td>{{$weeklyIncome}} VND</td>
                                </tr>
                                <tr>
                                    <td>Total Driver Payment: </td>
                                    <td>{{$weeklyIncome * 0.15}} VND</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
