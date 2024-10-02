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
                <form action="{{route('custom-fields.update',['custom_field' => $custom_field])}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Անուն</label>
                            <input type="text" name="name" class="form-control" id="title"
                                   value="{{$custom_field->name}}"
                                   placeholder="">
                        </div>
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="name_en">Անուն անգլերեն</label>
                            <input type="text" name="name_en" class="form-control" id="name_en"
                                   value="{{$custom_field->name_en}}"
                                   placeholder="">
                        </div>
                        @error('name_en')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="name_ru">Անուն ռուսերեն</label>
                            <input type="text" name="name_ru" class="form-control" id="name_ru"
                                   value="{{$custom_field->name_ru}}"
                                   placeholder="">
                        </div>
                        @error('name_ru')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="group">Group</label>
                            <input type="text" name="group" class="form-control" id="gruop"
                                   value="{{$custom_field->group}}">
                        </div>
                        @error('title')
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
