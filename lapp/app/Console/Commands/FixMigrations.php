<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:errors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        

        //\DB::table('migrations')->truncate();
        \DB::table('migrations')->insert([
            [
                'migration'=>"2014_01_07_073615_create_tagged_table",
                'batch'=>1,
            ],
            [
                'migration'=>"2014_01_07_073615_create_tagged_table",
                'batch'=>1
            ],
            [
                'migration'=>"2014_01_07_073615_create_tags_table",
                'batch'=>1
            ],
            [
                'migration'=>"2016_06_29_073615_create_tag_groups_table",
                'batch'=>1
            ],
            [
                'migration'=>"2016_06_29_073615_update_tags_table",
                'batch'=>1
            ],
            [
                'migration'=>"2019_10_08_063033_create_password_resets_table",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_14_193455_create_users_table",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_08_193313_create_applications_table",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_09_112343_categories",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_09_130112_settings",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_24_135043_votes",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_25_153242_platforms",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_28_154816_fa_icons",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_10_31_152257_pages",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_11_01_055232_ad_places",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_11_01_055232_ads",
                'batch'=>1,
            ],
            [
                'migration'=>"2019_11_18_004914_create_meta_tags_table",
                'batch'=>1,
            ],
        ]);
    }
}
