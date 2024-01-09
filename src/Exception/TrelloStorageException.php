<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use League\Flysystem\FilesystemException;

class TrelloStorageException extends Exception
{
    public function __construct($message = "", $code = 0, FilesystemException $previous = null)
    {
        parent::__construct("Trello Storage Error: " . $message, $code, $previous);
    }
}
