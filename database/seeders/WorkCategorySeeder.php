<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\WorkCategory;
use Illuminate\Database\Seeder;

class WorkCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path = file_get_contents(base_path('/storage/app/public/work_categories.json'));
        $categoriesData = json_decode($path, true);

        foreach ($categoriesData as $categoryData) {
            $workCategory = WorkCategory::create([
                'name' => $categoryData['name'],
                'active' => $categoryData['active'],
            ]);

            foreach ($categoryData['services'] as $serviceData) {
                Service::create([
                    'work_category_id' => $workCategory->id,
                    'name' => $serviceData['name'],
                    'active' => $serviceData['active'],
                ]);
            }
        }
    }
}
