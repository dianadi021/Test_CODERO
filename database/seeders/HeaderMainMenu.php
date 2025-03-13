<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HeaderMainMenu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Master Data',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Project',
                'route_name' => 'master-data.project',
                'link' => '/master-data/project',
                'icon' => 'assets/images/icons/12087772.png',
                'id_parent' => $lastID,
            ],
        ];

        DB::table('list_menus')->insert($datas);
    }
}
