@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h2>Edit Shipper</h2>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Package Owner's Information</h3>
                    </div>

                    <form method="post" action="/admin/po/{{ $po->id }}" class="form-validate-user-update">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="control-label">First Name</label>
                            <input type="text" name="first_name" class="form-control boxed" placeholder="John" value="{{$po->first_name}}">

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control boxed" placeholder="Smith" value="{{$po->last_name}}">

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <span class="form-control boxed">{{$po->email}}</span>
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
                            <input type="text" name="phone" class="form-control boxed" value="{{$po->phone}}" placeholder="0984617361">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/po" class="btn btn-warning">Cancel</a>
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