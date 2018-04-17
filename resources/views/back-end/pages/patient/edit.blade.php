@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h2>Edit Patient</h2>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Patient's Information</h3>
                    </div>

                    <form method="post" action="/admin/patient/{{ $patient->id }}" enctype="multipart/form-data" class="form-validate-patient">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('fullname') ? ' has-error' : '' }}">
                            <label class="control-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control boxed" value="{{ $patient->fullname }}" placeholder="John Smith">

                            @if ($errors->has('fullname'))
                                <span class="help-block">
                                <strong>{{ $errors->first('fullname') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" class="form-control boxed" value="{{ $patient->email }}">
                            @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label class="control-label">Birthday</label>
                            <input type="date" name="birthday" class="form-control boxed" value="{{ $patient->birthday }}">

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
                                    $patient->gender,
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
                            <input type="text" name="address" class="form-control boxed" value="{{ $patient->address }}" placeholder="Hoa Khanh, Lien Chieu, Danang">

                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label">Phone</label>
                            <input type="text" name="phone" class="form-control boxed" value="{{ $patient->phone }}" placeholder="0984617361">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('identity_card') ? ' has-error' : '' }}">
                            <label class="control-label">Identity Card</label>
                            <input type="text" name="identity_card" class="form-control boxed" value="{{ $patient->identity_card }}" placeholder="197301512">

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
                                    <img src="{{ $patient->avatar }}" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
                                </div>
                            </div>

                            @if ($errors->has('avatar'))
                                <span class="help-block">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/patient" class="btn btn-warning">Cancel</a>
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