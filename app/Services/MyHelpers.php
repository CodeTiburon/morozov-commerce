<?php namespace App\Services;

use Validator;

class MyHelpers {

    public static function imagesUpload($files) {
        // start count how many uploaded
        $uploadcount = 0;
        foreach($files as $file) {
            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file'=> $file), $rules);
            if($validator->passes()){
                $image = \Image::make($file);
                $path = base_path().'/public/uploads/';
                //make prefix
                $imagePrefix = uniqid('image_');
                // encode image to png
                $image->encode('png');
                // save original
                $image->save($path.$imagePrefix."_original.png");
                //resize
                $image->resize(320, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                // save resized
                $image->save($path.$imagePrefix."_resized.png");
                $uploadcount ++;
            }
        }
        return Array('count' => $uploadcount, 'validator' => $validator);
    }

}
