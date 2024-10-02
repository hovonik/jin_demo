@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Խմբագրել մասնագիտությունը</h3>
                        <span class="visible"><i data-item-id="{{$profession->id}}" class="fa fa-eye profession"></i></span>
                    </div>
                </div>
                <form action="{{route('professions.update',['profession' => $profession])}}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Անուն</label>
                            <input type="text" name="title" class="form-control" id="name"
                                   value="{{!empty($profession->title) ? $profession->title: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_en">Անուն անգլերեն</label>
                            <input type="text" name="title_en" class="form-control" id="title_en"
                                   value="{{!empty($profession->title_en) ? $profession->title_en: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="title_ru">Անուն ռուսերեն</label>
                            <input type="text" name="title_ru" class="form-control" id="title_ru"
                                   value="{{!empty($profession->title_ru) ? $profession->title_ru: ''}}"
                                   placeholder="Մուտքագրեք անունը">
                        </div>
                        @error('title_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description">Նկարագրություն</label>
                            <input type="text" name="description" class="form-control" id="description"
                                   value="{{!empty($profession->description) ? $profession->description: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_en">Նկարագրություն անգլերեն</label>
                            <input type="text" name="description_en" class="form-control" id="description_en"
                                   value="{{!empty($profession->description_en) ? $profession->description_en: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_en')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="description_ru">Նկարագրություն ռուսերեն</label>
                            <input type="text" name="description_ru" class="form-control" id="description_ru"
                                   value="{{!empty($profession->description_ru) ? $profession->description_ru: ''}}"
                                   placeholder="Մուտքագրեք նկարագրությունը">
                        </div>
                        @error('description_ru')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="slug">SLUG</label>
                            <input type="text" name="slug" class="form-control" id="slug"
                                   value="{{$profession->slug}}">
                        </div>
                        @error('slug')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="parent_id">Ընտրել ծնող մասնագիտությունը</label>
                            <select name="parent_id" id="parent_id">
                                <option value="0">Սա ծնող մասնագիտություն է</option>
                                @foreach($professions as $parent_profession)
                                    <option {{$parent_profession->id == $profession->parent_id ? 'selected': ''}} value="{{$parent_profession->id}}">
                                        {{Str::title($parent_profession->title)}}
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
