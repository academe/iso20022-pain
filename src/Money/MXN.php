<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Mexican pesos
 */
class MXN extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'MXN';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
