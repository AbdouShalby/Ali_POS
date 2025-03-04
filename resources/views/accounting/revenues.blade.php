@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('revenues.title') }}</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('revenues.date') }}</th>
                <th>{{ __('revenues.source') }}</th>
                <th>{{ __('revenues.amount') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($revenues as $revenue)
                <tr>
                    <td>{{ $revenue->revenue_date }}</td>
                    <td>{{ $revenue->source }}</td>
                    <td>{{ $revenue->amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $revenues->links() }}
    </div>
@endsection
