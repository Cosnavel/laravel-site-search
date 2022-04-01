<?php

namespace Tests\TestSupport\TestClasses\SearchProfiles;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Cosnavel\SiteSearch\Indexers\Indexer;
use Cosnavel\SiteSearch\Profiles\DefaultSearchProfile;
use Tests\TestSupport\TestClasses\Indexers\IndexerWithModifiedUrl;

class ModifyUrlSearchProfile extends DefaultSearchProfile
{
    public function useIndexer(UriInterface $url, ResponseInterface $response): ?Indexer
    {
        return new IndexerWithModifiedUrl($url, $response);
    }
}
