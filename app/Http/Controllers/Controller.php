<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response_status_code = 200;
    protected $response = '';

    /**
     * Handle API response type
     *
     * @param array $response
     * @param int $status_code
     * @param bool $status
     * @param string $msg
     * @return ResponseFactory|Response
     */
    public function apiResponse($response=[], $status_code = 200, $status=false, $msg ='')
    {
        return response(['data'=>$response, 'status' => $status, 'msg' => $msg], $status_code)->header('Content-Type', 'application/json');
    }
}
