<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Czech koruna
 */
class CZK extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'CZK';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
