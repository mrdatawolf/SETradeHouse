<?php

use Illuminate\Database\Seeder;

class SqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paths = [
            base_path() . '/database/sql/main_ores.sql',
            base_path() . '/database/sql/main_ingots.sql',
            base_path() . '/database/sql/main_components.sql',
            base_path() . '/database/sql/main_tools.sql',
            base_path() . '/database/sql/main_good_types.sql',
            base_path() . '/database/sql/main_magic_numbers.sql',
            base_path() . '/database/sql/main_scarcity_types.sql',
            base_path() . '/database/sql/main_transaction_types.sql',
            base_path() . '/database/sql/main_world_types.sql',
            base_path() . '/database/sql/main_ingots_ores.sql',
        ];
        foreach($paths as $path) {
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }
    }
}
