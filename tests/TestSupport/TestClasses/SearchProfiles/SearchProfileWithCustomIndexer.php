<?php

namespace Tests\TestSupport\TestClasses\SearchProfiles;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Cosnavel\SiteSearch\Indexers\Indexer;
use Cosnavel\SiteSearch\Profiles\DefaultSearchProfile;
use Tests\TestSupport\TestClasses\Indexers\IndexerWithExtraInfo;

class SearchProfileWithCustomIndexer extends DefaultSearchProfile
{
    public function useIndexer(UriInterface $url, ResponseInterface $response): ?Indexer
    {
        return new IndexerWithExtraInfo($url, $response);
    }
}
