<?php

namespace Cosnavel\SiteSearch\Events;

use Cosnavel\SiteSearch\Models\SiteSearchConfig;

class IndexingStartedEvent
{
    public function __construct(public SiteSearchConfig $siteSearchConfig)
    {
    }
}
