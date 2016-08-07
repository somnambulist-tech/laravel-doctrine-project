<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Class EncryptCookies
 *
 * @package    App\Http\Middleware
 * @subpackage App\Http\Middleware\EncryptCookies
 */
class EncryptCookies extends BaseEncrypter
{

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
