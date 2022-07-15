<?php

namespace Plank\MediaManager\Tests\Feature;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Plank\MediaManager\MediaManagerServiceProvider;

class MediaTest extends TestCase
{
    public function an_image_can_be_uploaded()
    {
        $this->assertTrue(true);
    }

    public function an_image_can_be_deleted()
    {
        $this->assertTrue(true);
    }

    public function an_image_can_be_moved()
    {
        $this->assertTrue(true);
    }

    public function a_list_of_all_images_and_directories_can_be_retrieved()
    {
        $this->assertTrue(true);

    }

    // more tests...

    // create a folder
    // - create a folder with a name that doesn't exist
    // - create a folder with a name that already exists at the same level
    // - create a folder with a name that exists on another level

    // delete a folder
	// - delete an empty folder
	// - delete a folder with a file
	// - delete a folder with a folder with a file

    // move a folder
    // - move an empty folder
    // - move a folder with a file
    // - move a folder with an empty folder
    // - move a folder with a folder with a file
    // - move a folder that has the same name as a folder in another level
}
