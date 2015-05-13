<?php namespace App\Services;

use Validator;
use App\Models\Category;

class MyHelpers {

    public static function imagesUpload($files, $imageSize = 1024, $imageEncodeTo = 'png', $saveOriginal = false, $preventUpsize = true) {
        // start count how many uploaded
        $uploadcount = 0;
        $imagesArr = array();
        $path = base_path().'/public/uploads/';
        foreach($files as $file) {
            $image = \Image::make($file);
            //make prefix
            $imagePrefix = date('Y-m-d-H:i:s')."-".$file->getClientOriginalName();
            // encode image to png
            $image->encode($imageEncodeTo);
            // save original
            if($saveOriginal){
                $image->save($path.$imagePrefix."_original.png");
            }
            //resize
            $image->resize(null, $imageSize, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // save resized
            $imgName = $imagePrefix."_resized.png";
            $image->save($path.$imgName);
            $imagesArr[] = $imgName;
            $uploadcount ++;
        }
        return Array('count' => $uploadcount, 'path' => $path, 'images' => $imagesArr);
    }

    public function categoriesSeed(){
        $categories = [
            ['id' => 1, 'name' => 'TV & Home Theather'],
            ['id' => 2, 'name' => 'Tablets & E-Readers'],
            ['id' => 3, 'name' => 'Computers', 'children' => [
                ['id' => 4, 'name' => 'Laptops', 'children' => [
                    ['id' => 5, 'name' => 'PC Laptops'],
                    ['id' => 6, 'name' => 'Macbooks (Air/Pro)']
                ]],
                ['id' => 7, 'name' => 'Desktops', 'children' => [
                    // These will be created
                    ['name' => 'Towers Only'],
                    ['name' => 'Desktop Packages'],
                    ['name' => 'All-in-One Computers'],
                    ['name' => 'Gaming Desktops']
                ]]
                // This one, as it's not present, will be deleted
                // ['id' => 8, 'name' => 'Monitors'],
            ]],
            ['id' => 9, 'name' => 'Cell Phones']
        ];

        Category::buildTree($categories); // => true
    }

}
