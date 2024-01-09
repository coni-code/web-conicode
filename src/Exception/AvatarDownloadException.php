<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class AvatarDownloadException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct("Avatar Download Error: " . $message, $code, $previous);
    }
}
