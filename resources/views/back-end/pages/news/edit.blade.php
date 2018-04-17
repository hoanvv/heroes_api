@extends('back-end.layouts.app')
@section('content')
    <div class="container">
        <h2>Edit News</h2>
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title"> News Detail</h3>
                    </div>

                    <form method="post" action="/admin/news/{{ $news->id }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">Title</label>
                            <input type="text" name="title" class="form-control boxed" value="{{ $news->title }}" placeholder="Daily news">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="control-label">Content</label>
                            <textarea name="content" rows="30" class="form-control boxed">{{ $news->content }}</textarea>

                            @if ($errors->has('content'))
                                <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
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
                                    <img src="{{ $news->image }}" class="profile-avatar" style="width: 100%; border: 3px solid darkgray" />
                                </div>
                            </div>

                            @if ($errors->has('image'))
                                <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <a href="{{ URL::previous() }}" class="btn btn-warning">Cancel</a>
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