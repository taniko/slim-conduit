<?php
declare(strict_types=1);

namespace App\Application\Actions;

use JsonSerializable;

class ActionPayload implements JsonSerializable
{
    private int $statusCode;

    /**
     * @var array|object|null
     */
    private $data;

    /**
     * @var array|object|null
     */
    private $error;

    /**
     * @param int               $statusCode
     * @param array|object|null $data
     * @param array|object|null $error
     */
    public function __construct(
        int $statusCode = 200,
        $data = null,
        $error = null
    )
    {
        $this->statusCode = $statusCode;
        $this->data       = $data;
        $this->error      = $error;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|object|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $payload = [
            'statusCode' => $this->statusCode,
        ];

        if ($this->data !== null) {
            $payload['data'] = $this->data;
        } elseif ($this->error !== null) {
            $payload['error'] = $this->error;
        }

        return $payload;
    }
}
