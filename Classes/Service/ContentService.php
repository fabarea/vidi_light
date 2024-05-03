<?php

namespace Fab\VidiLight\Service;

/*
 * This file is part of the Fab/Vidi project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */
use Fab\VidiLight\Domain\Model\Content;
use Fab\VidiLight\Module\ModuleLoader;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Fab\VidiLight\Domain\Repository\ContentRepositoryFactory;
use Fab\VidiLight\Persistence\Matcher;
use Fab\VidiLight\Persistence\Order;
use Fab\VidiLight\Signal\AfterFindContentObjectsSignalArguments;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * File References service.
 */
class ContentService
{
    /**
     * @var string
     */
    protected $dataType;

    /**
     * @var Content[]
     */
    protected $objects = [];

    /**
     * @var int
     */
    protected $numberOfObjects = 0;

    /**
     * Constructor
     *
     * @param string $dataType
     */
    public function __construct($dataType = '')
    {
        if (empty($dataType)) {
            $dataType = $this->getModuleLoader()->getDataType();
        }
        $this->dataType = $dataType;
    }

    /**
     * Fetch the files given an object assuming
     *
     * @param Matcher $matcher
     * @param Order $order The order
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function findBy(Matcher $matcher, Order $order = null, $limit = null, $offset = null)
    {
        // Query the repository.
        $objects = ContentRepositoryFactory::getInstance($this->dataType)->findBy($matcher, $order, $limit, $offset);
        $signalResult = $this->emitAfterFindContentObjectsSignal($objects, $matcher, $order, $limit, $offset);

        // Reset objects variable after possible signal / slot processing.
        $this->objects = $signalResult->getContentObjects();

        // Count number of content objects.
        if ($signalResult->getHasBeenProcessed()) {
            $this->numberOfObjects = $signalResult->getNumberOfObjects();
        } else {
            $this->numberOfObjects = ContentRepositoryFactory::getInstance($this->dataType)->countBy($matcher);
        }

        return $this;
    }

    /**
     * Signal that is called after the content objects have been found.
     *
     * @param array $contentObjects
     * @param Matcher $matcher
     * @param Order $order
     * @param int $limit
     * @param int $offset
     * @return AfterFindContentObjectsSignalArguments
     */
    protected function emitAfterFindContentObjectsSignal($contentObjects, Matcher $matcher, Order $order = null, $limit = 0, $offset = 0)
    {
        /** @var AfterFindContentObjectsSignalArguments $signalArguments */
        $signalArguments = GeneralUtility::makeInstance(AfterFindContentObjectsSignalArguments::class);
        $signalArguments->setDataType($this->dataType)
            ->setContentObjects($contentObjects)
            ->setMatcher($matcher)
            ->setOrder($order)
            ->setLimit($limit)
            ->setOffset($offset)
            ->setHasBeenProcessed(false);

        $signalResult = $this->getSignalSlotDispatcher()->dispatch(ContentService::class, 'afterFindContentObjects', array($signalArguments));
        return $signalResult[0];
    }

    /**
     * Get the Vidi Module Loader.
     *
     * @return ModuleLoader|object
     */
    protected function getModuleLoader()
    {
        return GeneralUtility::makeInstance(ModuleLoader::class);
    }

    /**
     * Get the SignalSlot dispatcher.
     *
     * @return Dispatcher|object
     */
    protected function getSignalSlotDispatcher()
    {
        return GeneralUtility::makeInstance(Dispatcher::class);
    }

    /**
     * @return Content[]
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @return int
     */
    public function getNumberOfObjects()
    {
        return $this->numberOfObjects;
    }
}
