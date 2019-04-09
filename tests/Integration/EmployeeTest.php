<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * To run just this test: vendor/bin/phpunit --filter EmployeeTest
 */
class EmployeeTest extends TestCase
{
    public function testLoadEmployeesAsGuestThenRedirect()
    {
        $response = $this->get('/employee');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testLoadEmployeesWithAuthThenSucceed()
    {
        $response = $this->actingAs($this->user)->get('/employee');
        $response->assertOk();
        $response->assertViewIs('employee.index');
    }

    public function testCreateEmployeeWithMissingFieldsThenFail()
    {
        $response = $this->actingAs($this->user)->post('/employee', ['employee_firstname' => 'Billie']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['employee_lastname']);
    }

    public function testCreateEmployeeThenSucceed()
    {
        $response = $this->actingAs($this->user)->post('/employee', ['employee_firstname' => 'Billie', 'employee_lastname' => 'Eyelash']);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testGetInvalidEmployeeThenFail()
    {
        $response = $this->actingAs($this->user)->get('/employee/31415926535');
        $response->assertNotFound();
    }

    public function testGetEmployeeThenSucceed()
    {
        $employee = factory(\App\Employee::class)->create();
        $response = $this->actingAs($this->user)->get('/employee/' . $employee->id);
        $response->assertOk();
        $response->assertSessionHasNoErrors();
    }

    public function testUpdateEmployeeThenSucceed()
    {
        $employee = factory(\App\Employee::class)->create(['firstname' => 'Johnny', 'lastname' => 'Jones']);
        $response = $this->actingAs($this->user)->put('/employee/' . $employee->id, ['employee_firstname' => 'Billie', 'employee_lastname' => 'Jones']);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $employee->refresh();
        $this->assertEquals('Billie', $employee->firstname);
    }

    public function testDeleteEmployeeThenSucceed()
    {
        $employee = factory(\App\Employee::class)->create(['firstname' => 'Johnny', 'lastname' => 'Jones']);
        $response = $this->actingAs($this->user)->delete('/employee/' . $employee->id);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertNull(\App\Employee::find($employee->id));
    }
}
