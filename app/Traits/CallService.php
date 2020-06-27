<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CallService
{
    public function triggerAndConnect($url = '', $params = [] ) {
        $response = Http::get($url, $params);
        return $response;
    }

}
