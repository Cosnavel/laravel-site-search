<?php

use Illuminate\Support\Facades\Bus;
use function Pest\Laravel\artisan;
use Cosnavel\SiteSearch\Commands\CrawlCommand;
use Cosnavel\SiteSearch\Jobs\CrawlSiteJob;
use Cosnavel\SiteSearch\Models\SiteSearchConfig;
use Symfony\Component\Console\Command\Command;

beforeEach(function () {
    Bus::fake();
});

it('will crawl sites for enabled site indexes', function () {
    SiteSearchConfig::factory()->create();

    artisan(CrawlCommand::class)->assertExitCode(Command::SUCCESS);

    Bus::assertDispatched(CrawlSiteJob::class);
});

it('will not crawl sites for disabled site indexes', function () {
    SiteSearchConfig::factory()->create(['enabled' => false]);

    artisan(CrawlCommand::class)->assertExitCode(Command::SUCCESS);

    Bus::assertNotDispatched(CrawlSiteJob::class);
});
