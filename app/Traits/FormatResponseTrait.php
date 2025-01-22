<?php
namespace App\Traits;


use Symfony\Component\HttpFoundation\Response;
use Willywes\AgoraSDK\RtcTokenBuilder;
use App\Models\DeviceDetail;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use App\Traits\ServiceBuilder;

trait FormatResponseTrait {
    
    public function successResponse($message=' ' , $statusCode, $data = NULL, $paginate = array(), ){
        $response                   = array();
        $response['message']        = $message;
        $response['status']         = "success";
        $response['data']           = $data;
        
        if(!empty($paginate)){
            $response['total_records']  = $paginate->total();
            $response['total_pages']    = $paginate->lastPage();
            $response['current_page']   = $paginate->currentPage();
            $response['per_page']      = $paginate->perPage();
        }
        return response()->json($response, $statusCode);
    }
    
    public function errorResponse($message = '', $statusCode, $data=NULL){
        $response               = array();
        $response['status']     = "error";
        $response['message']    = $message;
        $response['data']       = $data;
        return response()->json($response, $statusCode);
    }
}