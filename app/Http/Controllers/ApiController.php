<?php

namespace App\Http\Controllers;

use app\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // why do you use this controller?!
//    use ApiResponser;
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
