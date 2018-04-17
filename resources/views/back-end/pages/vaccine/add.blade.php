@extends('back-end.layouts.app')
@section('content')
<div class="container">
    <h1>Add New Vaccine</h1>
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <div class="card card-block sameheight-item">
                <div class="title-block">
                    <h3 class="title"> Vaccine's Information</h3>
                </div>
{{--{{dd($categories)}}--}}
                <form method="post" action="/admin/vaccine" enctype="multipart/form-data">
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

                    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                        <label class="control-label">Category</label>
                        {{
                            Form::select(
                                'category_id',
                                $categories,
                                null,
                                ['class' => 'form-control boxed']
                            )
                        }}
                        @if ($errors->has('category_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('disease_id') ? ' has-error' : '' }}">
                        <label class="control-label">Disease</label>
                        {{
                            Form::select(
                                'disease_id',
                                $diseases,
                                null,
                                ['class' => 'form-control boxed']
                            )
                        }}
                        @if ($errors->has('disease_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('disease_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="control-label">Description</label>
                        <textarea name="description" rows="10" class="form-control boxed"></textarea>

                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="control-label">Price</label>
                        <input type="text" name="price" class="form-control boxed" />

                        @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                        <label class="control-label">Image</label>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="file" name="image" >
                            </div>
                            <div class="col-sm-4">
                                <img src="" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
                            </div>
                        </div>

                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="/admin/vaccine" class="btn btn-warning">Cancel</a>
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