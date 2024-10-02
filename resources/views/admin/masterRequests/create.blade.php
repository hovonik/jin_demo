@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել ապրանքը</h3>
                    </div>
                </div>
                <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Անուն</label>
                            <input type="text" name="title" class="form-control" id="title"
                                   value=""
                                   placeholder="Մուտքագրեք ապրանքի անունը">
                        </div>
                        <div class="form-group">
                            <label for="code">Կոդ</label>
                            <input type="text" name="code" class="form-control" id="code"
                                   value=""
                                   placeholder="Մուտքագրեք ապրանքի կոդը">
                        </div>
                        @error('title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label>Կատեգորիա</label>
                            <select name="category_id" class="form-control">
                                @if(!empty($categories))
                                    @foreach($categories as $k => $category)
                                        <optgroup label="{{Str::title($category->title)}}">
                                            @foreach($category['child_categories'] as $key => $child)
                                                <option style="padding-left: 40px" {{$key === 0 && $k === 0 ? 'selected': ''}} value="{{$child->id}}">
                                                    {{Str::title($child->title)}}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('category')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description">Նկարագրություն</label>
                            <textarea id="description" type="text" name="description" class="form-control" ></textarea>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label for="price">Գին</label>
                                <input min="0" type="text" name="price" class="form-control" id="price"
                                       value=""
                                       placeholder="Մուտքագրեք ապրանքի գինը">
                            </div>
                            <div class="col">
                                <label for="sale_price">Զեղչված գին</label>
                                <input min="0" type="text" name="sale_price" class="form-control" id="sale_price"
                                       value=""
                                       placeholder="Մուտքագրեք ապրանքի զեղչված գինը">
                            </div>
                            <div class="col">
                                <label for="count">Քանակ</label>
                                <input type="text" name="count" class="form-control" id="count"
                                       value=""
                                       placeholder="Մուտքագրեք ապրանքի քանակը">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="search_keywords">Որոնման բանալի բառեր</label>
                            <textarea id="search_keywords" type="text" name="search_keywords" class="form-control" ></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ընտրել ապրանքին համապատասխան ծառայությունները</label>
                            <select name="service_id[]" class="form-control" multiple>
                                @if(!empty($services))
                                    @foreach($services as $key => $service)
                                        <option style="padding-left: 40px" {{$key === 0 ? 'selected': ''}} value="{{$service->id}}">
                                            {{Str::title($service->title)}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('service_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="shop_id">Ապրանքի Խանութը</label>
                            <select name="shop_id" class="form-control" id="shop_id">
                                @if(!empty($shops))
                                    @foreach($shops as $key => $shop)
                                        <option style="padding-left: 40px" {{$key === 0 ? 'selected': ''}} value="{{$shop->id}}">
                                            {{Str::title($shop->name)}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Գլխավոր նկար</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input style="cursor: pointer" type="file" name="main_image" class="custom-file-input"
                                           id="main_image">
                                    <label class="custom-file-label" for="main_image">Ընտրեք գլխավոր նկարը</label>
                                </div>
                            </div>
                            <img class="mt-3" src="" id ="main_image_preview" alt="test" width="128" height="128" />
                            @error('main_image')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Նկարներ</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input style="cursor: pointer" type="file" name="images[]" multiple class="custom-file-input"
                                           id="images">
                                    <label class="custom-file-label" for="images">Ընտրեք հավելյալ նկարները</label>

                                </div>
                            </div>
                            <div class="images mt-3">
                                <input type="hidden" class="last_image_id" value="0">
                            </div>
                            @error('images')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary">Պահպանել</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
