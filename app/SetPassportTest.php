<?php

namespace App;
use DB;
use DateTime;
use Laravel\Passport\ClientRepository;
/*
 * A trait to handle authorization based on users permissions for given controller
 */

trait SetPassportTest
{
    public function setPassportTest(){
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
