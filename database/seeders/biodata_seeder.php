<?php

namespace Database\Seeders;

use App\Models\Biodata;
use Illuminate\Database\Seeder;

class biodata_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Biodata::create([
            'nama'=>'Cloudias',
            'no_hp' => "081312341",
            'alamat'=>'kuwik',
            'hobi'=>'main',
            'foto'=>'/image/foto.jpg',
        ]);
    }
}
