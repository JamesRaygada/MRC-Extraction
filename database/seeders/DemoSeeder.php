<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder {
  public function run(): void {
    Contract::create(['title'=>'Sample Contract A','public_id'=>Str::uuid()]);
  }
}
