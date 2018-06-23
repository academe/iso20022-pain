<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Norwegian kroner
 */
class NOK extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'NOK';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
