<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Populate the companies table with test data
     *
     * php artisan db:seed --class=CompaniesTableSeeder --force
     *
     * @return void
     */
    public function run()
    {
        factory(App\Company::class, mt_rand(100, 150))->create()->each(function ($company) {
            // 20% will have no logos uploaded to demonstrate how that looks
            if (mt_rand(1, 100) > 20) {
                $faker = Faker\Factory::create();
                try {
                    $image_url = $faker->imageUrl($faker->randomElement([100, 200, 300]), $faker->randomElement([100, 200, 300]), 'abstract');
                    $image = \Image::make($image_url);
                    $image->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image_name = 'company_' . $company->id . '.' . $this->getLogoExtension($image);
                    $image_path = public_path('storage/' . $image_name);
                    $image->save($image_path);
                    $company->logo = $image_name;
                    $company->save();
                } catch (\Exception $e) {
                    // Just skip saving the image and setting the logo path for this company
                    // The random image generator used by faker (https://lorempixel.com) can frequently send some images that can't be process
                }
            }
        });
    }

    /**
     * Get the file extension for the company's logo image.
     *
     * @return string   URL to the company's logo image or the default image.
     */
    public function getLogoExtension(\Intervention\Image\Image $image)
    {
        $allowed = ['gif' => 'image/gif', 'jpg' => 'image/jpeg', 'pjpg' => 'image/jpeg', 'png' => 'image/png'];
        if ($format = array_search($image->mime(), $allowed, true)) {
            return $format;
        }
        return 'jpg';
    }
}
