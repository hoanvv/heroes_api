@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Package Type</h1>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> Package Type's Information</h3>
                    </div>

                    <form method="post" action="/admin/package-type/{{$packageType->id}}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control boxed" value="{{$packageType->name}}" placeholder="Document">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('optional_package') ? ' has-error' : '' }}">
                            <label class="control-label">Optional Package</label>
                            <p>
                                <label class="radio-inline">
                                    <input type="radio" name="optional_package" {{$packageType->optional_package ? "checked" : ""}} value="1">
                                    Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="optional_package" {{$packageType->optional_package ? "" : "checked"}} value="0">
                                    No
                                </label>
                            </p>
                            @if ($errors->has('optional_package'))
                                <span class="help-block">
                                <strong>{{ $errors->first('optional_package') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="control-label">Description</label>
                            <textarea name="description" class="form-control boxed" placeholder="Enter a description">{{$packageType->description}}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('start_weight') ? ' has-error' : '' }}">
                            <label class="control-label">Start Weight (Kg)</label>
                            <input type="text" name="start_weight" class="form-control boxed" placeholder="20" value="{{$packageType->start_weight}}">

                            @if ($errors->has('start_weight'))
                                <span class="help-block">
                                <strong>{{ $errors->first('start_weight') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('end_weight') ? ' has-error' : '' }}">
                            <label class="control-label">End Weight (Kg)</label>
                            <input type="text" name="end_weight" class="form-control boxed" placeholder="20" value="{{$packageType->end_weight}}">

                            @if ($errors->has('end_weight'))
                                <span class="help-block">
                                <strong>{{ $errors->first('end_weight') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}" >
                            <label class="control-label">Price (VND)</label>
                            <input type="text" name="price" class="form-control boxed" placeholder="20 000" value="{{$packageType->price}}">

                            @if ($errors->has('price'))
                                <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="/admin/package-type" class="btn btn-warning">Cancel</a>
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