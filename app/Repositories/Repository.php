<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Http;

class Repository
{
    public function fetch(string $url, $options = [])
    {
        $response = Http::get($url, $options);

        return $response->collect();
    }

}
