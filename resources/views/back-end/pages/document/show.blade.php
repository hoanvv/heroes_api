@extends('back-end.layouts.app')
@section('content')
    <div class="title-block">
        <h3 class="title"> Document
            <a href="#" onclick="javascript:window.top.close();" style="font-size: 13px;color: red;">Close</a>
        </h3>
    </div>
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title"> Shipper Vehicle </h4>
                        </div>
                    </div>
                    <div class="card-block">

                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 history-col">
                <div class="card sameheight-item">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title">Shipper Driving License</h4>
                        </div>
                    </div>
                    <div class="card-block">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
