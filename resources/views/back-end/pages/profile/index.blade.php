@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <img class="profile-avatar" style="width:100%; border: 1px solid darkgray;" src="{{ $user->avatar }}" />
            </div>
            <div class="col-sm-9">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#information">Information</a></li>
                    <li><a data-toggle="tab" href="#change-password">Change Password</a></li>
                </ul>

                <div class="tab-content">
                    <div id="information" class="tab-pane fade in active" style="margin: 25px 10px;">
                        <form method="post" action="/admin/profile/{{ $user->id }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control boxed" value="{{ $user->name }}" placeholder="John Smith">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-sm-2">Email</label>
                                <div class="col-sm-10">
                                    <span class="form-control boxed">{{ $user->email }}</span>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Birthday</label>
                                <div class="col-sm-10">
                                    <input type="date" name="birthday" class="form-control boxed" value="{{ $user->birthday }}">
                                    @if ($errors->has('birthday'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('birthday') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Gender</label>
                                <div class="col-sm-10">
                                    {{
                                        Form::select(
                                            'gender',
                                            array('' => 'I am...', '0' => 'Male', '1' => 'Female', '2' => 'Other'),
                                            $user->gender,
                                            ['class' => 'form-control boxed']
                                        )
                                    }}
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" class="form-control boxed" value="{{ $user->address }}" placeholder="Hoa Khanh, Lien Chieu, Danang">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" class="form-control boxed" value="{{ $user->phone }}" placeholder="0984617361">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('identity_card') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Identity Card</label>
                                <div class="col-sm-10">
                                    <input type="text" name="identity_card" class="form-control boxed" value="{{ $user->identity_card }}" placeholder="197301512">
                                    @if ($errors->has('identity_card'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('identity_card') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Position</label>
                                <div class="col-sm-10">
                                    <input type="text" name="position" class="form-control boxed" value="{{ $user->position }}">
                                    @if ($errors->has('position'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('position') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('major') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Major</label>
                                <div class="col-sm-10">
                                    <input type="text" name="major" class="form-control boxed" value="{{ $user->major }}">
                                    @if ($errors->has('major'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('major') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('avatar') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-2">Avatar</label>
                                <div class="col-sm-10">
                                    <input type="file" name="avatar" />
                                    @if ($errors->has('avatar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('avatar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="change-password" class="tab-pane fade" style="margin: 25px 10px;">
                        <form class="form-horizontal" action="/admin/profile/update-password/{{ $user->id }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            @if($errors->has('old_password') || $errors->has('new_password') || session()->has('message_error_password'))
                                <script>
                                    $(function() {
                                        $('.nav-tabs a[href="#change-password"]').tab('show')
                                    });
                                </script>
                            @endif
                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="email">Old Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="old_password" id="current-old_password" placeholder="Enter Old Password">
                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                    @if (session()->has('message_error_password'))
                                        <span class="help-block">
                                            <strong>{{ session('message_error_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="pwd">New Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="new_password" id="pwd" placeholder="Enter New password">
                                    @if ($errors->has('new_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-3" for="pwd">Confirm New Password:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password_confirmation" id="pwd" placeholder="Enter Confirm New password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
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
@endsection