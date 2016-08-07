<?php

namespace App\Http\Controllers\Auth;

use App\Support\AppController;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class PasswordController
 *
 * @package    App\Http\Controllers\Auth
 * @subpackage App\Http\Controllers\Auth\PasswordController
 */
class PasswordController extends AppController
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}