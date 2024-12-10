<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    protected $apiUrl;
    protected $apiId;
    protected $apiPassword;

    public function __construct()
    {
        $this->apiUrl = env('TEXTIT_API_URL', 'https://www.textit.biz/sendmsg');
        $this->apiId = env('TEXTIT_API_ID', '94705030510'); 
        $this->apiPassword = env('TEXTIT_API_PASSWORD', '3610'); 
    }

    public function sendSMS($to, $message)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get($this->apiUrl, [
            'id'   => $this->apiId,           
            'pw'   => $this->apiPassword,    
            'to'   => $to,                   
            'text' => $message,             
        ]);

        return $response->body(); 

    }
}
