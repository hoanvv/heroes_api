@extends('back-end.layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
{{--{{dd($requestShips)}}--}}
@section('content')
<section id="schedule-list">
    <div class="container-fluid">
        <h3>List Of Delivery Request</h3>
        <table id="list-categories" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Trip Date</th>
                    <th>Package Owner</th>
                    <th>Shipper</th>
                    <th>Fare</th>
                    <th>Package Type</th>
                    <th>View Invoice</th>
                </tr>
            </thead>
            <tbody>
            @foreach($requestShips as $requestShip)
                <tr>
                    <td>{{$requestShip->id}}</td>
                    <td>{{$requestShip->status}}</td>
                    <td>{{$requestShip->pickup_location_address}} -> {{$requestShip->destination_address}}</td>
                    <td>{{$requestShip->created_at}}</td>
                    <td>{{$requestShip->first_name}} {{$requestShip->last_name}}</td>
                    <td>{{$requestShip->shipper_id}}</td>
                    <td>{{$requestShip->price}}</td>
                    <td>{{$requestShip->name}}</td>
                    <td><button class="btn btn-primary"><i class="icon-th-list icon-white"><b>View Invoice</b></i></button></td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Trip Date</th>
                    <th>Package Owner</th>
                    <th>Shipper</th>
                    <th>Fare</th>
                    <th>Package Type</th>
                    <th>View Invoice</th>
                </tr>
            </tfoot>
        </table>
    </div>

</section>
@if (session()->has('message_success'))
    @include('back-end.element.message',
        ['flash' => session('message_success'),
        'alert_color' => 'alert-success'
    ])
@elseif (session()->has('message_error'))
    @include('back-end.element.message', [
        'flash' => session('message_error'),
        'alert_color' => 'alert-danger'
    ])
@endif
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
@endsection