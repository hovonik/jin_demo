<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Վարպետների դիմումներ</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($master_requests->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Դիմումի համարը</th>
                        <th>Դիմողի անուն ազգանուն</th>
                        <th>Դիմումի կարգավիճակ</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($master_requests as $master_request)
                        <tr data-item-id="{{$master_request->id}}">
                            <td>
                                {{$master_request->id}}
                            </td>
                            <td>
                                @if($master_request->master)
                                    <a class="nav-link" href="{{route('master-verification-requests.edit',['master_verification_request' => $master_request])}}">
                                        {{Str::title($master_request->master->first_name)}} {{Str::title($master_request->master->last_name)}}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <?php
                                    if($master_request->admin_decision_provided == 1 && $master_request->verified == 0){
                                        $status = 'Մերժված';
                                    }elseif ($master_request->admin_decision_provided == 0){
                                        $status = 'Նոր';
                                    }else{
                                        $status = 'Հաստատված';
                                    }
                                    ?>
                                {{$status}}
                            </td>
                            <td>
                                <a class="nav-link" href="{{route('master-verification-requests.edit',['master_verification_request' => $master_request])}}">
                                    Դիտել
                                </a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger master" data-item-id="{{$master_request->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Դիմումներ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{$master_requests->links()}}
        </div>
    </div>
@endsection

