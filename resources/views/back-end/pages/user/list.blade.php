@extends('back-end.layouts.app')
@section('content')
<section id="user-list">
    <div class="container">
        <h3>List Of Users <a href="/admin/user/create">Add New</a></h3>
        <table id="list-users" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Position</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($list as $item)
                @php
                    switch($item->gender) {
                        case(0);
                        $item->gender = "Male";
                        break;
                        case(1);
                        $item->gender = "Female";
                        break;
                        case(2);
                        $item->gender = "Other";
                        break;
                    }
                @endphp
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->gender }}</td>
                    <td>{{ $item->is_admin ? 'Admin' : 'Normal User' }}</td>
                    <td>{{ $item->position }}</td>
                    <td>
                        <button type="button" class='btn btn-warning btn-xs btn-show-profile' data-id="{{$id = $item->id}}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </button>
                        <a href="/admin/user/{{$id}}/edit" class='btn btn-success btn-xs'>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Position</th>
                    <th>Method</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal -->
    <div id="user-profile" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Profile Information</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-sm-5">
                        <img src="" class="profile-avatar" style="width: 100%; border: 3px darkgray solid" />
                    </div>

                    <div class="col-sm-7">
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Name</label>
                            <div class="col-sm-9">
                                <p class="user-name"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Email</label>
                            <div class="col-sm-9">
                                <p class="user-email"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Role</label>
                            <div class="col-sm-9">
                                <p class="user-role"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Gender</label>
                            <div class="col-sm-9">
                                <p class="user-gender"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Birthday</label>
                            <div class="col-sm-9">
                                <p class="user-birthday"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Address</label>
                            <div class="col-sm-9">
                                <p class="user-address"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Phone</label>
                            <div class="col-sm-9">
                                <p class="user-phone"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Identity Card</label>
                            <div class="col-sm-9">
                                <p class="user-idcard"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Position</label>
                            <div class="col-sm-9">
                                <p class="user-position"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Major</label>
                            <div class="col-sm-9">
                                <p class="user-major"></p>
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
    <div id="delete-user" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="/admin/user">
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

