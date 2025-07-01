<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function store(UploadedFile $image, string $directory)
    {
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $slugName = str()->slug(strtolower($nameWithoutExtension));
        $uniqueId = uniqid();
        $newImageName = $slugName . '-' . $uniqueId . '.' . $extension;
        $image->move(public_path('uploads/' . $directory . '/'), $newImageName);
        if (in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
            $type = 'video';
        } elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            $type = 'image';
        } elseif (in_array(strtolower($extension), ['pdf'])) {
            $type = 'pdf';
        } else {
            $type = 'file';
        }
        return [
            'filename' => $newImageName,
            'type' => $type
        ];
    }
    public static function update(UploadedFile $image, string $directory, string $oldImage)
    {
        $imagePath = public_path('uploads/' . $directory . '/' . $oldImage);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $slugName = str()->slug(strtolower($nameWithoutExtension));
        $uniqueId = uniqid();
        $newImageName = $slugName . '-' . $uniqueId . '.' . $extension;
        $image->move(public_path('uploads/' . $directory . '/'), $newImageName);
        if (in_array(strtolower($extension), ['mp4', 'webm', 'ogg'])) {
            $type = 'video';
        } else {
            $type = 'image';
        }
        return [
            'filename' => $newImageName,
            'type' => $type
        ];
    }
    public static function destroy(string $image, string $directory)
    {
        $imagePath = public_path('uploads/' . $directory . '/' . $image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    public static function storeJSON($json)
    {
        $jsonFilename = uniqid() . '.json';
        $jsonPath = Storage::disk('r2')->put($jsonFilename, $json);
        Log::info("JSON file uploaded to R2: $jsonFilename");
        Log::info("JSON file status: $jsonPath");
        return $jsonFilename;
    }
    public static function getJSON($jsonFilename)
    {
        if ($jsonFilename === null) {
            return null;
        }
        if (!Storage::disk('r2')->exists($jsonFilename)) {
            return null;
        }
        $json = Storage::disk('r2')->get($jsonFilename);
        return json_decode($json, true);
    }
    public static function destroyJSON($jsonFilename)
    {
        if ($jsonFilename === null) {
            return null;
        }
        if (!Storage::disk('r2')->exists($jsonFilename)) {
            return null;
        }
        return Storage::disk('r2')->delete($jsonFilename);
    }
}