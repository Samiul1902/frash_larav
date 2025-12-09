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

        // 2. Call Pollinations.ai (Free, Reliable, No Key Required)
        // Since the user's Gemini Key is leaked/revoked, we switch to this open API.
        
        try {
            // Construct the full prompt
            $fullPrompt = $context . "\nUser: " . $userMessage . "\nAI:";
            
            // Pollinations Text API supports POST for longer prompts
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://text.pollinations.ai/', [
                'messages' => [
                    ['role' => 'user', 'content' => $fullPrompt]
                ],
                'model' => 'openai' // Uses a smart model (usually GPT-4o-mini or similar)
            ]);

            if ($response->successful()) {
                // Pollinations might return raw text or OpenAI format depending on endpoint behavior.
                // Usually direct POST to root returns raw text or stream. 
                // Let's handle string response safely.
                $aiReply = $response->body();
                return response()->json(['response' => $aiReply]);
            } else {
                return response()->json(['response' => "Sorry, I'm having trouble connecting to the brain. Please try again."]);
            }
        } catch (\Exception $e) {
             return response()->json(['response' => "Error: " . $e->getMessage()]);
        }
    }
}
