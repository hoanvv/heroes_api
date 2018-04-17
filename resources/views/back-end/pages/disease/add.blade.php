@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h1>Add New Disease</h1>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Disease's Information</h3>
                    </div>

                    <form method="post" action="/admin/disease">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control boxed" placeholder="Cancer types">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('symptom') ? ' has-error' : '' }}">
                            <label class="control-label">Symptom</label>
                            <textarea type="text" name="symptom" rows="4" class="form-control boxed"></textarea>

                            @if ($errors->has('symptom'))
                                <span class="help-block">
                                <strong>{{ $errors->first('symptom') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/disease" class="btn btn-warning">Cancel</a>
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