<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class AiImageController extends Controller
{
    public function index()
    {
        return view('ai.image');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'image_file' => 'nullable|image|max:4096', // Max 4MB
        ]);

        $prompt = $request->input('prompt');
        $apiKey = env('GEMINI_API_KEY', 'AIzaSyBb8ZuG7hbAnI8N75R6aHufEOUM0cUPzL8');

        if (!$apiKey) {
            return back()->with('error', 'API Key not configured.');
        }

        // Logic: If image is provided, we use Gemini 1.5 Flash to analyze it first
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->getRealPath();
            $imageData = base64_encode(file_get_contents($imagePath));
            $mimeType = $request->file('image_file')->getMimeType();

            // Ask Gemini to describe the image based on user prompt context
            $analysisResponse = Http::withoutVerifying()->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Analyze this image and the user's style request: '{$prompt}'. Create a detailed image generation prompt that captures the essence of this image but applies the requested style. output ONLY the prompt."],
                                ['inline_data' => ['mime_type' => $mimeType, 'data' => $imageData]]
                            ]
                        ]
                    ]
                ]);

            if ($analysisResponse->successful()) {
                $prompt = $analysisResponse->json()['candidates'][0]['content']['parts'][0]['text'];
            } else {
                 return back()->with('error', 'Failed to analyze uploaded image.');
            }
        }

        // Generate Image using Imagen 3
        $url = "https://generativelanguage.googleapis.com/v1beta/models/imagen-3.0-generate-001:predict?key={$apiKey}";

        $response = Http::withoutVerifying()->withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'instances' => [['prompt' => $prompt]],
            'parameters' => ['sampleCount' => 1]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['predictions'][0]['bytesBase64Encoded'])) {
                $image = $data['predictions'][0]['bytesBase64Encoded'];
                return view('ai.image', ['image' => $image, 'prompt' => $request->input('prompt'), 'refined_prompt' => $prompt]);
            }
        }
        
        return back()->with('error', 'Create Style Error: ' . $response->body());
    }
}
