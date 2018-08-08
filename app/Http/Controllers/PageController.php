<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    public function index(){
        return view('index');
    }

    public function amigos(){
       
        $amigos=[
            ['nome' => 'TESTE 1', 'idade'=> 21],
            ['nome' => 'TESTE 2', 'idade'=> 22],
            ['nome' => 'TESTE 3', 'idade'=> 23],
        ];

        return $amigos;

    }
}
