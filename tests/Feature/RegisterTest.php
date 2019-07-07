<?php

namespace Tests\Feature;


use App\Job;
use App\User;
use Tests\TestCase;
use App\SetPassportTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    use DatabaseMigrations,SetPassportTest;
    public function setUp():void{
        parent::setUp();
        $this->setPassportTest();

    }
    public function registerPost($params){
        return $this->post('api/register',$params);
    }
    /** @test */
    public function check_register_user()
    {
        $response = $this->registerPost(["name" => "ali","email" => "b@b.com","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(200);
        $job = Job::get();
        $this->assertCount(1,$job);
    }
    /** @test */
    public function check_required_name()
    {
        $response = $this->registerPost(["name" => "","email" => "b@b.com","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_required_email()
    {
        $response = $this->registerPost(["name" => "ali","email" => "","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_valild_email()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(401);
    }

    /** @test */
    public function check_unique_email()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(200);
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "123456","password_confirmation" => "123456"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_required_password()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "","password_confirmation" => "123456"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_min_password()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "12345","password_confirmation" => "12345"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_required_password_confirmation()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "123456","password_confirmation" => ""]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_password_confirmation()
    {
        $response = $this->registerPost(["name" => "ali","email" => "a@b.com","password" => "123456","password_confirmation" => "12345"]);
        $response->assertStatus(401);
    }
}
