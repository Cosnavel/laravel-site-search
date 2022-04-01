<?php

namespace Cosnavel\SiteSearch\Events;

use Cosnavel\SiteSearch\Models\SiteSearchConfig;

class IndexingEndedEvent
{
    public function __construct(public SiteSearchConfig $siteSearchConfig)
    {
    }
}
