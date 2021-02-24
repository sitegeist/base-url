<?php
declare(strict_types=1);

namespace Sitegeist\BaseUrl\ViewHelpers;

use Sitegeist\BaseUrl\Helper\BaseUrl;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Builds an absolute url for a relative url path in templates where no FE or BE context is avilable like commands or tasks
 *
 * It determinants the base URL from site configurations with baseVariants considered
 *
 * Examples: (resulting in https://example.com/home.html)
 *
 * <baseurl:prepend>home.html</baseurl:prepend>
 * <baseurl:prepend pageId="1">home.html</baseurl:prepend>
 * {myvariable -> baseurl:prepend()}
 * {baseurl:prepend(relativePath: 'home.html')}
 *
 */
class PrependViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return BaseUrl::prepend(
            $arguments['relativePath'] ?? $renderChildrenClosure(),
            $arguments['baseUrl'],
            $arguments['identifier'],
            $arguments['pageId'],
            $arguments['explicit']
        );
    }

    public function initializeArguments()
    {
        $this->registerArgument('relativePath', 'string', 'URL path to build absolute path for');
        $this->registerArgument('baseUrl', 'string', 'base URL you want to use regardless of site configurations');
        $this->registerArgument('identifier', 'string', 'site configuration identifier to get baseUrl from');
        $this->registerArgument('pageId', 'int', 'page in rootLine to get baseUrl from');
        $this->registerArgument('explicit', 'bool', 'use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration', false, true);
    }
}
