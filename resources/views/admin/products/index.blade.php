<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ապրանքներ</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('products.create')}}">+ Ավելացնել ապրանք</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($products->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Ապրանքի համարը</th>
                        <th>Անուն</th>
                        <th>Քանակ</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr data-prod-item-id="{{$product->id}}">
                            <td>{{Str::title($product->id)}}</td>
                            <td>
                                <a class="nav-link" href="{{route('products.edit',['product' => $product])}}">
                                    {{Str::title($product->title)}}
                                </a>
                            </td>
                            <td>
                                <span>
                                    {{Str::title($product->count)}}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('products.edit',['product' => $product])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger product" data-item-id="{{$product->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Ապրանքներ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{$products->links()}}
        </div>
    </div>
@endsection
