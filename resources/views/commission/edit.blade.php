<div class="card bg-none card-box">
{{Form::model($commission,array('route' => array('commission.update', $commission->id), 'method' => 'PUT')) }}
<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('title', __('Title'),['class' => 'form-control-label']) }}
                {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('type', __('Type'), ['class' => 'form-control-label']) }}
                {{ Form::select('type', $commissions, null, ['class' => 'form-control select2 amount_type', 'required' => 'required']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('amount', __('Amount'),['class' => 'form-control-label amount_label']) }}
                {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
            </div>
        </div>
    </div>
    <div class="col-12">
        <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
        <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</div>
{{Form::close()}}
</div>

