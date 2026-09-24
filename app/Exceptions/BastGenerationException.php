<?php

namespace App\Exceptions;

use Exception;

class BastGenerationException extends Exception
{
    protected $message = 'Gagal memproses pembuatan atau pengunduhan dokumen Berita Acara Serah Terima (BAST).';
}
