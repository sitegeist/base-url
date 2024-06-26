<?php
declare(strict_types=1);

namespace Sitegeist\BaseUrl\Helper;

use Sitegeist\BaseUrl\Exception\SiteNotExplicit;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\Entity\NullSite;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Is used to get base URL in scripts where no FE or BE context is available like commands or tasks
 *
 * It determinants the base URL from site configurations with baseVariants considered
 *
 * Examples:
 * BaseUrl::get(); => https://example.com/
 * BaseUrl::prepend('home.html'); => https://example.com/home.html
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
     * @param string|null $identifier site configuration identifier to get baseUrl from
     * @param int|null $pageId id of a page in rootLine to get baseUrl from
     * @param bool $explicit only use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration
     * @param bool $asString get baseUrl as string or Uri object
     *
     * @return string|Uri base url from site configuration
     * @throws SiteNotExplicit
     * @throws SiteNotFoundException
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
                $site = new NullSite();
            } else {
                throw new SiteNotExplicit('Please specific site by identifier or pageId. Alternative set explicit to false and get the first site configuration', 1596630831);
            }
        }
        return $asString ? (string) $site->getBase() : $site->getBase();
    }

    /**
     * Builds an absolute url for a relative url path
     *
     * we (TYPO3\CMS\Core\Http\Uri) got your back: $relativePath could contain an absolute url or an unnecessary leading slash
     *
     * @param string $relativePath URL path to build absolute path for
     * @param string|null $baseUrl base URL you want to use regardless of site configurations
     * @param string|null $identifier site configuration identifier to get baseUrl from
     * @param int|null $pageId id of a page in rootLine to get baseUrl from
     * @param bool $explicit only use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration
     * @param bool $asString get baseUrl as string or Uri object
     * @return string|Uri absolute URI for given relative URI
     * @throws SiteNotExplicit
     */
    public static function prepend(
        string $relativePath,
        string $baseUrl = null,
        string $identifier = null,
        int $pageId = null,
        bool $explicit = true,
        bool $asString = true
    ) {
        $redundantBaseUriPath = false;
        $publicPath = Environment::getPublicPath() . '/';
        if (!GeneralUtility::isValidUrl($relativePath) && strpos($relativePath, $publicPath) === 0) {
            $relativePath = substr($relativePath, strlen($publicPath));
        }
        $relativeUri = new Uri($relativePath);
        $baseUri = $baseUrl ? new Uri($baseUrl) : self::get($identifier, $pageId, $explicit, false);
        if (strpos($relativeUri->getPath(), $baseUri->getPath()) === 0) {
            $redundantBaseUriPath = true;
        }
        $absoluteUri = $baseUri
            ->withPath(($redundantBaseUriPath ? '' : $baseUri->getPath()) . $relativeUri->getPath())
            ->withQuery($relativeUri->getQuery())
            ->withFragment($relativeUri->getFragment());

        return $asString ? (string) $absoluteUri : $absoluteUri;
    }
}
