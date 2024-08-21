<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{

    public function testGetAllUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/utilisateur/');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        // Décoder le contenu JSON
        $data = json_decode($responseContent, true);
        $this->assertResponseIsSuccessful();
    }


    public function testGetOneUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/utilisateur/1');

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        // Décoder le contenu JSON
        $data = json_decode($responseContent, true);
        $this->assertEquals('Patrick',  $data['nom']);

    }


    public function testCheckUser(): void
    {
        $login = 'm.p@gmail.com';
        $password = '123';

        $client = static::createClient();
        $client->request('POST', '/utilisateur/user/CheckUser?login='.$login.'&password='.$password,
                [],
                [],
                ['CONTENT_TYPE' => 'multipart/form-data'],);

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        // Décoder le contenu JSON
        $data = json_decode($responseContent, true);
        $this->assertEquals('Patrick',  $data['nom']);

    }

    public function testGetListSearchUser(){
        $data = [
            'prenom' => '',
            'nom' => 'Pa',
        ];

        $json = json_encode($data);

        $client = static::createClient();
        $client->request(
            'POST',
            '/utilisateur/user/SearchUser',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        // Décoder le contenu JSON
        $data = json_decode($responseContent, true);
        $this->assertResponseIsSuccessful();
    }

    public function testAddOneUser(): void
    {

        $data = [
            'prenom' => 'prenomTest',
            'nom' => 'test',
        ];

        $json = json_encode($data);

        $client = static::createClient();
        $client->request(
            'POST',
            '/utilisateur/user/SearchUser',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );
        $responseContent = $client->getResponse()->getContent();
        $data = json_decode($responseContent, true);

        // var_dump($data[0]);
        // exit;

        $id = strval($data[0]['id']);
        if(!empty($data)){
            
            $client->request(
                'DELETE',
                '/utilisateur/'.$id.'',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );
        }


        $data = [
            'nom' => 'test',
            'prenom' => 'prenomTest',
            'mail' => 'pt.t@gmail.com',
            'motDePasse' => 'test',
            'departement' => 'Test',
            'id_role' => 1
        ];
        $json = json_encode($data);

        // $client = static::createClient();
        $client->request(
            'POST',
            '/utilisateur/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();

        // Décoder le contenu JSON
        $data = json_decode($responseContent, true);
        $this->assertEquals('test',  $data['nom']);

    }


    // public function testEditUser(): void
    // {
    //     $data = [
    //         'prenom' => 'prenomTest',
    //         'nom' => 'testUpdate'
    //     ];
    //     $json = json_encode($data);

    //     $client = static::createClient();
    //     $client->request(
    //         'PUT',
    //         '/utilisateur/4',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         $json
    //     );

    //     $this->assertResponseIsSuccessful();
    // }
    

    // public function testDeleteUser()
    // {
    //     $client = static::createClient();
    //     $client->request(
    //         'DELETE',
    //         '/utilisateur/4',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json']
    //     );

    //     $this->assertResponseIsSuccessful();
    // }



}