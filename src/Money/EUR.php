<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Euro
 */
class EUR extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'EUR';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
