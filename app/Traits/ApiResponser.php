<?php
namespace app\Traits;

trait ApiResponser{
    protected function SuccessResponse($data,$message=null,$code){
        return response()->json([
            'Status'=>'success',
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
    protected function ErrorResponse($message=null,$code){
        return response()->json([
            'Status'=>'error',
            'message'=>$message,
            'data'=>''
        ],$code);
    }
}
