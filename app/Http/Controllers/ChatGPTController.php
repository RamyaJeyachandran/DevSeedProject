<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    protected $httpClient;
   
    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function askToChatGpt($message)
    {
        $response = $this->httpClient->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are'],
                    ['role' => 'user', 'content' => $message],
                ],
            ],
        ]);

        $chatReply= json_decode($response->getBody(), true)['choices'][0]['message']['content'];
        $chat_obj = new Chat;
        $userId=Auth::user()->id;
        $id=$chat_obj->addChat($userId,$message,$chatReply);

        $result['Success']='Success';
        $result['chatReply']=$chatReply;
        return response()->json($result,200);
    }
    public function getChatHistory(Request $request){
        try{
            $chat_obj = new Chat;
            $userId=Auth::user()->id;
            $chatHistory=$chat_obj->getChatHistory($userId);
            $result['Success']='Success';
            $result['chatHistory']=$chatHistory;
            $user_obj=new User;
            $result['getLastActivityDateTime']=$user_obj->getLastActivityDateTime($userId);
            return response()->json($result,200);
        }catch(\Throwable $th){
            $result['Success']='failure';
            $result['Message']=$th->getMessage();
            return response()->json($result,200);
        }
    }
}