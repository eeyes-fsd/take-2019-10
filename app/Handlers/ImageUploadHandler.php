<?php

namespace App\Handlers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allowed_ext = ['jpeg', 'jpg', 'png', 'gif'];

    public function save($file, $folder, $file_prefix, $max_width=false)
    {
        // 按日期分割目录
        /** @var string $folder_name */
        $folder_name = '/storage/uploads/images/' . $folder . '/' . date("Ym/d", time());

        // 存储文件的目录
        /** @var string $upload_path */
        $upload_path = public_path() . '/' . $folder_name;

        // 文件后缀名
        /** @var mixed $extension */
        $extension = strtolower($file->getClientOriginalExtension()) ?? 'png';

        // 拼接文件名
        /** @var string $filename */
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 如果不是图片后缀名则取消操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        // 将文件移动到指定目录
        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . $folder_name . '/' . $filename
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
