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
                        @if($master_request->master)
                            <p>Անուն Ազգանուն։ <b>{{Str::title($master_request->master->first_name)}}</b>
                                <b>{{Str::title($master_request->master->last_name)}}</b></p>
                            <p>Անձնագրի տվյալներ։ <b>{{Str::title($master_request->master->passport)}}</b></p>
                            <p>Էլ․ հասցե։ <b>{{Str::title($master_request->master->email)}}</b></p>
                            <p>Հեռախոսահամար։ <b>{{Str::title($master_request->master->phone)}}</b></p>
                            @if($master_request->master->driver_license)
                                <p>Վարորդական իրավունք։ <b>{{Str::title($master_request->master->driver_license)}}</b>
                                </p>
                            @endif
                            @if($master_request->master->driver_license)
                                <p>Հասցե։ <b>{{Str::title($master_request->master->address)}}</b></p>
                            @endif
                            @if($master_request->master->town)
                                <p>Մարզ։ <b>{{Str::title($master_request->master->town)}}</b></p>
                            @endif
                            @if($master_request->master->city)
                                <p>Քաղաք։ <b>{{Str::title($master_request->master->city)}}</b></p>
                            @endif
                            @if($master_request->master->zip_code)
                                <p>Փոստային ինդեքս։ <b>{{Str::title($master_request->master->zip_code)}}</b></p>
                            @endif
                            @if($master_request->master->birthday)
                                <p>Ծննդյան ամսաթիվ։ <b>{{Str::title(\Carbon\Carbon::create($master_request->master->birthday)->format('Y-m-d'))}}</b></p>
                            @endif
                            @if($master_request->master->avatar)
                                <p>Պրոֆիլի նկար։ <img src="{{$master_request->master->avatar}}" width="200px"></p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Մասնագիտական տվյալներ</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($master_request->master->professions)
                            @foreach($master_request->master->professions as $profession)
                                @if($profession->parent)
                                    <p>{{Str::title($profession->parent->title)}} {{Str::title($profession->title)}}</p>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Փաստաթղթերի նկարներ</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($master_request->files)
                            @php
                                $passport_images = [];
                                $driver_license_image = [];
                                $car_texpassport_image_images = [];
                                $car_images = [];
                            @endphp
                            @foreach($master_request->files as $file)
                                @php
                                    switch ($file->type){
                                        case 'passport':
                                            $passport_images[] = $file->image_url;
                                            break;
                                        case 'car_texpassport_image':
                                            $car_texpassport_image_images[] = $file->image_url;
                                            break;
                                        case 'driver_license':
                                            $driver_license_images[] = $file->image_url;
                                            break;
                                        case 'car_images':
                                            $car_images[] = $file->image_url;
                                            break;
                                    }

                                @endphp
                            @endforeach
                        @endif
                        <div class="mt-3">
                            @if(!empty($passport_images))
                                <h3>Անձնագրի նկարներ</h3>
                                <div class="passport-images">
                                    @foreach($passport_images as $passport_image)
                                        <img src="{{$passport_image}}" width="300">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            @if(!empty($driver_license_images))
                                <h3>Վարորդական իրավունքի նկարներ</h3>
                                <div class="passport-images">
                                    @foreach($driver_license_images as $driver_license_image)
                                        <img src="{{$driver_license_image}}" width="300">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            @if(!empty($car_texpassport_image_images))
                                <h3>Ավտոմեքենայի տեխանձնագրի նկարներ</h3>
                                <div class="passport-images">
                                    @foreach($car_texpassport_image_images as $car_texpassport_image_image)
                                        <img src="{{$car_texpassport_image_image}}" width="300">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                            <div class="mt-3">
                                @if(!empty($car_images))
                                    <h3>Ավտոմեքենայի նկարներ</h3>
                                    <div class="passport-images">
                                        @foreach($car_images as $car_image)
                                            <img src="{{$car_image}}" width="300">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mb-2 request-form">
                @csrf
                <input type="hidden" value="{{$master_request->id}}" class="request-id">
                <button class="btn btn-primary accept">Ընդունել</button>
                <button class="btn btn-secondary reject">Մերժել</button>
            </div>
        </div>
    </section>
@endsection
