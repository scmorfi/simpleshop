<?php

namespace Tests\Unit;

use App\Job;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function check_add_new_queue_after_register(){
        $user = factory(User::class)->create();
        $user->sendEmailVerificationNotification();
        $job = Job::get();
        $this->assertCount(1,$job);
    }

    /** @test */
    public function check_create_user(){
        $request = ["name" => "ali","email" => "a@b.com","password" => "123456","password_confirmation" => "123456"];
        $token = User::createUser($request);
        dd($token);
        $this->assertNotNull($token);
    }
}
