<?php

namespace App\Apis;

use Illuminate\Support\Facades\Http;

class DogsApi
{
    /**
     * @var string
     */
    protected string $endpoint = 'https://dog.ceo/api';

    public function getAllBreeds() {
        return $this->call('get', '/breeds/list/all', []);
    }

    public function randomImage($breed = null) {
        return $this->call(
            'get',
            $breed ? '/breed/'.$breed.'/images/random' : '/breeds/image/random',
            []
        );
    }


    protected function call(string $method, string $url, array $data = [])
    {
        try {
            return Http::$method($this->endpoint . $url,$data)->json();
        } catch (Exception $e) {
            //do some error handling
        }
    }
}
