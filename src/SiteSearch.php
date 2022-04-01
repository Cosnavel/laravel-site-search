<?php

namespace Cosnavel\SiteSearch;

use Spatie\Crawler\Crawler;
use GuzzleHttp\Cookie\CookieJar;
use Cosnavel\SiteSearch\Drivers\Driver;
use Cosnavel\SiteSearch\Profiles\SearchProfile;
use Cosnavel\SiteSearch\Models\SiteSearchConfig;
use Cosnavel\SiteSearch\SearchResults\SearchResults;
use Cosnavel\SiteSearch\Crawler\SiteSearchCrawlProfile;
use Cosnavel\SiteSearch\Crawler\SearchProfileCrawlObserver;
use Cosnavel\SiteSearch\Exceptions\SiteSearchIndexDoesNotExist;

class SiteSearch
{
    public static function index(string $indexName): self
    {
        $siteSearchConfig = SiteSearchConfig::firstWhere('name', $indexName);

        if (! $siteSearchConfig) {
            throw SiteSearchIndexDoesNotExist::make($indexName);
        }

        return self::make($siteSearchConfig);
    }

    public static function make(SiteSearchConfig $siteSearchConfig): self
    {
        $driver = $siteSearchConfig->getDriver();

        $profile = $siteSearchConfig->getProfile();

        return new static($siteSearchConfig->index_name, $driver, $profile);
    }

    public function __construct(
        protected string        $indexName,
        protected Driver        $driver,
        protected SearchProfile $searchProfile,
    ) {
    }

    public function crawl(string $baseUrl): self
    {
        $crawlProfile = new SiteSearchCrawlProfile($this->searchProfile, $baseUrl);

        $observer = new SearchProfileCrawlObserver(
            $this->indexName,
            $this->searchProfile,
            $this->driver
        );

        if (config('site-search.crawler_auth_url') && config('site-search.crawler_auth_secret')) {
            $jar = new CookieJar();
            $client = new \GuzzleHttp\Client(['cookies' => true]);
            $client->request(
                'POST',
                config('site-search.crawler_auth_url'),
                [
                                'json' => [
                                    'secret' => config('site-search.crawler_auth_secret'),
                                ],
                                'headers'  => [
                                    'Accept' => 'application/json',
                                    'Content-Type' => 'application/json',
                                ],
                                'cookies' => $jar
                            ]
            );
            $crawler = Crawler::create(['cookies' => $jar]);
        } else {
            $crawler = Crawler::create();
        }


        $crawler->setCrawlProfile($crawlProfile)
            ->setCrawlObserver($observer);

        $this->searchProfile->configureCrawler($crawler);

        $crawler->startCrawling($baseUrl);

        return $this;
    }

    public function search(string $query, ?int $limit = null, ?int $offset = 0): SearchResults
    {
        return $this->driver->search($this->indexName, $query, $limit, $offset);
    }
}
