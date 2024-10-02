<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\User;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function imgUpload(Request $request)
    {
        if (!$request->get('type')) {
            $path = 'public/all_images';
            $path_type = '/storage/all_images/';
        } elseif ($request->get('type') === 'avatar') {
            $path = 'public/avatars';
            $path_type = '/storage/avatars/';
            if ($request->user('api-user')){
//                dd(211);
                $path .= "/user" . $request->user('api-user')->id;
                $path_type .= "user" . $request->user('api-user')->id.'/';
            }elseif ($request->user('masters')){
                $path .= "/master" . $request->user('masters')->id;
                $path_type .= "master" . $request->user('masters')->id.'/';
            }
        } elseif ($request->get('type') === 'car') {
            $path = 'public/car_images';
            $path_type = '/storage/car_images/';
            if ($request->user('masters')){
                $path .= "/master" . $request->user('masters')->id;
                $path_type .= "master" . $request->user('masters')->id.'/';
            }
        } elseif ($request->get('type') === 'passport') {
            if (!empty($request->user('masters')->id)) {
                $path = 'public/passport';
                $path_type = '/storage/passport/';
                $path .= "/master" . $request->user('masters')->id;
                $path_type .= "master" . $request->user('masters')->id.'/';
            }
        } elseif ($request->get('type') === 'driver_license') {
            if (!empty($request->user('masters')->id)) {
                $path = 'public/driver_license';
                $path_type = '/storage/driver_license/';
                $path .= "/master" . $request->user('masters')->id;
                $path_type .= "master" . $request->user('masters')->id.'/';
            }
        }elseif ($request->get('type') === 'car_texpassport') {
            if (!empty($request->user('masters')->id)) {
                $path = 'public/car_texpassport';
                $path_type = '/storage/car_texpassport/';
                $path .= "/master" . $request->user('masters')->id;
                $path_type .= "master" . $request->user('masters')->id.'/';
            }
        }
        $request->file('image')->store($path);
        $img_name = $request->file('image')->hashName();
        return asset($path_type . $img_name);
    }

}
