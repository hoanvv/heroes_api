@extends('back-end.layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <style>
        .share-button {
            height: 35px;
            width: auto;
            position: relative;
        }
        .share-button ul {
            background: #ccc;
            color: #fff;
            width: auto;
            left: 0;
            list-style: outside none none;
            margin: 0 auto;
            padding: 0 8px;
            right: 0;
            height: auto;
            opacity: 0.9;
            border-radius: 15px;
            top: -20px;
        }
        .share-button ul li {
            box-sizing: content-box;
            cursor: pointer;
            height: 22px;
            margin: 0;
            padding: 8px 0 14px;
            text-align: center;
            transition: all 0.3s ease 0s;
            width: auto;
            z-index: 2;
        }
        .share-button .for-five.active {
            left: -35px;
            top: -11px;
        }
        .share-button .social.active {
            display: table;
            opacity: 1;
            transform: scale(1) translateY(-90px);
            transition: all 0.4s ease 0s;
            position: absolute;
            bottom: 0px;
            right: 75%;
            top: 100%;
        }
        .share-button .social {
            display: none;
        }
        .share-button ul::after {
            border-color: transparent transparent transparent #ccc;
            border-style: solid;
            border-width: 12px 0 14px 27px;
            content: "";
            display: block;
            height: 0;
            margin: 0 auto;
            position: absolute;
            right: -17px;
            top: 36%;
            width: 0;
            z-index: -1;
        }
    </style>
@endsection
@section('content')
<section id="user-list">
    <div class="container">
        <h3>List Of Users <a href="/admin/shipper/create">Add New</a></h3>
        <table id="list-users" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>View/Edit Document(s)</th>
                    <th>Outcome</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0;?>
            @foreach($shippers as $shipper)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$shipper->user->first_name}} {{$shipper->user->last_name}}</td>
                    <td>{{$shipper->user->email}}</td>
                    <td>{{$shipper->user->phone}}</td>
                    <td style="text-align: center">
                        <i class="fa fa-check-circle-o"
                           aria-hidden="true"
                           style="color:{{$shipper->is_online == 1 ? "#A2E070" : "#ccc"}}; font-size: 2em">
                        </i>
                    </td>
                    <td style="text-align: center">{{$shipper->is_default ? "Default" : "Normal"}}</td>
                    <td style="text-align: center">
                        <a href="shipper/{{$shipper->id}}/document" target="_blank" style="font-size: 2em"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a>
                    </td>
                    <td style="text-align: center">
                        <a href="shipper/{{$shipper->id}}/outcome" target="_blank" style="font-size: 2em">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td style="text-align: center">
                        <div class="share-button">
                            <span style="font-size: 2em"><i class="fa fa-cog" aria-hidden="true"></i></span>
                            <div class="social for-five">
                                <ul>
                                    <li class="entypo-1">
                                        <a href="shipper/{{$shipper->id}}/edit" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" style="color:#0b91ea; font-size: 2.2em"></i>
                                        </a>
                                    </li>
                                    @if($shipper->is_online != 1)
                                    <li class="entypo-2">
                                        <a href="shipper/{{$shipper->id}}/changeStatus" data-toggle="tooltip" title="Make online">
                                            <i class="fa fa-check-circle-o"
                                               aria-hidden="true"
                                               style="color:#59b50e; font-size: 2.2em">
                                            </i>
                                        </a>
                                    </li>
                                    @else
                                    <li class="entypo-3">
                                        <a href="shipper/{{$shipper->id}}/changeStatus" data-toggle="tooltip" title="Make offline">
                                            <i class="fa fa-check-circle-o"
                                               aria-hidden="true"
                                               style="color:#252020; font-size: 2.2em">
                                            </i>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="entypo-4">
                                        <a href="" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-trash" aria-hidden="true" style="color:red; font-size: 2.2em"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>View/Edit Document(s)</th>
                    <th>Outcome</th>
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
@section('scripts')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            
            $('.share-button').click(function () {
                if($(this).find('.social').hasClass('active')) {
                    $(this).find('.social').removeClass('active');
                } else {
                    if($('.share-button').find('.social').hasClass('active')) {
                        $('.share-button').find('.social').removeClass('active');
                    }
                    $(this).find('.social').addClass('active');
                }
            });
        });
    </script>
@endsection
