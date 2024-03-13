<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    public function chat(Request $request)
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer ".env('OPENAI_API_KEY')
        ])->post(env('OPENAI_URL'),[
            "model" => "gpt-3.5-turbo-1106",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $request->message
                ]
            ],
            "max_tokens" => 4096
        ])->body();
       return response()->json(json_decode($response));
    }
    public function  createPurposalChatGPT($msg_data)
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer ".env('OPENAI_API_KEY')
        ])->timeout(60)->post(env('OPENAI_URL'),[
            "model" => "gpt-3.5-turbo-1106",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $msg_data
                ]
            ],
            "max_tokens" => 4096
        ])->body();
        $data = json_decode($response, true);
        //dd($data);
        $content = $data['choices'][0]['message']['content'];
        return $content;
    }
}
