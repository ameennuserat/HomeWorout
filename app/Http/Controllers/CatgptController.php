<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use Illuminate\Support\Facades\Http;
use \OpenAI;
use Factory;
class CatgptController extends Controller
{
    public function chat(Request $request){

        $yourApiKey = "key";
        $client = \OpenAI::client($yourApiKey);

        $result = $client->completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => $request['text'].'  الجواب بصيغة جيسون',
        'max_tokens'=>3000,
       ]);
       $respons = $result['choices'][0]['text'];
       print_r($respons);
       die;
}
}

