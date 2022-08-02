<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Cloudinary\Cloudinary;

class ImageRepository
{

  public function setImageInfo($invitation, $rallye_name, $group_name)
  {
    $imageName = $invitation->id . '_' . $group_name . '_' . $invitation->theme_dress_code . '.' . $invitation->extension;
    $imageExpirationDate = Carbon::create($invitation->group->eventDate)->addMonths(2);
    $imageMetadata = ["dress code" => $invitation->theme_dress_code, "name" => $imageName, "expiration date" => $imageExpirationDate, "rallye" => $rallye_name, "group" => $group_name];
    $fullImagePath = "/assets/images/invitations/" . $rallye_name . "/" . $imageName;
    return ["imageName" => $imageName, "imagePath" => $fullImagePath, "imageMetadata" => $imageMetadata];
  }

  public function UploadFromImage64($image64, $extension, $rallye_name, $group_name, $image_full_path, $imageMetadata)
  {
    $image = $image64;  // your base64 encoded
    $image = str_replace('data:image/' . $extension . ';base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    Log::stack(['single', 'stdout'])->debug("Image Path in UploadFromImage64() : " . $image_full_path);

    # upload in local filesystem
    Storage::disk('public')->put($image_full_path, base64_decode($image));
    Log::stack(['single', 'stdout'])->debug("Image stored in UploadFromImage64() : " . public_path($image_full_path));
    Log::stack(['single', 'stdout'])->debug("Image name  for cloudinary search : " . $imageMetadata["name"]);

    # upload in Cloudinary
    $expression = $imageMetadata["name"] . ' AND folder=Invitations/' . $rallye_name;
    //$expression = $imageMetadata["name"];

    $cloudinary = new Cloudinary();
    $resultSearch = $cloudinary->searchApi()
      ->expression($expression)
      ->maxResults(1)
      ->execute();
    // Log::stack(['stdout'])->debug("[MYSELF MAIL] : Search result count : " . $resultSearch["total_count"]);
    // dd($resultSearch);

    if ($resultSearch["total_count"] > 0) {
      $imageURL = $resultSearch["resources"][0]["secure_url"];
    } else {
      $imageURL = cloudinary()->upload($image64, ["folder" => "Invitations/" . $rallye_name,  "filename_override" => $imageMetadata["name"], "tags" => [$imageMetadata["name"], $imageMetadata["dress code"]], "context" => $imageMetadata])->getSecurePath();
    }
    Log::stack(['single', 'stdout'])->debug("Public Image URL in UploadFromImage64() : " . public_path($image_full_path));

    return $imageURL;
  }


  public function destroyImage64($rallye_name, $image_full_path, $imageMetadata)
  {
    // $image = $image64;  // your base64 encoded
    // $image = str_replace('data:image/' . $extension . ';base64,', '', $image);
    // $image = str_replace(' ', '+', $image);

    // Log::stack(['single', 'stdout'])->debug("Image Path in UploadFromImage64() : " . $image_full_path);

    // # upload in local filesystem
    // Storage::disk('public')->put($image_full_path, base64_decode($image));
    Log::stack(['single', 'stdout'])->debug("Image stored in UploadFromImage64() : " . public_path($image_full_path));
    Log::stack(['single', 'stdout'])->debug("Image name for cloudinary search : " . $imageMetadata["name"]);

    # upload in Cloudinary
    $expression = $imageMetadata["name"] . ' AND folder=Invitations/' . $rallye_name;
    //$expression = $imageMetadata["name"];

    $cloudinary = new Cloudinary();
    $resultSearch = $cloudinary->searchApi()
      ->expression($expression)
      ->maxResults(1)
      ->execute();
    //dd($resultSearch);

    if ($resultSearch["total_count"] > 0) {
      $public_id = $resultSearch["resources"][0]["public_id"];
      $cloudinary->uploadApi()->destroy($public_id);
      Log::stack(['stdout'])->info("[CLOUDINARY]:  asset " . $public_id . " successfully deleted");
    }
    return true;
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

      //Log::stack(['single', 'stdout'])->debug( var_dump($image));

      if (is_resource($image) || $this->is_gd_image($image)) {
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
        Log::stack(['single', 'stdout'])->error(dd($image) . ' is not a correct resource');
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

  private function is_gd_image($var): bool
  {
    return (gettype($var) == "object" && get_class($var) == "GdImage");
  }
}
