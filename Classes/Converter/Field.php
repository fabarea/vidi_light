<?php

namespace Fab\VidiLight\Converter;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Fab\VidiLight\Domain\Model\Content;

/**
 * Convert a field name to property name.
 */
class Field implements SingletonInterface
{
    /**
     * @var string
     */
    protected static $currentField;

    /**
     * @var string
     */
    protected static $currentTable;

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * @param string $fieldName
     * @return $this
     * @throws \InvalidArgumentException
     */
    public static function name($fieldName)
    {
        self::$currentField = $fieldName;
        self::$currentTable = ''; // reset the table name value.
        return GeneralUtility::makeInstance(self::class);
    }

    /**
     * @param string|Content $tableNameOrContentObject
     * @return $this
     */
    public function of($tableNameOrContentObject)
    {
        // Resolve the table name.
        self::$currentTable = $tableNameOrContentObject instanceof Content ?
            $tableNameOrContentObject->getDataType() :
            $tableNameOrContentObject;
        return $this;
    }

    public function toPropertyName()
    {
        $fieldName = $this->getFieldName();
        $tableName = $this->getTableName();

        if (empty($this->storage[$tableName][$fieldName])) {
            if (!array_key_exists($tableName, $this->storage)) {
                $this->storage[$tableName] = [];
            }

            // Special case when the field name does not follow the conventions "field_name" => "fieldName".
            // Rely on mapping for those cases.
            if (!empty($GLOBALS['TCA'][$tableName]['vidi']['mappings'][$fieldName])) {
                $propertyName = $GLOBALS['TCA'][$tableName]['vidi']['mappings'][$fieldName];
            } else {
                $propertyName = GeneralUtility::underscoredToLowerCamelCase($fieldName);
            }

            $this->storage[$tableName][$fieldName] = $propertyName;
        }

        return $this->storage[$tableName][$fieldName];
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    protected function getFieldName()
    {
        $fieldName = self::$currentField;
        if (empty($fieldName)) {
            throw new \RuntimeException('I could not find a field name value.', 1403203290);
        }
        return $fieldName;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        $tableName = self::$currentTable;
        if (empty($tableName)) {
            throw new \RuntimeException('I could not find a table name value.', 1403203291);
        }
        return $tableName;
    }
}
