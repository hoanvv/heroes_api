@extends('back-end.layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

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
                    <td>
                        @switch($requestShip->status)
                            @case(0)
                            <span> Canceled</span>
                            @break

                            @case(1)
                            <span> Waiting</span>
                            @break

                            @case(2)
                            <span> Accepted</span>
                            @break

                            @case(3)
                            <span> Delivering</span>
                            @break

                            @case(4)
                            <a href="#" data-toggle="popover" title="Package Owner's Comment" data-content="{{$requestShip->package_owner_comment}}">Completed</a>
                            @break
                            @default
                            <span></span>
                        @endswitch
                    </td>
                    <td>{{$requestShip->pickup_location_address}} -> {{$requestShip->destination_address}}</td>
                    <td>{{$requestShip->created_at}}</td>
                    <td>{{$requestShip->first_name}} {{$requestShip->last_name}}</td>
                    <td>{{$requestShip->shipper_id ? \App\Entities\Shipper::find($requestShip->shipper_id)->user->first_name : ""}}</td>
                    <td>{{$requestShip->price}}</td>
                    <td>{{$requestShip->name}}</td>
                    <td>
                        <a class="btn btn-primary" href="delivery-request/{{$requestShip->id}}" target="_blank">
                            <i class="fa fa-list" aria-hidden="true">
                            </i> View Invoice</i>
                        </a>
                    </td>
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
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection
