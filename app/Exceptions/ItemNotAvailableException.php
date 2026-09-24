<?php

namespace App\Exceptions;

use Exception;

class ItemNotAvailableException extends Exception
{
    protected $message = 'Barang Milik Negara (BMN) sedang tidak tersedia untuk dipinjam atau digunakan.';
}
