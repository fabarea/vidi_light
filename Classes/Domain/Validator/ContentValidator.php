<?php

namespace Fab\VidiLight\Domain\Validator;

use Fab\VidiLight\Domain\Model\Content;
use Fab\VidiLight\Exception\MissingIdentifierException;

/**
 * Validate "content"
 */
class ContentValidator
{
    /**
     * Check whether $Content object is valid.
     *
     * @param Content $content
     * @throws \Exception
     * @return void
     */
    public function validate(Content $content)
    {
        // Security check.
        if ($content->getUid() <= 0) {
            throw new MissingIdentifierException('Missing identifier for Content Object', 1351605542);
        }
    }
}
