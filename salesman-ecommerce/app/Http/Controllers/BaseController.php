<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BaseController extends Controller
{
    /**
     * return success response.
     *
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess($data = null)
    {
    	$response = [
            'success' => true,
        ];

        if ($data) {
            $response['data'] = $data;
        }
        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function responseFailed($error = null, $code = null, $data = null)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        if ($code) {
            return response()->json($response, $code);
        } else {
            return response()->json($response);
        }
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmail($page, $toEmail, $data, $title)
    {
        $email = 'lnquang.17it1@vku.udn.vn';
        $name_email = 'Trung tâm ABC';
        if (!$email) {
            return back()->with('fail', __('app.auth_register_err'))->withInput();
        }

        Mail::send( $page, $data, function ($message) use ($toEmail, $email, $name_email, $title) {
                $message->from($email, $name_email)
                ->subject($title);
                $message->to($toEmail);
                $message->setContentType('text/html');
            });

    }

    public function readFile() {
        foreach(file('yourfile.txt') as $line) {
            // loop with $line for each line of yourfile.txt
        }
    }

    public function trimSpace($value) {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $value = mb_ereg_replace("^[\n\r\s\t　]+", '', $value);
        $value = mb_ereg_replace("[\n\r\s\t　]+$", '', $value);
        $value = trim($value);
        $value = str_replace(' ', '', $value);
        $value = str_replace('　', '', $value);
        return $value;
    }


    /**
     * return success response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSuccessResponse($data = null)
    {
    	$response = [
            'success' => true,
            'message'=>'Hiển thị thành công'
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error = null, $code = null, $data = null)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        if ($code) {
            return response()->json($response, $code);
        } else {
            return response()->json($response);
        }
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($url)
    {
    	$response = Http::withHeaders([
            'x-api-key' => config('constants.api.x_api_key'),
        ])->withOptions(['verify' => false])->get(config('constants.api.base_url').$url);

        return $response;
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function post($url, $data)
    {
    	$response = Http::withHeaders([
            'x-api-key' => config('constants.api.x_api_key'),
        ])->withOptions(['verify' => false])->post(config('constants.api.base_url').$url, $data);

        return $response;
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function put($url, $data = null)
    {
    	$response = Http::withHeaders([
            'x-api-key' => config('constants.api.x_api_key'),
        ])->withOptions(['verify' => false])->put(config('constants.api.base_url').$url, $data);

        return $response;
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($url)
    {
    	$response = Http::withHeaders([
            'x-api-key' => config('constants.api.x_api_key'),
        ])->withOptions(['verify' => false])->delete(config('constants.api.base_url').$url);

        return $response;
    }

    /**
     * log to file.
     *
     * @return \Illuminate\Http\Response
     */
    public function log($url, $method, $response, $company_id = null, $user_id = null, $data = null)
    {
        $log = '['.$company_id.'-'.$user_id.'] '.$method.' '.config('constants.api.base_url').$url;
        if (isset($data) && ($method === config('constants.post') || $method === config('constants.put'))) {
            $log = $log.PHP_EOL.json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        if ($response->failed()) {
            $log = $log.PHP_EOL.'{ '.$response->body().' }';
        }
    	Log::channel('api_customer')->info($log);
    }

}
