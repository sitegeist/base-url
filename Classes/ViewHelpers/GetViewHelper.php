<?php
declare(strict_types=1);

namespace Sitegeist\BaseUrl\ViewHelpers;

use Sitegeist\BaseUrl\Helper\BaseUrl;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Is used to get base URL in templates where no FE or BE context is avilable like commands or tasks
 *
 * It determinants the base URL from site configurations with baseVariants considered
 *
 * Examples: (resulting in https://example.com/)
 * <baseurl:get />
 * {baseurl:get()}
 * <baseurl:get pageId="1" />
 *
 */
class GetViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return BaseUrl::get(
            $arguments['identifier'],
            $arguments['pageId'],
            $arguments['explicit']
        );
    }

    public function initializeArguments()
    {
        $this->registerArgument('identifier', 'string', 'site configuration identifier to get baseUrl from');
        $this->registerArgument('pageId', 'int', 'page in rootLine to get baseUrl from');
        $this->registerArgument('explicit', 'bool', 'use site configuration if it can be determinate explicit. Otherwise you will get base url based on first site configuration', false, true);
    }
}
