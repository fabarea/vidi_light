<?php

namespace Fab\VidiLight\Language;

use TYPO3\CMS\Core\Type\Enumeration;

class LocalizationStatus extends Enumeration
{
    public const LOCALIZED = 'localized';
    public const NOT_YET_LOCALIZED = 'notYetLocalized';
    public const EMPTY_VALUE = 'emptyValue';
}
