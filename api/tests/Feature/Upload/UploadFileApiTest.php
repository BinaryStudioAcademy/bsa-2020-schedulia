<?php

namespace Tests\Feature\Upload;

use App\Entity\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadFileApiTest extends TestCase
{
    public function testUnauthenticated()
    {
        Storage::fake('local');

        $testFile = __DIR__ . '/testFiles/binary-academy.png';
        $type = 'avatar';
        $uploadedFile = new UploadedFile(
            $testFile,
            'avatar.png',
            'image/png',
            null,
            true
        );

        $data = [
            'file' => $uploadedFile,
            'type' => $type
        ];
        
        $response = $this->json("POST", "/api/v1/files", $data);

        $response->assertStatus(401)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJson(
                [
                    "error" => ["message" => 'Unauthenticated.']
                ]
            );
    }

    public function testUpload()
    {
        $user = factory(User::class)->create();

        Storage::fake('local');

        $testFile = __DIR__ . '/testFiles/binary-academy.png';
        $type = 'avatar';

        $uploadedFile = new UploadedFile(
            $testFile,
            'avatar.png',
            'image/png',
            null,
            true
        );

        $data = [
            'file' => $uploadedFile,
            'type' => $type
        ];

        $response = $this->actingAs($user)->json("POST", "/api/v1/files", $data);

        $content = $response->assertStatus(201)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'data' => [
                    'url'
                ]
            ])->decodeResponseJson('data');

        Storage::disk('local')->assertExists($content['url']);
    }
}
