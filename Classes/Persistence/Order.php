<?php

namespace Fab\VidiLight\Persistence;

class Order
{
    /**
     * The orderings
     *
     * @var array
     */
    protected $orderings = [];

    /**
     * Constructs a new Order
     *
     * @para array $orders
     * @param array $orders
     */
    public function __construct($orders = [])
    {
        foreach ($orders as $order => $direction) {
            $this->addOrdering($order, $direction);
        }
    }

    /**
     * Add ordering
     *
     * @param string $order The order
     * @param string $direction ASC / DESC
     * @return void
     */
    public function addOrdering($order, $direction)
    {
        $this->orderings[$order] = $direction;
    }

    /**
     * Returns the order
     *
     * @return array The order
     */
    public function getOrderings()
    {
        return $this->orderings;
    }
}
