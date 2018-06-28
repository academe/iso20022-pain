<?php

namespace Consilience\Pain001\Money;

/**
 * Sum of money in mixed currencies
 */

use Money\Money;
use Money\Currencies\ISOCurrencies;

class Mixed
{
    /**
     * @var int
     */
    protected $cents;

    /**
     * @var int
     */
    protected $decimals;

    /**
     * Constructor
     *
     * @param int $cents    Amount of money in minor units
     * @param int $decimals Number of minor units
     */
    public function __construct($cents, $decimals = 0)
    {
        $this->cents = is_int($cents) ? $cents : intval(round($cents));
        $this->decimals = $decimals;
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return $this->decimals;
    }

    /**
     * Returns the amount of money in cents
     *
     * @return int The amount in cents
     */
    public function getAmount()
    {
        return $this->cents;
    }

    /**
     * Returns the sum of this and an other amount of money
     *
     * @param Mixed|Money $addend The addend
     *
     * @return Mixed The sum
     */
    public function plus($addend)
    {
        list($thisCents, $addendCents, $decimals) = self::normalizeDecimals($this, $addend);

        return new static($thisCents + $addendCents, $decimals);
    }

    /**
     * Returns the subtraction of this and an other amount of money
     *
     * @param Mixed|Money  $subtrahend The subtrahend
     *
     * @return Mixed The difference
     */
    public function minus($subtrahend)
    {
        list($thisCents, $subtrahendCents, $decimals) = self::normalizeDecimals($this, $subtrahend);

        return new static($thisCents - $subtrahendCents, $decimals);
    }

    /**
     * Normalizes two amounts such that they have the same number of decimals
     *
     * @param Mixed|Money $a
     * @param Mixed|Money $b
     *
     * @return array An array containing the two amounts and number of decimals
     */
    protected static function normalizeDecimals($a, $b)
    {
        $currencies = new ISOCurrencies();

        if ($a instanceof Mixed) {
            $aDecimals = $a->getDecimals();
        } elseif ($a instanceof Money) {
            $aDecimals = $currencies->subunitFor($a->getCurrency());
        } else {
            throw new InvalidArgumentException(sprintf(
                'The amount must be an instance of Consilience\Pain001\Mixed or Money\Money (instance of %s given).',
                get_class($b)
            ));
        }

        if ($b instanceof Mixed) {
            $bDecimals = $b->getDecimals();
        } elseif ($b instanceof Money) {
            $bDecimals = $currencies->subunitFor($b->getCurrency());
        } else {
            throw new InvalidArgumentException(sprintf(
                'The amount must be an instance of Consilience\Pain001\Mixed or Money\Money (instance of %s given).',
                get_class($b)
            ));
        }

        $decimalsDiff = ($aDecimals - $bDecimals);
        $decimalsMax = max($aDecimals, $bDecimals);

        $aAmount = $a->getAmount();
        $bAmount = $b->getAmount();

        if ($decimalsDiff > 0) {
            return [$aAmount, pow(10, $decimalsDiff) * $bAmount, $decimalsMax];
        } elseif ($decimalsDiff < 0) {
            return [pow(10, -$decimalsDiff) * $aAmount, $bAmount, $decimalsMax];
        } else {
            return [$aAmount, $bAmount, $decimalsMax];
        }
    }

    /**
     * Returns a formatted string (e.g. 15.560)
     *
     * @return string The formatted value
     */
    public function format()
    {
        if ($this->getDecimals() > 0) {
            $sign = ($this->cents < 0 ? '-' : '');
            $base = pow(10, $this->getDecimals());
            $minor = abs($this->cents) % $base;
            $major = (abs($this->cents) - $minor) / $base;

            return sprintf('%s%d.%0'.$this->getDecimals().'d', $sign, $major, $minor);
        } else {
            return sprintf('%d', $this->cents);
        }
    }
}
