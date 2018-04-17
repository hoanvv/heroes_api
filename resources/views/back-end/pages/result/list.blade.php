@extends('back-end.layouts.app')
@section('content')
<section id="patient-list">
    <div class="container">
        <h3>Immunization Records</h3>
        <div style="padding-top: 30px; background: white;padding-left: 20px;padding-right: 20px;">

            @include('back-end.pages.patient.patient-information', ['patient' => $patient])

            <div style="border-bottom: 1px solid #ccc; width: 100%; margin:30px 0px;"></div>
            <div class="patient-result">
                <div class="header-result" style="text-align: center; margin-bottom: 30px;">
                    <h3>Patient Records</h3>
                </div>
                <div class="body-result" style="padding-bottom: 20px;">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="col-sm-1">#</th>
                            <th class="col-sm-3">Schedule Title</th>
                            <th class="col-sm-4">Schedule Time</th>
                            <th class="col-sm-2">Used Vaccine</th>
                            <th class="col-sm-2">Method</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach($results as $item)
                            <tr>
                                <td class="col-sm-1">{{ ++$i }}</td>
                                <td class="col-sm-3">{{ $item->schedule->title }}</td>
                                <td class="col-sm-4">
                                    {{ date('d/m/Y',strtotime($item->schedule->start_date)) }} -
                                    {{ date('d/m/Y',strtotime($item->schedule->end_date)) }}
                                </td>
                                <td class="col-sm-2">{{ $item->vaccine->name }}</td>
                                <td class="col-sm-2">
                                    <a href="/admin/patient/{{$patient->id}}/result/{{$item->id}}/edit" class='btn btn-success btn-xs'>
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="/admin/patient/{{$patient->id}}/result/{{$item->id}}"
                                       class='btn btn-danger btn-xs btn-delete submitDelete'>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        <form class="delete-result"
                                              action="/admin/patient/{{$patient->id}}/result/{{$item->id}}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="text-align:center;border-bottom: 1px dotted  #d4cfcf;width: 70%;margin: auto;">
                        <a href="/admin/patient/{{$patient->id}}/result/create" style="color: #189a4b;">Add a record</a>
                    </div>
                </div>
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
            $('.submitDelete').click(function(){
                event.preventDefault();
                if(window.confirm('Are you sure?')) {
                    $(this).find('.delete-result').submit();
                }
            });
        });
    </script>
@endsection

