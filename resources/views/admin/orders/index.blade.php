<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Էջեր</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('orders.create')}}">+ Ավելացնել պատվեր</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($orders->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Պատվերի համարը</th>
                        <th>Օգտվողի տվյալներ</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @if($order->user)
                            <tr data-prod-item-id="{{$order->id}}">
                                <td>{{Str::title($order->id)}}</td>
                                <td>
                                    {{Str::title($order->user->first_name . ' ' . $order->user->last_name)}}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-warning"
                                       href="{{route('orders.edit',['order' => $order])}}">Դիտել</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Էջեր չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{$orders->links()}}
        </div>
    </div>
@endsection
