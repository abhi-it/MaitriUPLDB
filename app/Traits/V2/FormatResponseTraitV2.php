<?php

namespace App\Traits\V2;

trait FormatResponseTraitV2 {
    
    public function successResponse($message=' ' , $statusCode, $data = NULL, $paginate = array(), ) {
        $response                   = array();
        $response['message']        = $message;
        $response['status']         = "success";
        $response['error_type']     = "";
        $response['data']           = $data;
        
        if(!empty($paginate)){
            $response['total_records']  = $paginate->total();
            $response['total_pages']    = $paginate->lastPage();
            $response['current_page']   = $paginate->currentPage();
            $response['per_page']      = $paginate->perPage();
        }
        return response()->json($response, $statusCode);
    }
    
    public function errorResponse($message = '', $type='', $statusCode, $data=NULL){
        $response               = array();
        $response['status']     = "error";
        $response['error_type'] = $type;
        $response['message']    = $message;
        $response['data']       = $data;
        return response()->json($response, $statusCode);
    }
}