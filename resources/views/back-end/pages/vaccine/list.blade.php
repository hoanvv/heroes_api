@extends('back-end.layouts.app')
@section('content')
<section id="vaccine-list">
    <div class="container">
        <h3>List Of vaccines <a href="/admin/vaccine/create">Add New</a></h3>
        <table id="list-vaccines" class="cell-border hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Disease</th>
                    <th>Price</th>
                    <th>Method</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            @foreach($list as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->disease->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <button type="button" class='btn btn-warning btn-xs btn-show-profile' data-id="{{$id = $item->id}}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </button>
                        <a href="/admin/vaccine/{{$id}}/edit" class='btn btn-success btn-xs'>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <button type="button" class='btn btn-danger btn-xs btn-delete' data-id="{{$id = $item->id}}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Disease</th>
                    <th>Price</th>
                    <th>Method</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal -->
    <div id="vaccine-information" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1150px;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vaccine Detail</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-sm-3">
                        <img src="" class="profile-avatar" style="width: 100%; border: 3px darkgray solid" />
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Name</label>
                            <div class="col-sm-10">
                                <p class="vaccine-name"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Description</label>
                            <div class="col-sm-10">
                                <p class="vaccine-description"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Price</label>
                            <div class="col-sm-10">
                                <p class="vaccine-price"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Category</label>
                            <div class="col-sm-10">
                                <p class="vaccine-category"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Disease</label>
                            <div class="col-sm-10">
                                <p class="vaccine-disease"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class='btn btn-danger btn-xs' data-dismiss="modal" >
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div id="delete-vaccine" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="/admin/vaccine">
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Vaccine</h4>
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

@section('script')
    <script>
        $(function(){
            var table = $('#list-vaccines').DataTable();
            var search = window.location.search;
//            console.log(search);
            if( search !== "") {
                var hash = search.split('?')[1].split('=');
                var query = hash[0];
                var id = hash[1];
                var diseases = <?php echo json_encode($diseases); ?>;
                var categories = <?php echo json_encode($categories); ?>;
//                console.log(disease_id, diseases);
                var nameDisease = diseases[id];
                var nameCategory = categories[id];

                if (query == 'disease_id') {
                    if (id) {
                        table
                            .columns( 3 )
                            .search( nameDisease )
                            .draw();
                    }
                } else if (query == 'category_id') {
                    if (id) {
                        table
                            .columns( 2 )
                            .search( nameCategory )
                            .draw();
                    }
                } else {
                    table
                        .columns( 3 )
                        .search( "Ngu ma li" )
                        .draw();
                }
            }

        });
    </script>
@endsection


