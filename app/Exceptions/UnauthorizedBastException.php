<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedBastException extends Exception
{
    protected $message = 'Anda tidak memiliki hak akses atau otorisasi untuk mengunduh dokumen BAST ini.';
}
