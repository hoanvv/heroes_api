@extends('back-end.layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

@section('content')
<section id="schedule-list">
    <div class="container-fluid">
        <h3>List Of Feedbacks</h3>
        <table id="list-categories" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Package Owner Comment</th>
                    <th>Trip Date</th>
                    <th>View Invoice</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0;?>
            @foreach($requestShips as $requestShip)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$requestShip->package_owner_comment}}</td>
                    <td>{{$requestShip->created_at}}</td>
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
                    <th>#</th>
                    <th>Comment</th>
                    <th>Trip Date</th>
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
