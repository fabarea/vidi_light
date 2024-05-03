<?php

namespace Fab\VidiLight\Persistence;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PagerObjectFactory implements SingletonInterface
{
    /**
     * Gets a singleton instance of this class.
     *
     * @return \Fab\VidiLight\Persistence\PagerObjectFactory|object
     */
    public static function getInstance()
    {
        return GeneralUtility::makeInstance(\Fab\VidiLight\Persistence\PagerObjectFactory::class);
    }

    /**
     * Returns a pager object.
     *
     * @return Pager
     */
    public function getPager()
    {
        /** @var $pager \Fab\VidiLight\Persistence\Pager */
        $pager = GeneralUtility::makeInstance(Pager::class);

        // Set items per page
        if (GeneralUtility::_GET('length') !== null) {
            $limit = (int) GeneralUtility::_GET('length');
            $pager->setLimit($limit);
        }

        // Set offset
        $offset = 0;
        if (GeneralUtility::_GET('start') !== null) {
            $offset = (int) GeneralUtility::_GET('start');
        }
        $pager->setOffset($offset);

        // set page
        $page = 1;
        if ($pager->getLimit() > 0) {
            $page = round($pager->getOffset() / $pager->getLimit());
        }
        $pager->setPage($page);

        return $pager;
    }
}
