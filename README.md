# Base URL for TYPO3 commands and tasks

In in scripts where no FE or BE context is avilable and you want to build URLs its a good idea to get the absolute URL from a site configuration. This extension provides a helper class to get there.

## Where to use

* commands which are called via cli
* scheduler tasks

## Features

* get base URL depending on site configurations
* absolute a relative URL

## Getting Started

use the static functions from `BaseUrl` helper Class

```PHP
\Sitegeist\BaseUrl\Helper\BaseUrl::get(); // https://example.com/
```

```PHP
\Sitegeist\BaseUrl\Helper\BaseUrl::prepend('home.html'); // https://example.com/home.html
```

use the viewhelpers in your fluid templates e. g. for mails

```html
<baseurl:get /> <!-- https://example.com/ -->
```

```html
<baseurl:prepend>home.html</baseurl:prepend> <!-- https://example.com/home.html -->
```

## Multiple site configuration setups

if your system has more than one site configuration, you can specify which site configuration should be used by:

* specify site configuration identifier
    ```PHP
    BaseUrl::get('mysite');
    BaseUrl::prepend('home.html', 'mysite');
    ```

    ```html
    <baseurl:get identifier="mysite" />
    <baseurl:prepend identifier="mysite" />home.html</baseurl:prepend>
    ```

* specify a pageUid (anywhere in the pageTree)
    ```PHP
    BaseUrl::get(null, 1);
    BaseUrl::prepend('home.html', null, 1);
    ```

    ```html
    <baseurl:get pageId="1" />
    <baseurl:prepend pageId="1" />home.html</baseurl:prepend>
    ```

## Getting further

Disable `$asString` return value to get an `TYPO3\CMS\Core\Http\Uri` object. Now you can get or change specific parts of the url.

```PHP
BaseUrl::get(null, null, true, false);

BaseUrl::prepend('home.html', null, null, true, false);
/*
TYPO3\CMS\Core\Http\Uri prototype object
   scheme => protected "https" (5 chars)
   supportedSchemes => protected array(2 items)
      http => 80 (integer)
      https => 443 (integer)
   authority => protected "" (0 chars)
   userInfo => protected "" (0 chars)
   host => protected "example.com" (11 chars)
   port => protected NULL
   path => protected "home.html" (9 chars)
   query => protected "" (0 chars)
   fragment => protected NULL
*/
```
