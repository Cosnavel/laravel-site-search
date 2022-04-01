<?php

namespace Tests\TestSupport\TestClasses\SearchProfiles;

use Psr\Http\Message\UriInterface;
use Cosnavel\SiteSearch\Profiles\DefaultSearchProfile;

class DoNotCrawlSecondLinkSearchProfile extends DefaultSearchProfile
{
    public function shouldCrawl(UriInterface $url): bool
    {
        return ! str_ends_with($url->getPath(), 2);
    }
}
