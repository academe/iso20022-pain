<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Russian rubles
 */
class RUB extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'RUB';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
