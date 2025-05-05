<?php

namespace App\Helpers;

use App\Exceptions\ImageConversionException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageHelper {

    public function saveImage(string $base64):string {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $image = substr($base64, strpos($base64, ',') + 1);
            $extension = strtolower($type[1]);

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new ImageConversionException("Invalid image format");
            }

            $image = base64_decode($image);

            if ($image === false) {
                throw new ImageConversionException("Invalid image base64");
            }
        } else {
            throw new ImageConversionException("Invalid image format");
        }

        $fileName = Str::random(10) . '.' . $extension;

        $filePath = public_path('uploads/' . $fileName);

        if (!File::exists(public_path('uploads'))) {
            File::makeDirectory(public_path('uploads'), 0755, true);
        }

        File::put($filePath, $image);

        return asset('uploads/' . $fileName);
    }
}
