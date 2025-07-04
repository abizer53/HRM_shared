<div class="card bg-none card-box">
    {{Form::open(array('url'=>'resignation','method'=>'post', 'enctype' => 'multipart/form-data'))}}
    <div class="row">
        @if(\Auth::user()->type!='employee')
            <div class="form-group col-lg-12">
                {{ Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])}}
                {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required')) }}
            </div>
        @endif
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('notice_date',__('Notice Date'),['class'=>'form-control-label'])}}
            {{Form::text('notice_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('resignation_date',__('Resignation Date'),['class'=>'form-control-label'])}}
            {{Form::text('resignation_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('description',__('Description'),['class'=>'form-control-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('file',__('Upload File'),['class'=>'form-control-label'])}}
            {{Form::file('file',null,array('class'=>'form-control'))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
