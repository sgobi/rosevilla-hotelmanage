<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for rosevillaheritagehomes.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sitemap::create()
            ->add(Url::create('https://rosevillaheritagehomes.com/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('https://rosevillaheritagehomes.com/about')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            // உங்கள் தளத்தில் உள்ள மற்ற பக்கங்களின் URL-களை இங்கு சேர்க்கலாம்
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully for Rose Villa!');
    }
}