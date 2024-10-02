<?php use Illuminate\Support\Str; ?>
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Վարպետների դիմումներ</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if($users->count())
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th style=" width: 15px">Օգտվողի համարը</th>
                        <th>Օգտվողի անուն ազգանուն</th>
                        <th>Գործողություն</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr data-item-id="{{$user->id}}">
                            <td>
                                {{$user->id}}
                            </td>
                            <td>
                                <a class="nav-link"
                                   href="{{route('users.edit',['user' => $user])}}">
                                    {{Str::title($user->first_name)}} {{Str::title($user->last_name)}}
                                </a>
                            </td>
                            <td>
                                <a class="nav-link"
                                   href="{{route('users.edit',['user' => $user])}}">
                                    Դիտել
                                </a>
                                <button class="item-del-btn btn ml-2 btn-sm btn-danger user" data-item-id="{{$user->id}}">
                                    Ջնջել
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Դիմումներ չկան</p>
            @endif
        </div>
        <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{$users->links()}}
                </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.prod-del-btn').on('click', function () {
                let prod_id = $(this).data('prod-id');
                if (confirm('Դուք վստահ եք?')) {
                    $.ajax({
                        url: base_url + `/products/${prod_id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data.success) {
                                $('#main-div').prepend(`<div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    ${data.message}
                                    </div>`);
                                $(`[data-prod-item-id = ${prod_id}]`).remove();
                                if ($('tr').length <= 1) {
                                    location.reload();
                                }
                            } else {
                                $('#main-div').prepend(`<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                     ${data.error}
                                    </div>`);
                            }
                            setTimeout(function () {
                                $('.alert.alert-dismissible').hide();
                            }, 5000)
                        }, error: function (err) {
                            alert('Փործել ավելի ուշ');
                        }
                    });
                }
            })
        })
    </script>
@endsection
