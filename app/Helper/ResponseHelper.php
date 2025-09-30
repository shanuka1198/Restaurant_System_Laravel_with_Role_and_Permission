<?php
	namespace App\Helper;
	class ResponseHelper
	{
		/**
		* Create a new class instance.
		*/
	public function __construct()
	{
		//
	}

	/**
	* Create a new class instance.
	* @param string $status
	* @param string $message
	* @param mixed $data
	* @param int $code
	* @return \Illuminate\Http\JsonResponse
	* @example ResponseHelper::success('success', 'Success', $data, 200);
	*/

	public static function success($status='success', $message='Success', $data = null, $code = 200)
	{
		return response()->json([
			'status' => $status,
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
	* Create a new class instance.
	* @param string $status
	* @param string $message
	* @param int $code
	* @return \Illuminate\Http\JsonResponse
	* @example ResponseHelper::error('error', 'Error', 500);
	*/

	public static function error($status='error',$message='Error', $code = 500)
	{
		return response()->json([
			'status' => $status,
			'message' => $message
		], $code);
	}
}