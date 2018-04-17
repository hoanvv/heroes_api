@extends('back-end.layouts.app')
@section('content')
<section id="news-list">
    <div class="container">
        <h3>List Of vaccines <a href="/admin/news/create">Add New</a></h3>
        <table class="table table-hover" style="background: white">
            <thead style="background-color: #85ce36; color: white">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Writting Time</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($list as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>
                        <?php
                        $image = $item->image ? \Illuminate\Support\Facades\Storage::url($item->image) : "";
                        ?>
                        <img style="border: 1px solid #ccc;" width="210" height="130" src="{{ URL::to($image) }}">
                    </td>
                    <td>{{ $item->title }}</td>
                    <td>{{ date('d/m/Y',strtotime($item->created_at)) }}</td>
                    <td>
                        <a href="/news/{{$id = $item->id}}" class='btn btn-warning btn-xs'>
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </a>
                        <a href="/admin/news/{{$id}}/edit" class='btn btn-success btn-xs'>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <button type="button" class='btn btn-danger btn-xs btn-delete' data-id="{{$id}}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center">{{ $list->links() }}</div>

    </div>

    <!-- Modal -->
    <div id="delete-news" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="/admin/news">
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Delete News</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                            Are you sure?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class='btn btn-danger'>Delete</button>
                        <button type="button" class='btn btn-default' data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
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



