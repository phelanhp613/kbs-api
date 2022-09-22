<?php

namespace App\Http\Controllers;

use App\Services\AbstractService;

class ApiController extends Controller
{
    /**
     * json response api
     *
     * @param array $data
     * @param boolean $status
     * @param string $message
     */
    public function response($data, $status = true, $message = '')
    {
        if ($data instanceof AbstractService) {
            $status = $data->getStatus();
            if ($status) {
                $result = [
                    'status' => $status,
                    'message' => $data->getMessage(),
                    'data' => $data->getData(),
                ];
            } else {
                $result = [
                    'status' => $status,
                    'message' => $data->getMessage(),
                    'errors' => $data->getErrors(),
                    'sentryId' => $data->getSentryId(),
                ];
            }

            $statusCode = !empty($data->getStatusCode()) ? $data->getStatusCode() : 200;
            return response()->json($result, $statusCode);
        }

        return $status
            ? $this->successMessage($data)
            : $this->errorMessage($data, $message);
    }

    /**
     * success message response default
     *
     * @param array $data
     * @return array
     */
    public function successMessage($data = []): array
    {
        return [
            'status' => true,
            'message' => config('fa_messages.success.common'),
            'data' => empty($data) ? [] : $data,
        ];
    }

    /**
     * error message response default
     *
     * @param array $data
     * @param string $message
     * @return array
     */
    public function errorMessage($data = [], $message = 'Has error occur'): array
    {
        return [
            'status' => false,
            'message' => $message,
            'data' => empty($data) ? [] : $data,
        ];
    }
}
