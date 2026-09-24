<?php

namespace App\Exceptions;

use Exception;

class ItemNotFoundException extends Exception
{
    protected $message = 'Data Barang Milik Negara (BMN) tidak ditemukan dalam sistem.';
}
