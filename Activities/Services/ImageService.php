<?php

namespace Activities\Services;

class ImageService {

    public $basePath;

    public function __construct()
    {
        $this->basePath = trim(BASE_PATH, '/');
    }


    public function saveImage($image, $imagePath, $imageName = null)
    {
        $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

        if(!in_array($image['type'], $allowedType)) {
            return false;
        }


        $extension = pathinfo($image['name'], PATHINFO_EXTENSION); 

        if($imageName) {
            $imageName = $imageName . '.' . $extension;
        } else {
            $uniqueId = bin2hex(random_bytes(8));
            $imageName = date('Y-m-d-H-m-s') . '-' . $uniqueId . '.' . $extension;
        }

        $imageTemp = $image['tmp_name'];
        $imageFullPath = $this->basePath . '/' . 'public' . '/' . trim($imagePath, '/');

        if(!is_dir($imageFullPath)) {
            mkdir($imageFullPath);
        }


        $destintion = $imageFullPath . '/' . $imageName;

        if(is_uploaded_file($imageTemp)) {
            if(move_uploaded_file($imageTemp, $destintion)) {
                return 'public/' . trim($imagePath, '/\\') . '/' . $imageName;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }



    public function removeImage($image)
    {   
        $fullPath = $this->basePath . '/' . trim($image, '/\\');
        
        if(file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}