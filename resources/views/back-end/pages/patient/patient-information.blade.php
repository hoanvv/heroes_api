<div style="text-align: center">
    <h3>Patient Information</h3>
</div>
<div class="row">
    <div class="col-sm-3">
        <img src="{{ $patient->avatar }}" style="width: 100%; border: 3px darkgray solid; max-height:400px"/>
    </div>
    <div class="col-sm-9 row">
        <div class="col-sm-6">
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-10">
                    <span class="form-control boxed">{{ $patient->fullname }}</span>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-10">
                    <span class="form-control boxed">{{ $patient->email }}</span>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Gender</label>
                <div class="col-sm-10">
                    <?php $gender = array('0' => 'Male', '1' => 'Female', '2' => 'Other') ?>
                    <span class="form-control boxed">{{ $gender[$patient->gender] }}</span>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Birthday</label>
                <div class="col-sm-10">
                    <span class="form-control boxed">{{ date('d/m/Y',strtotime($patient->birthday)) }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Address</label>
                <div class="col-sm-10" >
                    <span class="form-control boxed" style="height: 100%">{{ $patient->address }}</span>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">Phone</label>
                <div class="col-sm-10">
                    <span class="form-control boxed">{{ $patient->phone }}</span>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 20px">
                <label class="control-label col-sm-2">ID Card</label>
                <div class="col-sm-10">
                    <span class="form-control boxed">{{ $patient->identity_card }}</span>
                </div>
            </div>
        </div>
    </div>
</div>