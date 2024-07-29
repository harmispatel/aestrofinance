<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
// use Intervention\Image\Facades\Image;

trait ImageTrait
{

    public function randomMediaName($limit)
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $max = strlen($string) - 1;
        $token = '';
        for ($i = 0; $i < $limit; $i++)
        {
            $token .= $string[mt_rand(0, $max)];
        }
        return $token;
    }

    // Upload Single Image
    public function addSingleImage($image_name,$path,$file,$old_image = null)
    {
        // Delete old Image if Exists
        if ($old_image != null && file_exists('public/images/uploads/'.$path.'/'.$old_image))
        {
            unlink('public/images/uploads/'.$path.'/'.$old_image);
        }

        // Upload New Image
        if ($file != null)
        {

            $filename = $image_name."_".$this->randomMediaName(5).".".$file->getClientOriginalExtension();


            // Image Upload Path
            $image_path = public_path().'/images/uploads/'.$path;

            // Get Image Path



            //     // $image->save($image_path.'/'.$filename);
                $file->move($image_path, $filename);

            return $filename;
        }
    }




}
