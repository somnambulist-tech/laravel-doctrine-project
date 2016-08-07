<?php

namespace App\Support;

use Assert\Assertion;
use App\Support\Exceptions\AssertionFailedException;

/**
 * Class AppAssertion
 *
 * @package    App\Support
 * @subpackage App\Support\AppAssertion
 */
class AppAssertion extends Assertion
{

    static protected $exceptionClass = AssertionFailedException::class;

}
