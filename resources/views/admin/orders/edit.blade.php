@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center order-edit">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել էջը</h3>
                    </div>
                </div>
                <form action="{{route('orders.update',['order' => $order])}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Պատվիրողի տվյալներ</label>
                            <input disabled type="text" class="form-control mb-2"
                                   value="Անուն ազգանուն։ {{$order->user->first_name . ' ' . $order->user->last_name}}">
                            <input disabled type="text" class="form-control mb-2"
                                   value="Էլ․ հասցե։ {{$order->user->email}}">
                            <input disabled type="text" class="form-control mb-2"
                                   value="Հեռախոսահամար։ {{$order->user->phone}}">
                        </div>
                        @if(!empty($order->master))
                            <div class="form-group">
                                <label for="title">Ծառայություն մատուցողի տվյալներ</label>
                                <input disabled type="text" class="form-control mb-2"
                                       value="Անուն ազգանուն։ {{$order->master->first_name . ' ' . $order->master->last_name}}">
                                <input disabled type="text" class="form-control mb-2"
                                       value="Էլ․ հասցե։ {{$order->master->email}}">
                                <input disabled type="text" class="form-control mb-2"
                                       value="Հեռախոսահամար։ {{$order->master->phone}}">
                            </div>
                        @endif
                        @if(!empty($order->driver))
                            <div class="form-group">
                                <label for="title">Առաքիչի տվյալներ</label>
                                <input disabled type="text" class="form-control mb-2"
                                       value="Անուն ազգանուն։ {{$order->driver->first_name . ' ' . $order->driver->last_name}}">
                                <input disabled type="text" class="form-control mb-2"
                                       value="Էլ․ հասցե։ {{$order->driver->email}}">
                                <input disabled type="text" class="form-control mb-2"
                                       value="Հեռախոսահամար։ {{$order->driver->phone}}">
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!empty($order->products))
                            @foreach($order->products as $product)
                                <div class="form-group">
                                    <label for="title">Ապրանք</label>
                                    <h3>Անուն։ {{$product->product->title}}</h3>
                                    <img src="{{$product->product->mainImage->thumb_url}}" width="200" height="200">
                                    <input disabled type="text" class="form-control mb-2"
                                           value="Քանակ։ {{$product->count}}">
                                    <input disabled type="text" class="form-control mb-2"
                                           value="Գին։ {{$product->count * $product->product->price}}">
                                </div>
                            @endforeach
                        @endif
                        @if(!empty($order->shop))
                            <div class="form-group">
                                <label for="title">Խանութ</label>
                                <input disabled type="text" class="form-control mb-2"
                                       value="Անուն։ {{$order->shop->name}}">
                            </div>
                        @endif
                        @if(!empty($order->products->services))
                            @foreach($order->products->services as $service)
                                @if($service->service)
                                    <div class="form-group">
                                        <label for="title">Ծառայություն</label>
                                        <h3>Անուն։ {{$service->service->title}}</h3>
                                        <input disabled type="text" class="form-control mb-2"
                                               value="Անուն։ {{$service->service->title}}">
                                        <input disabled type="text" class="form-control mb-2"
                                               value="Գին։ {{$service->$service->price}}">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Պատվերի մանրամասներ</label>
                            <input disabled type="text" class="form-control mb-2"
                                   value="Առաքման գին։ {{$order->shipping_price}} դր">
                            <input disabled type="text" class="form-control mb-2"
                                   value="Առաքման հեռավորությունը։ {{$order->shipping_km}}կմ">
                            <input disabled type="text" class="form-control mb-2"
                                   value="Ընդհանուր գին։ {{$order->total}} դր">
                            <?php
                            $has_map = false;
                            if ($order->status === 'pending') {
                                $status = 'սպասման մեջ';
                            } else {
                                $status = 'Պատվիրված։ սպասում է կատարման';
                                if ($order->state == 'accepted') {
                                    $has_map = true;
                                    $state = 'ընդունված առաքիչի կողմից';
                                    $start_lat = $order->lat;
                                    $start_lng = $order->lng;
                                    if($order->driver_id){
                                        $end_lat = $order->driver->current_lat;
                                        $end_lng = $order->driver->current_long;
                                    }elseif($order->master){
                                        $end_lat = $order->master->current_lat;
                                        $end_lng = $order->master->current_long;
                                    }
                                } elseif ($order->state == 'cancelled') {
                                    $state = 'չեղարկված';
                                } else if($order->state == 'pending'){
                                    $state = 'սպասման մեջ';
                                }else{
                                    $status = 'ավարտված';
                                }
                            }
                            ?>
                            <input disabled type="text" class="form-control mb-2"
                                   value="Կարգավիճակ։ {{$status}}">
                            @if($order->status === 'success')
                                <input disabled type="text" class="form-control mb-2"
                                       value="Կարգավիճակ։ {{$state}}">
                            @endif
                        </div>
                    </div>
                    @if($has_map)
                        <input type="hidden" value="{{$start_lat ?? 0}}" id="start_lat">
                        <input type="hidden" value="{{$start_lng ?? 0}}" id="start_lng">
                        <input type="hidden" value="{{$end_lat ?? 0}}" id="end_lat">
                        <input type="hidden" value="{{$end_lng ?? 0}}" id="end_lng">
                        <div id="map"></div>
                    @endif
                    <div class="card-footer">
                        <a href="{{route('orders.index')}}" class="btn btn-secondary">Հետ</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
