<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Http\Resources\AssetResource;
use Carbon\Carbon;

class UploadController extends Controller
{
    public function upload(UploadRequest $request)
    {
        if ($request->file('upload')) {
            $file = $request->file('upload');
            $ext = $file->getClientOriginalExtension();
            $name = Carbon::now()->timestamp . uniqid() . Carbon::now()->timestamp . uniqid() . '.' . $ext;
            $folderName = Carbon::now()->format('Y_m_d');
            $path = 'uploads/';
//            if (!file_exists(public_path($path.$folderName))) {
//                mkdir(public_path($path.$folderName), 0775, true);
//            }
            if ($p = $file->storeAs('/public/' . $path . $folderName, $name)) {
                return [
                    'name' => $name,
                    'path' => $path . $folderName . '/' . $name,
                    'url' => url('/storage/' . $path . $folderName . '/' . $name)
                ];
            } else {
                return $this->createError('file', 'فایل ذخیره نشد', 500);
            }
        } else {
            return $this->createError('file', 'فایل را انتخاب کنید', 404);
        }
    }
}
