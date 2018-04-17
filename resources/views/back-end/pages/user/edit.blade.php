@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> User's Information</h3>
                    </div>

                    <form method="post" action="/admin/user/{{ $user->id }}" enctype="multipart/form-data" class="form-validate-user-update">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control boxed" value="{{ $user->name }}" placeholder="John Smith">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <span class="form-control boxed">{{ $user->email }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" class="form-control boxed" value="" placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('is_admin') ? ' has-error' : '' }}">
                            <label class="control-label">Role</label>
                            {{
                                Form::select(
                                    'is_admin',
                                    array('' => 'I am...', '0' => 'Member', '1' => 'Admin'),
                                    $user->is_admin ? '1' : '0',
                                    ['class' => 'form-control boxed']
                                )
                            }}
                            @if ($errors->has('is_admin'))
                                <span class="help-block">
                                <strong>{{ $errors->first('is_admin') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label class="control-label">Birthday</label>
                            <input type="date" name="birthday" class="form-control boxed" value="{{ $user->birthday }}">

                            @if ($errors->has('birthday'))
                                <span class="help-block">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label class="control-label">Gender</label>
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

                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="control-label">Address</label>
                            <input type="text" name="address" class="form-control boxed" value="{{ $user->address }}" placeholder="Hoa Khanh, Lien Chieu, Danang">

                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label">Phone</label>
                            <input type="text" name="phone" class="form-control boxed" value="{{ $user->phone }}" placeholder="0984617361">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('identity_card') ? ' has-error' : '' }}">
                            <label class="control-label">Identity Card</label>
                            <input type="text" name="identity_card" class="form-control boxed" value="{{ $user->identity_card }}" placeholder="197301512">

                            @if ($errors->has('identity_card'))
                                <span class="help-block">
                                <strong>{{ $errors->first('identity_card') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('position') ? ' has-error' : '' }}">
                            <label class="control-label">Position</label>
                            <input type="text" name="position" class="form-control boxed" value="{{ $user->position }}">

                            @if ($errors->has('position'))
                                <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('major') ? ' has-error' : '' }}">
                            <label class="control-label">Major</label>
                            <input type="text" name="major" class="form-control boxed" value="{{ $user->major }}">

                            @if ($errors->has('major'))
                                <span class="help-block">
                                <strong>{{ $errors->first('major') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label class="control-label">Avatar</label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="file" name="avatar" />
                                </div>
                                <div class="col-sm-4">
                                    <img src="{{ $user->avatar }}" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
                                </div>
                            </div>

                            @if ($errors->has('avatar'))
                                <span class="help-block">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/user" class="btn btn-warning">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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