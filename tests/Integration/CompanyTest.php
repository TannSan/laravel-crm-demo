<?php

namespace Tests\Integration;

use App\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * To run just this test: vendor/bin/phpunit --filter CompanyTest
 */
class CompanyTest extends TestCase
{
    public function testLoadCompaniesAsGuestThenRedirect()
    {
        $response = $this->get('/company');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testLoadCompaniesWithAuthThenSucceed()
    {
        $response = $this->actingAs($this->user)->get('/company');
        $response->assertOk();
        $response->assertViewIs('company.index');
    }

    public function testCreateCompanyWithMissingFieldsThenFail()
    {
        $response = $this->actingAs($this->user)->post('/company', ['company_website' => 'http://www.web.site']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['company_name']);
    }

    public function testCreateCompanyThenSucceed()
    {
        $response = $this->actingAs($this->user)->post('/company', ['company_name' => 'Quacky Limited']);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testGetInvalidCompanyThenFail()
    {
        $response = $this->actingAs($this->user)->get('/company/31415926535');
        $response->assertNotFound();
    }

    public function testGetCompanyThenSucceed()
    {
        $company = factory(Company::class)->create(['name' => 'Quacky Limited', 'website' => 'http://www.web.site']);
        $response = $this->actingAs($this->user)->get('/company/' . $company->id);
        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

    public function testUpdateCompanyThenSucceed()
    {
        $company = factory(Company::class)->create(['name' => 'Quacky Limited', 'website' => 'http://www.web.site']);
        $response = $this->actingAs($this->user)->put('/company/' . $company->id, ['company_name' => 'Daffy Limited', 'company_website' => 'http://www.web.com']);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $company->refresh();
        $this->assertEquals('Daffy Limited', $company->name);
    }

    public function testUploadingCompanyLogoThenSucceed()
    {
        $file = UploadedFile::fake()->image('test-logo.jpg', 500, 500);
        $company = factory(Company::class)->create(['name' => 'Quacky Limited']);
        $response = $this->actingAs($this->user)->put('/company/' . $company->id, ['company_name' => 'Daffy Limited', 'company_logo_upload' => $file]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $company->refresh();
        $file_path = public_path('storage/' . $company->logo);
        $this->assertFileExists($file_path);
        $this->assertTrue(\File::delete($file_path));
    }

    public function testDeleteCompanyThenSucceed()
    {
        $company = factory(Company::class)->create(['name' => 'Quacky Limited']);
        $response = $this->actingAs($this->user)->delete('/company/' . $company->id);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertNull(Company::find($company->id));
    }
}
