@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել կատեգորիան</h3>
                        <span class="visible"><i data-item-id="{{$category->id}}" class="fa fa-eye category"></i></span>
                    </div>
                </div>
                <form action="{{route('categories.update',['category' => $category])}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Անուն</label>
                            <input type="text" name="title" class="form-control" id="name"
                                   value="{{!empty($category->title) ? $category->title: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_en">Անուն անգլերեն</label>
                            <input type="text" name="title_en" class="form-control" id="title_en"
                                   value="{{!empty($category->title_en) ? $category->title_en: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_ru">Անուն ռուսերեն</label>
                            <input type="text" name="title_ru" class="form-control" id="title_ru"
                                   value="{{!empty($category->title_ru) ? $category->title_ru: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description">Նկարագրություն</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   value="{{!empty($category->description) ? $category->description: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_en">Նկարագրություն անգլերեն</label>
                            <input type="text" name="description_en" class="form-control" id="description_en"
                                   value="{{!empty($category->description_en) ? $category->description_en: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_ru">Նկարագրություն ռուսերեն</label>
                            <input type="text" name="description_ru" class="form-control" id="description_ru"
                                   value="{{!empty($category->description_ru) ? $category->description_ru: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="parent_id">Ընտրել ծնող կատեգորիան</label>
                            <select name="parent_id" id="parent_id">
                                <option value="0">Սա ծնող կատեգորիա է</option>
                                @foreach($categories as $parent_category)
                                    <option {{$parent_category->id == $category->parent_id ? 'selected': ''}} value="{{$parent_category->id}}">
                                        {{Str::title($parent_category->title)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('parent_id')
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
