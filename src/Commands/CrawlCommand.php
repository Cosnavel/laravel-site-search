<?php

namespace Cosnavel\SiteSearch\Commands;

use Illuminate\Console\Command;
use Cosnavel\SiteSearch\Jobs\CrawlSiteJob;
use Cosnavel\SiteSearch\Models\SiteSearchConfig;
use function Spatie\SiteSearch\Commands\dispatch;

class CrawlCommand extends Command
{
    public $signature = 'site-search:crawl';

    public function handle()
    {
        SiteSearchConfig::enabled()
            ->each(function (SiteSearchConfig $siteSearchConfig) {
                $this->comment("Dispatching job to crawl `{$siteSearchConfig->crawl_url}`");

                dispatch(new CrawlSiteJob($siteSearchConfig));
            });

        $this->info('All done');
    }
}
