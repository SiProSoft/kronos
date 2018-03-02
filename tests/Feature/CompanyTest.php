<?php

namespace Tests\Feature;

use App\Company;
use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    // use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->assertCount(1, Company::forUser()->get());
        $this->assertCount(0, Company::forUser()->visible()->get());

        $this->assertNotNull($user);
        
        $newCompany = factory(Company::class)->create();
        $newCompany->users()->attach($user->id);
        $newCompany->save();

        // $comp = Company::find($newCompany->id);

        // var_dump($comp);
        
        // $newCompany->users()->attach($user);
        // $newCompany->save();
        
        $this->assertCount(2, Company::forUser()->get());
        $this->assertCount(1, Company::forUser()->visible()->get());

        $this->assertInternalType('string', auth()->user()->name);
        $this->assertInstanceOf(Company::class, company());

        $companies = Company::forUser($user)->get();
        
        $this->assertTrue(count($companies) > 0);
        // $this->assertFalse(count($company1) > 0);
        
    }

}
