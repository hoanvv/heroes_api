@extends('back-end.layouts.app')
@section('content')
<div class="container">
    <h1>Add New Record</h1>
    <div style="padding-top: 30px; background: white;padding-left: 20px;padding-right: 20px;">

        @include('back-end.pages.patient.patient-information', ['patient' => $patient])

        <div style="border-bottom: 1px solid #ccc; width: 100%; margin:30px 0px;"></div>
        <div class="patient-result" style="margin: auto; width: 60%">
            <div class="header-result" style="text-align: center; margin-bottom: 30px;">
                <h3>Patient Records</h3>
            </div>
            <div class="body-result" style="padding-bottom: 20px;">
                <form method="post" action="/admin/patient/{{$patient->id}}/result">
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('schedule_id') ? ' has-error' : '' }}">
                        <label class="control-label">Schedule</label>

                        <div class="select-schedule row">
                            <input type="hidden" name="schedule_id"/>
                            <div class="col-sm-10">
                                <span class="form-control boxed" style="height: 35px;"></span>
                            </div>
                            <button class="btn btn-success col-sm-2" data-toggle="modal" data-target="#schedule-list">Select</button>
                        </div>
                        @if ($errors->has('schedule_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('schedule_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('vaccine_id') ? ' has-error' : '' }}">
                        <label class="control-label">Vaccine</label>
                        <select class="form-control boxed height-select" name="vaccine_id">

                        </select>
                        @if ($errors->has('vaccine_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('vaccine_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="/admin/patient/{{$patient->id}}" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="schedule-list" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">List of Schedule</h4>
            </div>
            <div class="modal-body row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-sm-1">#</th>
                            <th class="col-sm-4">Title</th>
                            <th class="col-sm-5">Time</th>
                            <th class="col-sm-2" style="text-align: center">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0 ?>
                    @foreach($schedules as $item)
                        <tr>
                            <td class="col-sm-1">{{ ++$i }}</td>
                            <td class="col-sm-4">{{ $item->title }}</td>
                            <td class="col-sm-5">{{ date('d/m/Y',strtotime($item->start_date)) }} - {{ date('d/m/Y',strtotime($item->end_date)) }}</td>
                            <td class="col-sm-2" style="text-align: center;">
                                <input type="radio" name="schedule_id" {{$i == 1 ? 'checked' : ""}} value="{{$item->id}}"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class='btn btn-success btn-xs' id="select-schedule-radio">Select</button>
                <button type="button" class='btn btn-danger btn-xs' data-dismiss="modal" >Close</button>
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

@section('script')
    <script>
        $(function(){
             $('#select-schedule-radio').click(function(){
                 var checked_radio = $('#schedule-list').find('input[name=schedule_id]:checked');
                 var schedule_id = checked_radio.val();
                 var title = checked_radio.closest('tr').find('td:nth-child(2)').text();
                 var time = checked_radio.closest('tr').find('td:nth-child(3)').text();
                 var content = title + ' | ' + time;
                 $('.select-schedule div span').text(content);
                 $('.select-schedule input[name=schedule_id]').val(schedule_id);
                 $('#schedule-list').modal('hide');
                 var url =  '/admin/getVaccineByScheduleId/' + schedule_id;
                 $.ajax({
                     method: "get",
                     url: url
                 })
                     .done(function( data ) {
                         console.log(data);
                         var vaccine;
                         var content = '<option value="" selected="selected">-- Choose --</option>';
                         for (x in data) {
                             console.log(x);
                             content += '<option value="'+ data[x].id +'">' + data[x].name + ' - ' +data[x].category.name + '</option>';
                         }
                         console.log(content);
                         $('select[name=vaccine_id]').html(content);
                     })
             });
        });
    </script>
@endsection
