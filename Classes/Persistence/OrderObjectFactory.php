<?php

namespace Fab\VidiLight\Persistence;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Fab\VidiLight\Tca\Tca;

class OrderObjectFactory implements SingletonInterface
{
    /**
     * Gets a singleton instance of this class.
     *
     * @return \Fab\VidiLight\Persistence\OrderObjectFactory|object
     */
    public static function getInstance()
    {
        return GeneralUtility::makeInstance(\Fab\VidiLight\Persistence\OrderObjectFactory::class);
    }

    /**
     * Returns an order object.
     *
     * @param string $dataType
     * @return Order|object
     */
    public function getOrder($dataType = '')
    {
        // Default ordering
        $order = Tca::table($dataType)->getDefaultOrderings();

        // Retrieve a possible id of the column from the request
        $orderings = GeneralUtility::_GP('order');

        if (is_array($orderings) && isset($orderings[0])) {
            $columnPosition = $orderings[0]['column'];
            $direction = $orderings[0]['dir'];

            if ($columnPosition > 0) {
                $field = Tca::grid()->getFieldNameByPosition($columnPosition);

                $order = [
                    $field => strtoupper($direction),
                ];
            }
        }
        return GeneralUtility::makeInstance(Order::class, $order);
    }
}
