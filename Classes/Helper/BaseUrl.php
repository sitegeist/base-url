<?php
declare(strict_types=1);

namespace Sitegeist\BaseUrl\Helper;

use Sitegeist\BaseUrl\Exception\NoSiteFoundException;
use Sitegeist\BaseUrl\Exception\SiteNotExplicit;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Is used to get base URL in scripts where no FE or BE context is avilable like commands or tasks
 *
 * Examples:
 * BaseUrl::get(); => https://example.com/
 * BaseUrl::prepend('home.html') => https://example.com/home.html
 *
 */
class BaseUrl
{

    /**
     * Determinants a base URL from site configurations
     *
     * If there is only one site configuration no params are required.
     * If there are more site configurations please provide either $identifier or $pageId.
     *
     * @param string $identifier site configuration identifier to get baseUrl from
     * @param int $pageId id of a page in rootLine to get baseUrl from
     * @param bool $explicit only use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration
     * @param bool $asString get baseUrl as string or Uri object
     *
     * @return string|Uri
     * @throws NoSiteFoundException
     * @throws SiteNotExplicit
     */
    public static function get(
        string $identifier = null,
        int $pageId = null,
        bool $explicit = true,
        bool $asString = true
    ) {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);

        if ($identifier) {
            $site = $siteFinder->getSiteByIdentifier($identifier);
        }
        if ($pageId) {
            $site = $siteFinder->getSiteByPageId($pageId);
        }
        if (!$identifier && !$pageId) {
            $allSites = $siteFinder->getAllSites();
            if (count($allSites) == 1 || (count($allSites) > 1 && !$explicit)) {
                $site = array_shift($allSites);
            } elseif (count($allSites) == 0) {
                throw new NoSiteFoundException('No site found to get base url from', 1596630604);
            } else {
                throw new SiteNotExplicit('Please specific site by identifier or pageId. Alternative set explicit to false and get the first site configuration', 1596630831);
            }
        }

        if (!$site) {
            throw new NoSiteFoundException('No site found to get base url from', 1596630604);
            return null;
        }

        if ($asString) {
            return (string) $site->getBase();
        }

        return $site->getBase();
    }

    /**
     * Builds an absolute url for a relative url path
     *
     * we got your back: $relativePath could contain an absolute url or an unnecessary leading slash
     *
     * @param string $relativePath URL path to build absolute path for
     * @param string $identifier site configuration identifier to get baseUrl from
     * @param int $pageId id of a page in rootLine to get baseUrl from
     * @param bool $explicit only use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration
     * @param bool $asString get baseUrl as string or Uri object
     * @return string|Uri absolute URI for given relative URI
     */
    public static function prepend(
        string $relativePath,
        string $identifier = null,
        int $pageId = null,
        bool $explicit = true,
        bool $asString = true
    ) {
        $relativeUri = new Uri($relativePath);
        $baseUri = self::get($identifier, $pageId, $explicit, false);
        $absoluteUri = $baseUri
            ->withPath($relativeUri->getPath())
            ->withQuery($relativeUri->getQuery())
            ->withFragment($relativeUri->getFragment());

        if ($asString) {
            return (string) $absoluteUri;
        }
        return $absoluteUri;
    }
}
