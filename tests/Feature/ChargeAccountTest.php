<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChargeAccountTest extends TestCase
{
    use DatabaseMigrations;
    private $token;
    public function setUp():void{
        parent::setUp();


    }
    /** @test */
    public function check_charge_account(){

        $user =  factory(User::class)->create();

        Passport::actingAs($user);

        $response = $this->post('/api/charge',["price" => 200]);
        $response->assertStatus(200);

        $response = $this->post('/api/charge',["price" => 300]);
        $response->assertStatus(200);

        $this->assertEquals(500,$user->charges()->sum("price"));

    }
}
