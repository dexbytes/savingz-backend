<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
          
        $this->call(CreatePermissionSeeder::class);  
        $this->call(CreateAdminPermissionsSeeder::class);
        $this->call(CreateProviderPermissionsSeeder::class);
       
       // $this->call(CreateAboutUsPageSeeder::class);
        $this->call(FaqCategorySeeder::class);

 
 
    }
}
