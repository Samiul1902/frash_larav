<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\Staff;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function index()
    {
        return view('ai.chat');
    }

    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        // 1. Gather Context
        $services = Service::all();
        $staff = Staff::where('is_active', true)->get();
        
        $context = "You are the AI assistant for Smart Salon. \n";
        $context .= "We offer these services: \n";
        foreach ($services as $s) {
            $context .= "- {$s->title}: ৳{$s->price} ({$s->duration_minutes} mins) - {$s->description}\n";
        }
        $context .= "\nOur Stylists: \n";
        foreach ($staff as $st) {
            $context .= "- {$st->name} ({$st->specialization})\n";
        }
        $context .= "\nStore Info: Open 9 AM - 9 PM daily. Located in Dhaka.\n";
        $context .= "User Question: {$userMessage}\n";
        $context .= "Answer politely and concisely directly to the customer.";

        // 2. Call Gemini API
        // Use env var first, fallback to empty string (security)
        $apiKey = env('GEMINI_API_KEY', '');
        
        if (!$apiKey) {
            return response()->json(['response' => "I'm sorry, I'm not fully configured yet (Missing API Key)."]);
        }

        $response = Http::withoutVerifying()->withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $context]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "I'm not sure how to answer that.";
            return response()->json(['response' => $aiReply]);
        } else {
            // Debugging: Return actual error from API
            return response()->json([
                'response' => "Error: " . $response->status() . " - " . $response->body()
            ], $response->status());
        }
    }
}
