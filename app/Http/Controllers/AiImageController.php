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
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}", [
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

        // Generate Image using Pollinations.ai (Reliable Free Alternative)
        // Since Google's free tier has limitations on image models, we use Pollinations for guaranteed results.
        
        $encodedPrompt = urlencode($prompt);
        $imageUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1024&height=1024&seed=" . rand(1, 10000) . "&model=flux";

        try {
            // Fetch the image content
            $imageContent = file_get_contents($imageUrl);
            
            if ($imageContent !== false) {
                $base64Image = base64_encode($imageContent);
                return view('ai.image', ['image' => $base64Image, 'prompt' => $request->input('prompt'), 'refined_prompt' => $prompt]);
            } else {
                return back()->with('error', 'Failed to retrieve image from generator.');
            }
        } catch (\Exception $e) {
             return back()->with('error', 'Generation Error: ' . $e->getMessage());
        }
    }
}
