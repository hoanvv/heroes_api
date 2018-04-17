@extends('back-end.layouts.app')
@section('content')
<section id="schedule-list">
    <div class="container">
        <h3>List Of Schedules <a href="/admin/schedule/create">Add New</a></h3>
        <table id="list-categories" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Time</th>
                    <th>State</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($list as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ date('d/m/Y',strtotime($item->start_date)) }} - {{ date('d/m/Y',strtotime($item->end_date)) }}</td>
                    <td>
                        <a href="/admin/schedule/{{$item->id}}/update-state" class="submitUpdate" style="color: #4cae4c">
                            {{ $item->state == 0 ? 'Coming' : 'Closed' }}
                            <form class="update-schedule"
                                  action="/admin/schedule/{{$item->id}}/update-state"
                                  method="POST" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                            </form>
                        </a>
                    </td>
                    <td>
                        <button type="button" class='btn btn-warning btn-xs btn-show-profile' data-id="{{$id = $item->id}}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </button>
                        <a href="/admin/schedule/{{$id}}/edit" class='btn btn-success btn-xs'>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <button type="button" class='btn btn-danger btn-xs btn-delete' data-id="{{$id = $item->id}}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Time</th>
                    <th>State</th>
                    <th>Method</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal -->
    <div id="schedule-information" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Schedule Detail</h4>
                </div>
                <div class="modal-body row">
                    <div class="container">
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Title</label>
                            <div class="col-sm-10">
                                <p class="schedule-title"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Content</label>
                            <div class="col-sm-10">
                                <p class="schedule-content"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Start Date</label>
                            <div class="col-sm-10">
                                <p class="schedule-start-date"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">End Date</label>
                            <div class="col-sm-10">
                                <p class="schedule-end-date"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">State</label>
                            <div class="col-sm-10">
                                <p class="schedule-state"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">List of Staff</label>
                            <div class="col-sm-10">
                                <table class="table list-staff">
                                    <thead>
                                    <tr>
                                        <th class="col-sm-1 col-xs-1">#</th>
                                        <th class="col-sm-3 col-xs-3">Name</th>
                                        <th class="col-sm-3 col-xs-3">Phone</th>
                                        <th class="col-sm-3 col-xs-3">Position</th>
                                        <th class="col-sm-2 col-xs-2">Major</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">List of Vaccine</label>
                            <div class="col-sm-10">
                                <table class="table list-vaccine">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class='btn btn-danger btn-xs' data-dismiss="modal" >
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div id="delete-schedule" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="/admin/schedule">
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Schedule</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                            Are you sure?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class='btn btn-danger'>Delete</button>
                        <button type="button" class='btn btn-default' data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
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

@section('script')
    <script>
        $(function(){
            $('.submitUpdate').click(function(){
                event.preventDefault();
                if(window.confirm('Are you sure?')) {
                    $(this).find('.update-schedule').submit();
                }
            });
        });
    </script>
@endsection