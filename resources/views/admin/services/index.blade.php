<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ծառայություններ</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('services.create')}}">+ Ավելացնել ծառայություն</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($services->count())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Անուն</th>
                        <th>Գին</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr data-prod-item-id="{{$service->id}}">
                            <td>
                                <a class="nav-link"
                                   href="{{route('services.edit',['service' => $service])}}">
                                    {{Str::title($service->title)}}
                                </a>
                            </td>
                            <td>
                                {{Str::title($service->price)}} դր․
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('services.edit',['service' => $service])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger service parent" data-item-id="{{$service->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Մասնագիտություններ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{$services->links()}}
                </div>
    </div>
@endsection
