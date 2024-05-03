<?php

namespace Fab\VidiLight\Domain\Validator;

use Fab\VidiLight\Language\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LanguageValidator
{
    /**
     * Check whether the $language is valid.
     *
     * @param int $language
     * @throws \Exception
     * @return void
     */
    public function validate($language)
    {
        if (!$this->getLanguageService()->languageExists((int)$language)) {
            throw new \Exception('The language "' . $language . '" does not exist', 1351605542);
        }
    }

    /**
     * @return LanguageService|object
     */
    protected function getLanguageService()
    {
        return GeneralUtility::makeInstance(LanguageService::class);
    }
}
