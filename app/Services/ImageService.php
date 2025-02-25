<?php
namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService{
    public function upload(UploadedFile $file){
        return $file->store('images', 'public');
    }

    public function update(string $image_url, UploadedFile $file)
    {
            if (!empty($image_url) && Storage::disk('public')->exists($image_url)) {
                $this->delete($image_url);
            return $this->upload($file);
        }
    }
    public function delete(string $image_url){
        Storage::disk('public')->delete($image_url);
    }
}
