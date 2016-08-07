<?php

namespace App\Enumerations;

use App\Support\AppEnumeration;

/**
 * Class AddressType
 *
 * @package    App\Enumerations
 * @subpackage App\Enumerations\AddressType
 *
 * @method static AddressType BILLING()
 * @method static AddressType CORPORATE()
 * @method static AddressType PERSONAL()
 * @method static AddressType SHIPPING()
 */
final class AddressType extends AppEnumeration
{

    const BILLING   = 'billing';
    const CORPORATE = 'corporate';
    const PERSONAL  = 'personal';
    const SHIPPING  = 'shipping';

}
