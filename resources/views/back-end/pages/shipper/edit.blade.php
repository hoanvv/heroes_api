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

                    <form method="post" action="/admin/shipper/{{ $shipper->id }}" enctype="multipart/form-data" class="form-validate-user-update">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="control-label">First Name</label>
                            <input type="text" name="first_name" class="form-control boxed" placeholder="John" value="{{$shipper->user->first_name}}">

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control boxed" placeholder="Smith" value="{{$shipper->user->last_name}}">

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <span class="form-control boxed">{{$shipper->user->email}}</span>
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

                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label">Phone</label>
                            <input type="text" name="phone" class="form-control boxed" value="{{$shipper->user->phone}}" placeholder="0984617361">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('identity_card') ? ' has-error' : '' }}">
                            <label class="control-label">Identity Card</label>
                            <input type="text" name="identity_card" class="form-control boxed" value="{{$shipper->identity_card}}" placeholder="197301512">

                            @if ($errors->has('identity_card'))
                            <span class="help-block">
                                <strong>{{ $errors->first('identity_card') }}</strong>
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
                                    <img src="{{url("storage/{$shipper->avatar}")}}" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
                                </div>
                            </div>

                            @if ($errors->has('avatar'))
                                <span class="help-block">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/shipper" class="btn btn-warning">Cancel</a>
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