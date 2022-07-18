<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Question;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{

    //Get API Tanpa Otentikasi
    public function ConsumePublicAPI(){

        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        $user = json_decode($response->body());

        return $user;
    }

    //Get API dengan Otentikasi
    public function ConsumePublicAPIwToken(){

        $response = Http::get('https://quizapi.io/api/v1/questions', [
            'apiKey' => 'dOfCjSvE801Ex6cyx5qpzeygBFMhZJfdo43k5PJY',
            'limit' => 10,
        ]);
        $quizzes = json_decode($response->body());

        return $quizzes;
    }
}
