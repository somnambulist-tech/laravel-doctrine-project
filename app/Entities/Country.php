<?php

namespace App\Entities;

use App\Traits\Entity\HasToString;
use Somnambulist\Doctrine\Contracts\Identifiable as IdentifiableContract;
use Somnambulist\Doctrine\Contracts\Nameable as NameableContract;
use Somnambulist\Doctrine\Contracts\Timestampable as TimestampableContract;
use Somnambulist\Doctrine\Traits\Identifiable;
use Somnambulist\Doctrine\Traits\Nameable;
use Somnambulist\Doctrine\Traits\Timestampable;

/**
 * Class Country
 *
 * @package    App\Modules\Core\Entities
 * @subpackage App\Modules\Core\Entities\Country
 */
class Country implements IdentifiableContract, NameableContract, TimestampableContract
{

    use HasToString;
    use Identifiable;
    use Nameable;
    use Timestampable;

    /**
     * @var string
     */
    protected $alpha2;

    /**
     * @var string
     */
    protected $alpha3;



    /**
     * Constructor.
     *
     * @param string $name
     * @param string $alpha2
     * @param string $alpha3
     */
    public function __construct($name, $alpha2, $alpha3)
    {
        $this->name   = $name;
        $this->alpha2 = $alpha2;
        $this->alpha3 = $alpha3;
    }

    /**
     * @return string
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * @return string
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }
}
