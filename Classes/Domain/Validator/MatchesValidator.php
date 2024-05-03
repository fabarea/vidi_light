<?php

namespace Fab\VidiLight\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Fab\VidiLight\Tca\Tca;

class MatchesValidator extends AbstractValidator
{
    /**
     * Check if $matches is valid. If it is not valid, throw an exception.
     *
     * @param mixed $matches
     * @return void
     */
    public function isValid($matches)
    {
        foreach ($matches as $fieldName => $value) {
            if (!Tca::table()->hasField($fieldName)) {
                $message = sprintf('Field "%s" is not allowed. Actually, it is not configured in the TCA.', $fieldName);
                $this->addError($message, 1380019718);
            }
        }
    }
}
