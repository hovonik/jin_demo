@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել ծառայությունը</h3>
                    </div>
                </div>
                <form action="{{route('services.update',['service' => $service])}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Անուն</label>
                            <input type="text" name="title" class="form-control" id="name"
                                   value="{{$service->title}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_en">Անուն անգլերեն</label>
                            <input type="text" name="title_en" class="form-control" id="title_en"
                                   value="{{$service->title_en}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_ru">Անուն ռուսերեն</label>
                            <input type="text" name="title_ru" class="form-control" id="title_ru"
                                   value="{{$service->title_ru}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description">Նկարագրություն</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   value="{{$service->description}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_en">Նկարագրություն անգլերեն</label>
                            <input type="text" name="description_en" class="form-control" id="description_en"
                                   value="{{$service->description_en}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_ru">Նկարագրություն ռուսերեն</label>
                            <input type="text" name="description_ru" class="form-control" id="description_ru"
                                   value="{{$service->description_ru}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="price">Գին</label>
                            <input type="number" name="price" class="form-control" id="price"
                                   value="{{$service->price}}"
                                   placeholder="Մուտքագրեք գինը">
                        </div>
                        @error('price')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="min_time">Մինիմում ժամանակը</label>
                            <input type="number" name="min_time" class="form-control" id="min_time"
                                   value="{{$service->min_time}}"
                                   placeholder="Մինիմում ժամանակը">
                        </div>
                        @error('min_time')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="profession_id">Ընտրել մասնագիտությունը</label>
                            <select name="profession_id" class="form-control" id="profession_id">
                                @if(!empty($professions))
                                    @foreach($professions as $k => $profession)
                                        <option {{$service->profession_id === $profession->id ? 'selected' : ''}} value="{{$profession->id}}">{{Str::title($profession->title)}}</option>
                                        @if($profession['child_categories']->first())
                                            <optgroup label="{{Str::title($profession->title)}}">
                                                @foreach($profession['child_categories'] as $key => $child)
                                                    <option {{$service->profession_id === $child->id ? 'selected' : ''}} style="padding-left: 40px"
                                                            {{$key === 0 && $k === 0 ? 'selected': ''}} value="{{$child->id}}">
                                                        {{Str::title($child->title)}}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('parent_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-check form-switch">
                            <input type="checkbox" {{$service->has_service_price ? 'checked' : ''}} name="has_service_price" class="form-check-input" id="has_service_price" value="1">
                            <span><b>Ավելացնել ծառայության գինը</b></span>
                        </div>
                        @error('has_service_price')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <span><b>Ծառայության գինը հաշվել ըստ</b></span>
                        <div class="form-check">
                            <input type="checkbox" {{$service->charge_by == 'km' ? 'checked' : ''}} name="charge_by" class="form-check-input" id="form-check-km"
                                   value="km">
                            <span><i>Կիլոմետրերի</i></span>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" {{$service->charge_by == 'hours' ? 'checked' : ''}} name="charge_by" class="form-check-input" id="form-check-hours"
                                   value="hours">
                            <span><i>Ժամերի</i></span>
                        </div>
                        @error('charge_by')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary">Պահպանել</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
