<?php
namespace Plank\MediaManager\Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\Actions\ProcessImage;
use Plank\MediaManager\Tests\TestCase;
use Ramsey\Uuid\Uuid;


class MediaManipulationTest extends TestCase
{

    public $root;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $storage;

    /**
     * @var MediaUploader
     */
    public $uploader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storage = Storage::disk('public');
        $this->root = Uuid::uuid4() . "-tests/";
        $this->storage->makeDirectory($this->root);
        $this->uploader = $this->app->make(MediaUploader::class);

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->storage->deleteDirectory($this->root);
        $this->storage->deleteDirectory('conversions');
    }


    /**
     * @test
     */
    public function an_image_can_be_resized()
    {
        $imageName = "test_image";
        $media = $this->uploader
            ->toDestination("public", $this->root)
            ->fromString(file_get_contents("https://source.unsplash.com/random/800x600"))
            ->useFilename($imageName)
            ->upload()
            ->refresh();

        ProcessImage::execute($media, 200, $imageName, "public");

        $conversion = getimagesize($this->storage->path(config('media-manager.conversions-directory') . $imageName));
        $this->assertEquals(200, $conversion[0]);
    }
}
