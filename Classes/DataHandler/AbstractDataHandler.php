<?php

namespace Fab\VidiLight\DataHandler;

use TYPO3\CMS\Core\SingletonInterface;

abstract class AbstractDataHandler implements DataHandlerInterface, SingletonInterface
{
    /**
     * @var array
     */
    protected $errorMessages = [];

    /**
     * Return error that have occurred while processing the data.
     *
     * @return array
     */
        public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
