<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Կատեգորիաներ</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('categories.create')}}">+ Ավելացնել կատեգորիա</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($categories->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Անուն</th>
                        <th>Նկարագրություն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr data-item-id="{{$category->id}}">
                            <td>
                                <a class="nav-link"
                                   href="{{route('categories.edit',['category' => $category])}}">
                                    {{Str::title($category->title)}}
                                </a>
                            </td>
                            <td>
                                {{Str::title($category->description)}}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('categories.edit',['category' => $category])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger category parent" data-item-id="{{$category->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                        @if($category->children)
                            @foreach($category->children as $child)
                                <tr data-item-id="{{$child->id}}">
                                    <td>
                                        <a class="nav-link"
                                           href="{{route('categories.edit',['category' => $child])}}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-{{Str::title($child->title)}}
                                        </a>
                                    </td>
                                    <td>
                                        {{Str::title($child->description)}}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning"
                                           href="{{route('categories.edit',['category' => $child])}}">Խմբագրել</a>
                                        <button class="item-del-btn btn ml-2 btn-sm btn-danger category" data-item-id="{{$child->id}}">
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
                    {{$categories->links()}}
                </div>
    </div>
@endsection
