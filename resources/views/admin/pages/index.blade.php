<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Էջեր</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('pages.create')}}">+ Ավելացնել էջ</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($pages->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Էջի համարը</th>
                        <th>Անուն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr data-prod-item-id="{{$page->id}}">
                            <td>{{Str::title($page->id)}}</td>
                            <td>
                                <a class="nav-link" href="{{route('pages.show',['page' => $page])}}">
                                    {{Str::title($page->title)}}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('pages.edit',['page' => $page])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger page" data-item-id="{{$page->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Էջեր չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
{{--        <div class="card-footer clearfix">--}}
{{--            {{$categories->links()}}--}}
{{--        </div>--}}
    </div>
@endsection
