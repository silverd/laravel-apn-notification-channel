<?php

namespace SemyonChetvertnyh\ApnNotificationChannel\Exceptions;

use Pushok\ApnsResponseInterface;

class CouldNotSendNotification extends \Exception
{
    /**
     * @var \Pushok\ApnsResponseInterface
     */
    protected $response;

    /**
     * Create an instance of exception.
     *
     * @param  string  $message
     * @param  int  $errorCode
     * @return static
     */
    public static function make($message, $errorCode)
    {
        return new static($message, $errorCode);
    }

    /**
     * Attach the response.
     *
     * @param  \Pushok\ApnsResponseInterface  $response
     * @return $this
     */
    public function withResponse(ApnsResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get a response.
     *
     * @return \Pushok\ApnsResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
