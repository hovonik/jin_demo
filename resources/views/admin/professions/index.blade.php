<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Մասնագիտություններ</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('professions.create')}}">+ Ավելացնել մասնագիտություն</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($professions->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Անուն</th>
                        <th>Նկարագրություն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($professions as $profession)
                        <tr data-prod-item-id="{{$profession->id}}">
                            <td>
                                <a class="nav-link"
                                   href="{{route('professions.edit',['profession' => $profession])}}">
                                    {{Str::title($profession->title)}}
                                </a>
                            </td>
                            <td>
                                {{Str::title($profession->description)}}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('professions.edit',['profession' => $profession])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger profession parent" data-item-id="{{$profession->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                        @if($profession->children)
                            @foreach($profession->children as $child)
                                <tr data-prod-item-id="{{$child->id}}">
                                    <td>
                                        <a class="nav-link"
                                           href="{{route('professions.edit',['profession' => $child])}}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-{{Str::title($child->title)}}
                                        </a>
                                    </td>
                                    <td>
                                        {{Str::title($child->description)}}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning"
                                           href="{{route('professions.edit',['profession' => $child])}}">Խմբագրել</a>
                                        <button class="item-del-btn btn ml-2 btn-sm btn-danger profession" data-item-id="{{$child->id}}">
                                            Ջնջել
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Մասնագիտություններ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{$professions->links()}}
                </div>
    </div>
@endsection
