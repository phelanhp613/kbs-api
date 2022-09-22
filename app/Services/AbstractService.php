<?php

namespace App\Services;

class AbstractService
{
    public $status;
    public $statusCode;
    public $message;
    public $data;
    public $sentryId;
    public $errors;

    /**
     * Set status
     *
     * @param boolean $status
     * @return void
     */
    public function setStatus($status = true)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set status code
     *
     * @param boolean $statusCode
     * @return void
     */
    public function setStatusCode($statusCode = true)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return void
     */
    public function setMessage($message = '')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set data
     *
     * @param object|array|string|integer $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set data
     *
     * @param object|array|string|integer $sentryId
     * @return void
     */
    public function setSentryId($sentryId)
    {
        $this->sentryId = $sentryId;

        return $this;
    }

    /**
     * Set data
     *
     * @param object|array|string|integer $errors
     * @return void
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Retrive current status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Retrive current message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Retrive result of service
     *
     * @return array
     */
    public function getResult()
    {
        return $this->getStatus() ? $this->getData() : [];
    }

    /**
     * Retrive default value of service
     *
     * @return array
     */
    public function getData()
    {
        return empty($this->data) ? [] : $this->data;
    }

    /**
     * Retrive default value of service
     *
     * @return array
     */
    public function getSentryId()
    {
        return $this->sentryId;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return Exception
     */
    public function captureException($exception)
    {
        if (app()->environment('local')) {
            throw $exception;
        }

        return app('sentry')->captureException($exception);
    }
}

