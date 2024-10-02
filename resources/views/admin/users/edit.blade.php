@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Անձնական տվյալներ</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($user)
                            <p>Անուն Ազգանուն։ <b>{{Str::title($user->first_name)}}</b>
                                <b>{{Str::title($user->last_name)}}</b></p>
                            <p>Էլ․ հասցե։ <b>{{Str::title($user->email)}}</b></p>
                            <p>Հեռախոսահամար։ <b>{{Str::title($user->phone)}}</b></p>
                            @if($user->driver_license)
                                <p>Հասցե։ <b>{{Str::title($user->address)}}</b></p>
                            @endif
                            @if($user->town)
                                <p>Մարզ։ <b>{{Str::title($user->town)}}</b></p>
                            @endif
                            @if($user->city)
                                <p>Քաղաք։ <b>{{Str::title($user->city)}}</b></p>
                            @endif
                            @if($user->zip_code)
                                <p>Փոստային ինդեքս։ <b>{{Str::title($user->zip_code)}}</b></p>
                            @endif
                            @if($user->birthday)
                                <p>Ծննդյան ամսաթիվ։
                                    <b>{{Str::title(\Carbon\Carbon::create($user->birthday)->format('Y-m-d'))}}</b></p>
                            @endif
                            @if($user->avatar)
                                <p>Պրոֆիլի նկար։ <img src="{{$user->avatar}}" width="200px"></p>
                            @endif
                            <p>Օգտագործման լեզու։ <img src="{{$user->lang}}" width="200px"></p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer mb-2 request-form">
                @csrf
                <a href="{{route('users.index')}}" class="btn btn-primary">Հետ</a>
            </div>
        </div>
    </section>
@endsection
