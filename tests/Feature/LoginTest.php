<?php

namespace Tests\Feature;


use App\User;
use Tests\TestCase;
use App\PassportTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations,PassportTest;
    public function setUp():void{
        parent::setUp();
        $this->setPassportTest();

    }
    public function loginPost($params){
        return $this->post('api/login',$params);
    }
    public function loginData($type,$verified){
        $loginParamters = [
            ["email" => "a@b.com","password" => "123456"], // true data
            ["email" => "a@b.com","password" => "12346"], // Wrong password
            ["email" => "b@b.com","password" => "123456"], // Wrong email
        ];
        factory(User::class)->state($verified)->create(["email" =>"a@b.com","password" => bcrypt("123456")]);

        $response = $this->loginPost($loginParamters[$type]);
        return $response;
    }
    public function invalidParametrs(){
        $response = $this->loginPost(["email" => "a@b.com","password" => "12345"]);
        $response->assertStatus(401);
    }
    /** @test */
    public function check_login_user_verified()
    {
        $response = $this->loginData(0,"verified");
        $response->assertStatus(200);
    }
    /** @test */
    public function check_login_user_unverified()
    {
        $response = $this->loginData(0,"unverified");
        $response->assertStatus(403);
    }
    /** @test */
    public function check_login_invalid_email()
    {
        $response = $this->loginData(2,"verified");
        $response->assertStatus(401);
    }
    /** @test */
    public function check_login_invalid_password()
    {
        $response = $this->loginData(1,"verified");
        $response->assertStatus(401);
    }
    /** @test */
    public function check_dont_login_after_5_times_invalid_data()
    {
        factory(User::class)->state("verified")->create(["email" =>"a@b.com","password" => bcrypt("123456")]);

        for($i=0;$i<5;$i++)
            $this->invalidParametrs();

        $response = $this->loginPost(["email" => "a@b.com","password" => "123456"]);
        $response->assertStatus(402);
    }


}
