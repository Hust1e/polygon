<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use PhpParser\Lexer\TokenEmulator\ReadonlyTokenEmulator;

class TemperatureController extends Controller
{
    public function index()
    {
        $client = new Client();
        $res = $client->get('https://api.gismeteo.net/v2/weather/current/4368/?lang=en', [
            'headers' => ['X-Gismeteo-Token' => '56b30cb255.3443075', 'Accept-Encoding' => 'deflate']
        ]);
        $json = $res->getStatusCode();
        dd($json);
    }
}
