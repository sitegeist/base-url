<?php
declare(strict_types = 1);

namespace Sitegeist\BaseUrl\Exception;

use TYPO3\CMS\Core\Exception;

/**
 * Exception thrown if unspecific multiple site configurations found
 */
class SiteNotExplicit extends Exception
{
}
