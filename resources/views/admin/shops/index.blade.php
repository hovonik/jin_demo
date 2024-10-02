<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Խանութներ</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('shops.create')}}">+ Ավելացնել խանութ</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($shops->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Խանութի համարը</th>
                        <th>Անուն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shops as $shop)
                        <tr data-item-id="{{$shop->id}}">
                            <td>{{Str::title($shop->id)}}</td>
                            <td>
                                <a class="nav-link" href="{{route('shops.show',['shop' => $shop])}}">
                                    {{Str::title($shop->name)}}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('shops.edit',['shop' => $shop])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger shop" data-item-id="{{$shop->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Խանութներ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
{{--        <div class="card-footer clearfix">--}}
{{--            {{$categories->links()}}--}}
{{--        </div>--}}
    </div>
@endsection
