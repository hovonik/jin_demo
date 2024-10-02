@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել էջը</h3>
                    </div>
                </div>
                <form action="{{route('orders.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Պատվիրող</label>
                            <select name="user_id" id="user_id">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">
                                        {{Str::title($user->first_name . ' ' . $user->last_name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="shop_id">Խանութ</label>
                            <select name="shop_id" id="shop_id">
                                @foreach($shops as $shop)
                                    <option value="{{$shop->id}}">
                                        {{Str::title($shop->name)}}
                                    </option>
                                @endforeach
                            </select>
                            @foreach($shops as $shop)
                                <input type="hidden" id="lat-{{$shop->id}}" value="{{$shop->lat}}">
                                <input type="hidden" id="long-{{$shop->id}}" value="{{$shop->lng}}">
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="driver">Ընտրեք ազատ առաքիչին</label>
                            <select name="driver" id="driver">
                                <option value="0" selected>Առանց առաքիչ</option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">
                                        {{Str::title($driver->first_name)}} {{Str::title($driver->last_name)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total">Ընդհանուր գինը առանց առաքում</label>
                            <input min="0" required type="text" name="total" class="form-control" id="total"
                                   value=""
                                   placeholder="Մուտքագրեք պատվերի գինը">
                        </div>
                        <div class="form-group shipping_price">
                            <label>Առաքման գինը</label>
                            <input type="hidden" name="shipping_price" class="form-control w-50 shipping_price"
                                   value=""><span id="shipping_price"></span> Դրամ
                        </div>
                        <div class="form-group shipping_price">
                            <label for="shipping_km">Պատվերի հեռավորությունը</label>
                            <input type="hidden" name="shipping_km" class="w-50 form-control shipping_km"
                                   value=""><span id="shipping_km"></span> Կմ
                        </div>
                        <div class="form-group shipping_price">
                            <label for="address">Պատվերի հասցեն</label>
                            <input type="hidden" name="address" class="w-50 form-control address"
                                   value=""><span id="address"></span>
                        </div>
                        <input type="hidden" name="lat" value="" id="lat">
                        <input type="hidden" name="lng" value="" id="lng">
                    </div>
                    <label>Խնդռւմ ենք տեղափոխել միայն b կետը</label>
                    <div id="map" class="d-none"></div>
{{--                    <div id="sidebar">--}}
{{--                        <p>Total Distance: <span id="total"></span></p>--}}
{{--                        <div id="panel"></div>--}}
{{--                    </div>--}}
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary">Պահպանել</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <input type="hidden" id="courier_shipping_price" value="{{\App\Constants\Parameters::COURIER_SHIPPING_PRICE}}">
    <input type="hidden" id="courier_shipping_min_price" value="{{\App\Constants\Parameters::COURIER_SHIPPING_MIN_PRICE}}">
    <input type="hidden" id="courier_shipping_min_km" value="{{\App\Constants\Parameters::COURIER_SHIPPING_MIN_KM}}">
@endsection
