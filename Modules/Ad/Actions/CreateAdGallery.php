<?php

namespace Modules\Ad\Actions;

use App\Actions\File\FileUpload;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdGallery;

class CreateAdGallery
{
    public static function create($request, $id)
    {

        // image uploading
        $images = $request->file('images');
        if ($images) {
            foreach ($images as $image) {
                if ($image && $image->isValid()) {

                    $url = uploadAdImage($image, 'adds_multiple', true);
                    AdGallery::create([
                        'ad_id' => $id,
                        'image' => $url,
                    ]);
                }
            }
        }
        // foreach ($request->file as $image) {
        //     if ($image && $image->isValid()) {

        //         $url = uploadImage($image, 'addss_multiple', true);

        //         AdGallery::create([
        //             'ad_id' => $id,
        //             'image' => $url,
        //         ]);
        //     }
        // }

        return true;
    }
}
