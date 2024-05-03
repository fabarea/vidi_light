<?php

namespace Fab\VidiLight\Persistence;

use TYPO3\CMS\Core\SingletonInterface;

class ResultSetStorage implements SingletonInterface
{
    /**
     * @var array
     */
    protected $resultSets = [];

    /**
     * @param string $querySignature
     * @return array
     */
    public function get($querySignature)
    {
        $resultSet = null;
        if (isset($this->resultSets[$querySignature])) {
            $resultSet = $this->resultSets[$querySignature];
        }
        return $resultSet;
    }

    /**
     * @param $querySignature
     * @param array $resultSet
     * @internal param array $resultSets
     */
    public function set($querySignature, array $resultSet)
    {
        $this->resultSets[$querySignature] = $resultSet;
    }
}
