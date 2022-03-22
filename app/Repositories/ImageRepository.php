<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ImageRepository
{

  public function ConvertImage64ToImage($image64, $extension)
  {
    $image = $image64;  // your base64 encoded
    $image = str_replace('data:image/' . $extension . ';base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageName = Str::random(10) . '.' . $extension;
    // Log::stack(['single', 'stdout'])->debug("Image Name in ConvertImage64ToImage() : " . $imageName);
    Storage::disk('local')->put("uploads/images/" . $imageName, base64_decode($image));
    return $imageName;
  }
  /**
   * Rezise an image with a max value
   *
   * @param  string  $source : filepath of source file
   * @param  string  $destination : filepath for result file
   * @param  string  $ext : extension of the image
   * @param  int  $maxvlalue : max value wanted for width or height
   * @return : new image created
   */
  public function resizeImage(string $source, string $destination, string $ext, int $maxvalue)
  {
    // Content type
    //header('Content-Type: image/' . $ext);

    [$width, $height] = getimagesize($source);
    Log::stack(['single', 'stdout'])->debug("width: $width - height: $height");
    if ($width >= $maxvalue || $height >= $maxvalue) {
      $newwidth = $maxvalue;
      $newheight = ($maxvalue / $width) * $height;
      Log::stack(['single', 'stdout'])->debug("newwidth: $newwidth - newheight: $newheight");
    } else {
      $newwidth = $width;
      $newheight = $height;
    }

    // (C) RESIZE
    // Respective PHP image functions
    $fnCreate = "imagecreatefrom" . ($ext == "jpg" ? "jpeg" : $ext);
    $fnOutput = "image" . ($ext == "jpg" ? "jpeg" : $ext);

    // Image objects
    $original = $fnCreate($source);
    $resized = imagecreatetruecolor($newwidth, $newheight);

    // Redimensionnement
    imagecopyresized($resized, $original, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // (D) OUTPUT & CLEAN UP
    $fnOutput($resized, $destination);

    if ($ext == 'png') {
      imagepng($resized, $destination);
    }
    if ($ext == 'jpg' || $ext == 'jpeg') {
      imagejpeg($resized, $destination);
    }

    imagedestroy($original);
    imagedestroy($resized);
  }

  /**
   * Manage orientation (landscape/portrait) of a file resized.
   * Sometimes after a resizing the orientation change but it is not wanted.
   *
   * @param  string  $filePath : path to the file
   * @param  string  $ext : extension file
   * @param  string  $orientation : orientation to know if we need to rotate file or not
   * @return : file size converted and formatted
   */
  public function rotateImageByExifOrientation($filePath, $ext, $orientation)
  {
    $result = null;

    if ($orientation) {
      if ($ext == 'png') {
        $image = imagecreatefrompng($filePath);
      }
      if ($ext === 'jpg' || $ext === 'jpeg') {
        $image = imagecreatefromjpeg($filePath);
      }

      if (is_resource($image)) {
        switch ($orientation) {
          case 3:
            $result = imagerotate($image, 180, 0);
            break;
          case 6:
            $result = imagerotate($image, -90, 0);
            break;
          case 8:
            $result = imagerotate($image, 90, 0);
            break;
        }
      } else {
        Log::stack(['single'])->error($filePath . ' is not a correct resource');
      }
    }

    return $result;
  }
  /**
   * This method is just for debug and showing Bytes converted in Ko or Mo.
   *
   * @param  string  $number : file size in Bytes
   * @return : file size converted and formatted
   */
  private function returnFileSize($number)
  {
    if ($number < 1024) {
      return $number + ' octets';
    } else if ($number >= 1024 && $number < 1048576) {
      return round(($number / 1024), 1) . ' Ko';
    } else if ($number >= 1048576) {
      return round(($number / 1048576), 1) . ' Mo';
    }
  }
}
