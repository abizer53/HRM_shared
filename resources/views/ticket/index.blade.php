@extends('layouts.admin')

@section('page-title')
    {{__('Manage Ticket')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Create Ticket')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="{{ route('ticket.create') }}" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="{{__('Create New Ticket')}}">
                <i class="fa fa-plus"></i> {{__('Create')}}
            </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card card-box">
            <div class="left-card nowrap_text">
                <div class="icon-box"><i class="fas fa-ticket-alt"></i></div>
                <h4>{{__('Total Ticket')}}</h4>
            </div>
            <div class="number-icon"></div>
            <div class="user-text">
                <h2>{{ $countTicket }}</h2>
                
            </div>
            <img src="{{ asset('assets/img/dot-icon.png') }}" alt="" class="dotted-icon"/>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card card-box">
            <div class="left-card nowrap_text">
                <div class="icon-box"><i class="fas fa-ticket-alt"></i></div>
                <h4>{{__('Open Ticket')}}</h4>
            </div>
            <div class="number-icon"></div>
            <div class="user-text">
                
                <h2>{{ $countOpenTicket }}  </h2>
            </div>
            <img src="{{ asset('assets/img/dot-icon.png') }}" alt="" class="dotted-icon"/>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card card-box">
            <div class="left-card nowrap_text">
                <div class="icon-box"><i class="fas fa-ticket-alt"></i></div>
                <h4>{{__('On Hold Ticket')}}</h4>
            </div>
            <div class="number-icon"></div>
            <div class="user-text">
                
                <h2>{{ $countonholdTicket }} </h2>
            </div>
            <img src="{{ asset('assets/img/dot-icon.png') }}" alt="" class="dotted-icon"/>
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
        <div class="card card-box">
            <div class="left-card nowrap_text">
                <div class="icon-box"><i class="fas fa-ticket-alt"></i></div>
                <h4>{{__('Close  Ticket')}}</h4>
            </div>
            <div class="number-icon"></div>
            <div class="user-text">
                
                <h2> {{ $countCloseTicket }} </h2>
            </div>
            <img src="{{ asset('assets/img/dot-icon.png') }}" alt="" class="dotted-icon"/>
        </div>
    </div>

</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable" >
                            <thead>
                            <tr>
                                <th>{{__('New')}}</th>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Ticket Code')}}</th>
                                @role('company')
                                <th>{{__('Employee')}}</th>
                                @endrole
                                <th>{{__('Priority')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Created By')}}</th>
                                <th>{{__('Description')}}</th>
                                <th width="3%">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                        @if(\Auth::user()->type=='employee')
                                            @if($ticket->ticketUnread()>0)
                                                <i title="New Message" class="fas fa-circle circle text-success"></i>
                                            @endif
                                        @else
                                            @if($ticket->ticketUnread()>0)
                                                <i title="New Message" class="fas fa-circle circle text-success"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->ticket_code }}</td>
                                    @role('company')
                                    <td>{{ !empty(\Auth::user()->getUser($ticket->employee_id))?\Auth::user()->getUser($ticket->employee_id)->name:'' }}</td>
                                    @endrole
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{  \Auth::user()->dateFormat($ticket->end_date) }}</td>
                                    <td>{{ !empty($ticket->createdBy)?$ticket->createdBy->name:'' }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td class="text-right action-btns">
                                        <a href="{{ URL::to('ticket/'.$ticket->id.'/reply') }}" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="{{__('Reply')}}">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        @can('Delete Ticket')
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$ticket->id}}').submit();"><i class="fas fa-trash"></i></a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['ticket.destroy', $ticket->id],'id'=>'delete-form-'.$ticket->id]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

