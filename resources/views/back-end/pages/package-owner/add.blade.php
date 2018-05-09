@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h1>Add New Package Owner</h1>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Package Owner's Information</h3>
                    </div>

                    <form method="post" action="/admin/po" class="form-validate-user-add">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="control-label">First Name</label>
                            <input type="text" name="first_name" class="form-control boxed" placeholder="John">

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control boxed" placeholder="Smith">

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" class="form-control boxed" placeholder="example@gmail.com">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" class="form-control boxed" placeholder="Password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label">Phone</label>
                            <input type="text" name="phone" class="form-control boxed" placeholder="0984617361">

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
    @endif
@endsection