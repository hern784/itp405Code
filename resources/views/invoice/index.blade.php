@extends('layouts.main')

@section('title', 'Invoices')

@section('content')
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th colspan="2">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>
                {{$invoice->id}}
            </td>
            <td>
                {{$invoice->invoice_date}}
            </td>
            <td>
                {{--OLD WAY--}}
                {{--{{$invoice->customer->first_name}} {{$invoice->customer->last_name}}--}}

                {{--NEW WAY USING METHOD FROM MODEL--}}
                {{$invoice->customer->full_name}}

            </td>
            <td>
                ${{$invoice->total}}
            </td>
            <td>
                @can ('view', $invoice)
                    <a href="{{route('invoice.show', ['id' => $invoice->id])}}">
                        Details
                    </a>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
