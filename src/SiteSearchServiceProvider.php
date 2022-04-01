<?php

namespace Cosnavel\SiteSearch;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Cosnavel\SiteSearch\Commands\CrawlCommand;
use Cosnavel\SiteSearch\Commands\CreateSearchConfigCommand;
use Cosnavel\SiteSearch\Commands\ListCommand;

class SiteSearchServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-site-search')
            ->hasConfigFile()
            ->hasMigration('create_site_search_configs_table')
            ->hasCommands([
                CreateSearchConfigCommand::class,
                CrawlCommand::class,
                ListCommand::class,
            ]);
    }
}
