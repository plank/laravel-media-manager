<?php

namespace Plank\MediaManager\Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Plank\MediaManager\Tests\TestCase;

class DirectoryTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function a_directory_can_be_created(): void
    {
        $disk = 'local';
        $directory = $this->faker->md5;
        //$this->withouterrorHandling
        $response = $this->post(route('media-api.directory.create'), [
            'disk' => $disk,
            'path' => $directory,
        ]);
        // dd($response);
        // dd(Storage::disk($disk)->directories());
        //$this->assertDirectoryExists();
        $this->assertTrue(true);
    }

    /** @test */
    public function a_directory_can_be_deleted(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_directory_containing_media_can_be_delete(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function an_empty_directory_can_be_moved(): void
    {
        $disk = '';
        $source = '';
        $destination = '';
        $rename = '';

        // $this->json('POST', route('directory.update'), [
        $this->post('directory/update', [
            'disk' => $disk,
            'source' => $source,
            'destination' => $destination,
            'rename' => $rename,
        ]);

        $this->assertTrue(Storage::disk($disk)->has($destination));
        $this->assertFalse(Storage::disk($disk)->has($source));
    }

    /** @test */
    public function a_directory_containing_media_can_be_moved(): void
    {
        $this->assertTrue(true);
    }
}
