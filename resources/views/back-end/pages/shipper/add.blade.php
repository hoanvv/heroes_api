@extends('back-end.layouts.app')
@section('content')
<div class="container">
    <h1>Add New User</h1>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="card card-block sameheight-item">
                <div class="title-block">
                    <h3 class="title"> User's Information</h3>
                </div>

                <form method="post" action="/admin/user" enctype="multipart/form-data" class="form-validate-user-add">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control boxed" placeholder="John Smith">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
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

                    <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label class="control-label">Birthday</label>
                        <input type="date" name="birthday" class="form-control boxed">

                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('is_admin') ? ' has-error' : '' }}">
                        <label class="control-label">Role</label>
                        {{
                            Form::select(
                                'is_admin',
                                array('' => 'I am...', '0' => 'Member', '1' => 'Admin'),
                                null,
                                ['class' => 'form-control boxed']
                            )
                        }}
                        @if ($errors->has('is_admin'))
                            <span class="help-block">
                                <strong>{{ $errors->first('is_admin') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label class="control-label">Gender</label>
                        <select name="gender" class="form-control boxed">
                            <option value="">I am...</option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                            <option value="2">Other</option>
                        </select>

                        @if ($errors->has('gender'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label class="control-label">Address</label>
                        <input type="text" name="address" class="form-control boxed"  placeholder="Hoa Khanh, Lien Chieu, Danang">

                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
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

                    <div class="form-group {{ $errors->has('identity_card') ? ' has-error' : '' }}">
                        <label class="control-label">Identity Card</label>
                        <input type="text" name="identity_card" class="form-control boxed" placeholder="197301512">

                        @if ($errors->has('identity_card'))
                            <span class="help-block">
                                <strong>{{ $errors->first('identity_card') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('position') ? ' has-error' : '' }}">
                        <label class="control-label">Position</label>
                        <input type="text" name="position" class="form-control boxed" placeholder="Position">

                        @if ($errors->has('position'))
                            <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('major') ? ' has-error' : '' }}">
                        <label class="control-label">Major</label>
                        <input type="text" name="major" class="form-control boxed" placeholder="Major">

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
                                <input type="file" name="avatar" >
                            </div>
                            <div class="col-sm-4">
                                <img src="" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
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
@endif
@endsection