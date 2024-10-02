@extends('layouts.app')

@section('content')
    <section class="container w-100 d-flex justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Ավելացնել Էջ</h3>
                    </div>
                </div>
                <form action="{{route('pages.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Անուն</label>
                            <input type="text" name="title" class="form-control"
                                   value=""
                                   placeholder="Մուտքագրեք էջի անունը">
                        </div>
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label>Նկարագրություն</label>
                            <textarea type="text" name="body" class="form-control"
                                      placeholder="Մուտքագրեք էջի նկարագրությունը"></textarea>
                        </div>
                        @error('body')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control"
                                      placeholder="slug">
                        </div>
                        @error('slug')
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
