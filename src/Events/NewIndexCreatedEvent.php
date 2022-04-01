<?php

namespace Cosnavel\SiteSearch\Events;

use Cosnavel\SiteSearch\Models\SiteSearchConfig;

class NewIndexCreatedEvent
{
    public function __construct(
        public string $newIndexName,
        public SiteSearchConfig $siteSearchConfig,
    ) {
    }
}
