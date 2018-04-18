@extends('back-end.layouts.app')
@section('content')
<div class="container">
    <h1>Add New Schedule</h1>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="card card-block sameheight-item">
                <div class="title-block">
                    <h3 class="title"> Schedule's Information</h3>
                </div>

                <form method="post" action="/admin/schedule">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                        <label class="control-label">Title</label>
                        <input type="text" name="title" class="form-control boxed" placeholder="Annual vaccination">

                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                        <label class="control-label">Content</label>
                        <textarea type="text" name="content" rows="10" class="form-control boxed"></textarea>

                        @if ($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label class="control-label">Start date</label>
                        <input type="date" name="start_date" class="form-control boxed" value="<?php echo date('Y-m-d') ?>">

                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label class="control-label">End date</label>
                        <input type="date" name="end_date" class="form-control boxed" value="<?php echo date('Y-m-d') ?>">

                        @if ($errors->has('end_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
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

                    <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                        <label class="control-label">State</label>
                        {{
                            Form::select(
                                'state',
                                array('0' => 'Coming', '1' => 'Closed'),
                                '0',
                                ['class' => 'form-control boxed']
                            )
                        }}
                        @if ($errors->has('state'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
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