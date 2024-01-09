<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class AvatarDownloadException extends Exception
{
    public function __construct($message = "", $code = 0, GuzzleException $previous = null)
    {
        parent::__construct("Avatar Download Error: " . $message, $code, $previous);
    }
}
