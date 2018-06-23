<?php

namespace Academe\Pain001\Money;

/**
 * Sum of money in Australian dollars
 */
class AUD extends Money
{
    /**
     * {@inheritdoc}
     */
    final public function getCurrency()
    {
        return 'AUD';
    }

    /**
     * {@inheritdoc}
     */
    final protected function getDecimals()
    {
        return 2;
    }
}
