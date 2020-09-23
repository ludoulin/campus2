<?php

namespace App\Handlers;

use  Illuminate\Support\Str;

use Image;

class ImageUploadHandler
{
    // 只允許以下檔名的圖片檔案上傳
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 建構儲存的文件夾，如：uploads/images/avatars/201709/21/
        // 文件夾切割能讓找尋圖片效率更高。
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        // 文件具體儲存的物理路徑，`public_path()` 獲取的是 `public` 文件夹的物理路徑。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // 獲取文件的格式名稱，因圖片從剪貼簿裡貼上時时格式為空，所以這裡要確保格式一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前綴是為了增加辨析度，前綴可以是相關數據模型的ID 
        // 範例：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // 如果上傳的不是圖片將停止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 將圖片移動到我們的目標儲存路徑中
        $file->move($upload_path, $filename);

        // 如果限制了圖片寬度，就逕行裁剪
        if ($max_width && $extension != 'gif') {

            // 這個函數，用於裁剪
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先實例化，參數是文件的磁碟物理路徑
        $image = Image::make($file_path);

        // 進行大小調整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 設定寬度是 $max_width，高度等比例縮放
            $constraint->aspectRatio();

            // 防止截圖時圖片尺寸變大
            $constraint->upsize();
        });

        // 隊圖片修改後進行保存
        $image->save();
    }
}