<?php

namespace SeventhSense\OpenCV;

use Illuminate\Support\Facades\Http;

class FaceRecognition
{
    protected $apiKey;

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function searchPersonByImage($imagePath)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->attach(
            'file', file_get_contents($imagePath), 'image.jpg'
        )->post('https://api.seventhsense.ai/v1/search/person');

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
