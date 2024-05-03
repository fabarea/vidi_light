<?php

namespace Fab\VidiLight\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Fab\VidiLight\Tca\Tca;

/**
 * Validate "columns" to be displayed in the BE module.
 */
class ColumnsValidator extends AbstractValidator
{
    /**
     * Check if $columns is valid. If it is not valid, throw an exception.
     *
     * @param mixed $columns
     * @return void
     */
    public function isValid($columns)
    {
        foreach ($columns as $columnName) {
            if (!Tca::grid()->hasField($columnName)) {
                $message = sprintf('Column "%s" is not allowed. Actually, it was not configured to be displayed in the grid.', $columnName);
                $this->addError($message, 1380019720);
            }
        }
    }
}
