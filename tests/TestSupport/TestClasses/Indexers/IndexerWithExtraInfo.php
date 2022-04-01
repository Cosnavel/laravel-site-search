<?php

namespace Tests\TestSupport\TestClasses\Indexers;

use Cosnavel\SiteSearch\Indexers\DefaultIndexer;

class IndexerWithExtraInfo extends DefaultIndexer
{
    public function extra(): array
    {
        return [
            'extraName' => 'extraValue',
        ];
    }
}
