@extends('layouts.app')
@section('title', 'Orders')
@section('content')
<section class="section-pagetop bg-dark">
    <div class="container clearfix">
        <h2 style="color: #fff">Orders List</h2>
    </div>
</section>
@if(session('message'))
    <div class="alert alert-success" role="alert">{{ session('message') }}</div>
@endif
<section class="section-content bg padding-y">
    <div class="container">
        <div id="code_prod_complex">
            <div class="row">
                <table>
                    <tr>
                        <td>Transcation id</td>
                        <td>Amount</td>
                        <td>Created on</td>
                        <td>Status</td>
                    </tr>
                @forelse($orders as $order)
                    <tr>
                        <td>{{$order->transcation_id}}</td>
                        <td>{{config('services.currency_symbol') . ' ' .$order->amount}}</td>
                        <td>{{$order->created_on}}</td>
                        <td>{{$order->status}}</td>
                    </tr>
                @empty
                    <tr><td>No Products found.</td></tr>
                @endforelse
                </table>
                <div class="bottom-wrap">
                {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@stop
