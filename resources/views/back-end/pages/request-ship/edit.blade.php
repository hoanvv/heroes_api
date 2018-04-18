@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h2>Edit Schedule</h2>
        <div class="row">
            <div class="col-sm-5 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Schedule's Information</h3>
                    </div>

                    <form method="post" action="/admin/schedule/{{ $schedule->id }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">Title</label>
                            <input type="text" name="title" class="form-control boxed" value="{{ $schedule->title }}" placeholder="Annual vaccination">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="control-label">Content</label>
                            <textarea type="text" name="content" rows="10" class="form-control boxed">{{ $schedule->content }}</textarea>

                            @if ($errors->has('content'))
                                <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label class="control-label">Start date</label>
                            <input type="date" name="start_date" class="form-control boxed" value="{{$schedule->start_date}}">

                            @if ($errors->has('start_date'))
                                <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <label class="control-label">End date</label>
                            <input type="date" name="end_date" class="form-control boxed" value="{{ $schedule->end_date }}">

                            @if ($errors->has('end_date'))
                                <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="control-label">Address</label>
                            <input type="text" name="address" class="form-control boxed" value="{{ $schedule->address }}" placeholder="Hoa Khanh, Lien Chieu, Danang">

                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                            <label class="control-label">State</label>
                            {{
                                Form::select(
                                    'state',
                                    array('0' => 'Coming', '1' => 'Closed'),
                                    $schedule->state,
                                    ['class' => 'form-control boxed']
                                )
                            }}
                            @if ($errors->has('status'))
                                <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/schedule" class="btn btn-warning">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>

            </div>
            <div class="col-sm-7 col-xs-12" >
                <div class="card card-block sameheight-item" id="staff-list">
                    <div class="title-block">
                        <h3 class="title">List of Staff</h3>
                    </div>
                    <div class="form-group">
                        <table class="table list-staff">
                            <thead>
                            <tr>
                                <th class="col-sm-1 col-xs-1">#</th>
                                <th class="col-sm-3 col-xs-3">Name</th>
                                <th class="col-sm-4 col-xs-4">Phone</th>
                                <th class="col-sm-3 col-xs-3">Major</th>
                                <th class="col-sm-1 col-xs-1">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($staff)
                                <?php $i = 0; ?>
                                @foreach($staff as $item)
                                    <tr>
                                        <td class="col-sm-1 col-xs-1">{{ ++$i }}</td>
                                        <td class="col-sm-3 col-xs-3">
                                            <a href="#"
                                               class="btn-show-profile"
                                               data-id="{{$id = $item->id}}">{{ $item->name }}</a>
                                        </td>
                                        <td class="col-sm-4 col-xs-4">{{ $item->phone }}</td>
                                        <td class="col-sm-3 col-xs-3">{{ $item->major }}</td>
                                        <td class="col-sm-1 col-xs-1" style="text-align:center">
                                            <a href="/admin/schedule/{{ $schedule->id }}/user/{{ $item->id }}"
                                               style="color:red"
                                               class="submitDelete">
                                                X
                                                <form class="delete-staff"
                                                      action="/admin/schedule/{{ $schedule->id }}/user/{{ $item->id }}"
                                                      method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div style="text-align:center;border-bottom: 1px dotted  #d4cfcf;width: 70%;margin: auto;">
                            <a href="#" data-toggle="modal" data-target="#add-staff">Add staff</a>
                        </div>
                    </div>
                </div>

                <div class="card card-block sameheight-item" id="vaccine-list-2">
                    <div class="title-block">
                        <h3 class="title">List of Vaccines</h3>
                    </div>
                    <div class="form-group">
                        <table class="table list-staff">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Vaccine</th>
                                <th>Category</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($vaccines)
                                <?php $i = 0; ?>
                                @foreach($vaccines as $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>
                                            <a href="#"
                                               class="btn-show-profile"
                                               data-id="{{$id = $item->id}}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->category->name }}</td>
                                        <td style="text-align:center">
                                            <a href="/admin/schedule/{{ $schedule->id }}/vaccine/{{ $item->id }}"
                                               style="color:red"
                                               class="submitDelete">
                                                X
                                                <form class="delete-staff"
                                                      action="/admin/schedule/{{ $schedule->id }}/vaccine/{{ $item->id }}"
                                                      method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div style="text-align:center;border-bottom: 1px dotted  #d4cfcf;width: 70%;margin: auto;">
                            <a href="#" data-toggle="modal" data-target="#add-vaccine">Add vaccine</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
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

    <!-- Modal -->
    <div id="add-staff" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Staff</h4>
                </div>
                <form action="/admin/schedule/{{$schedule->id}}/user" method="post" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <select name="staff_id[]" multiple="multiple" class="form-control" size="20">
                                    @foreach($allStaff as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="add-vaccine" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Vaccine</h4>
                </div>
                <form action="/admin/schedule/{{$schedule->id}}/vaccine" method="post" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <select name="vaccine_id[]" multiple="multiple" class="form-control" size="20">
                                    @foreach($allVaccine as $id => $name)
                                        <option value="{{ $id }}">{{ $name }} - {{ \App\Vaccine::find($id)->category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="vaccine-information" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1150px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vaccine Detail</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-sm-3">
                        <img src="" class="profile-avatar" style="width: 100%; border: 3px darkgray solid" />
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Name</label>
                            <div class="col-sm-10">
                                <p class="vaccine-name"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Description</label>
                            <div class="col-sm-10">
                                <p class="vaccine-description"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Price</label>
                            <div class="col-sm-10">
                                <p class="vaccine-price"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Category</label>
                            <div class="col-sm-10">
                                <p class="vaccine-category"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Disease</label>
                            <div class="col-sm-10">
                                <p class="vaccine-disease"></p>
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

@endsection
@section('script')
    <script>
        $(function(){
            $('.submitDelete').click(function(){
                event.preventDefault();
                if(window.confirm('Are you sure?')) {
                    $(this).find('.delete-staff').submit();
                }
            });
        });
    </script>
@endsection