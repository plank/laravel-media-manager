<?php
namespace Plank\MediaManager\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Plank\MediaManager\MediaManagerServiceProvider;

class DirectoryTest extends TestCase
{

    /** @test */
    public function a_directory_can_be_created()
    {
        //$this->post('directory/create', ['path' => 'test']);
        //dd(Storage::allDirectories());
        //$this->assertDirectoryExists();
    }

    public function a_directory_can_be_deleted()
    {
        $this->assertTrue(true);
    }

    public function a_directory_containing_media_can_be_delete()
    {
        $this->assertTrue(true);
    }


}
