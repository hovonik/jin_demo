<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Custom Fields</h3>
            <div style="float: right" class="">
                <a class="btn-sm btn-secondary" href="{{route('custom-fields.create')}}">+ Ավելացնել Custom field</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($custom_fields->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Համարը</th>
                        <th>Անուն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($custom_fields as $custom_field)
                        <tr data-prod-item-id="{{$custom_field->id}}">
                            <td>{{Str::title($custom_field->id)}}</td>
                            <td>
                                <a class="nav-link" href="{{route('custom-fields.show',['custom_field' => $custom_field])}}">
                                    {{Str::title($custom_field->name)}}
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning"
                                   href="{{route('custom-fields.edit',['custom_field' => $custom_field])}}">Խմբագրել</a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger custom_field" data-item-id="{{$custom_field->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Custom field-եր չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{$custom_fields->links()}}
        </div>
    </div>
@endsection
