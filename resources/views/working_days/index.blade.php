@extends('layouts.admin')

@section('page-title')
    {{ __('Working Days') }}
@endsection

@section('content')
    <form action="{{ route('working-day.update') }}" method="POST">
        @method('post')
        @csrf
        <div class="px-3">
            <table class="table">
                <tr>
                    <td>#</td>
                    <th>{{ __('Day') }}</th>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="monday" @if ($workingDay->monday) checked @endif>
                    </td>
                    <td>{{ __('Monday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="tuesday" @if ($workingDay->tuesday) checked @endif>
                    </td>
                    <td>{{ __('Tuesday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="wednesday" @if ($workingDay->wednesday) checked @endif>
                    </td>
                    <td>{{ __('Wednesday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="thursday" @if ($workingDay->thursday) checked @endif>
                    </td>
                    <td>{{ __('Thursday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="friday" @if ($workingDay->friday) checked @endif>
                    </td>
                    <td>{{ __('Friday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="saturday" @if ($workingDay->saturday) checked @endif>
                    </td>
                    <td>{{ __('Saturday') }}</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="sunday" @if ($workingDay->sunday) checked @endif>
                    </td>
                    <td>{{ __('Sunday') }}</td>
                </tr>
            </table>
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
@endsection
