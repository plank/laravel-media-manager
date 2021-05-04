<?php

namespace Plank\MediaManager\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Tests\TestCase;
use Ramsey\Uuid\Uuid;

class MediaTest extends TestCase
{
    public $root;

    public $storage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storage = Storage::disk('public');
        $this->root = Uuid::uuid4() . "-tests/";
        $this->storage->makeDirectory($this->root);
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
    public function an_image_can_be_uploaded()
    {
        $upload = $this->post("/media-api/create", [
            'file' => UploadedFile::fake()->image("fakeImage.png", 200, 200),
            'disk' => "public",
            'path' => $this->root,
            'title' => "Test Title",
            'alt' => "Test alt text",
            'caption' => "Test caption",
            'credit' => "Test McTesterson",
            'source' => "The Test institution for Tests"

        ]);
        $content = $upload->getOriginalContent();

        $upload->assertStatus(200);
        $this->assertTrue(count($content) == 1);

    }

    /**
     * @test
     */
    public function an_image_can_be_deleted()
    {
        $media = $this->fakeFile($this->root);

        $destroy = $this->post('/media-api/destroy', [
            'id' => $media->id
        ]);
        $content = $destroy->getOriginalContent();

        $destroy->assertStatus(200);
        $this->assertTrue($content == 1);
    }

    /**
     * @test
     */
    public function an_image_can_be_moved()
    {
        $destination = $this->root . "destination";
        $newFilename = "new-important-data";
        $media = $this->fakeFile($this->root);
        $this->storage->makeDirectory($destination);

        $update = $this->post('/media-api/update', [
            'disk' => "public",
            'id' => $media->id,
            'path' => $destination,
            'rename' => $newFilename
        ]);
        $content = $update->getOriginalContent();

        $update->assertStatus(200);
        $this->assertTrue($content->filename == $newFilename);
        $this->assertTrue($content->directory == $destination);
    }

    /**
     * @test
     */
    public function a_list_of_all_images_and_directories_can_be_retrieved()
    {
        $this->fakeFile($this->root, "file1");
        $this->fakeFile($this->root, "file2");
        $this->fakeFile($this->root, "file3");
        $subDirectory = $this->root . "subdirectory";
        $this->storage->makeDirectory($subDirectory);
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        $index = $this->get("/media-api/index/{$this->root}");
        $content = $index->getOriginalContent();

        $index->assertStatus(200);
        $this->assertEquals([['name' => $subDirectory, 'timestamp' => $timestamp]], $content['subdirectories']);
        $this->assertEquals(["file1", "file2", "file3"], $content['media']->pluck('filename')->toArray());

    }

    private function fakeFile($path, $filename = "important-data")
    {
        $this->storage->put(trim($path, "/") . "/{$filename}.txt", "a" . str_repeat("h", rand(1, 50000)));
        $media = new Media();
        $media->directory = $path;
        $media->filename = $filename;
        $media->extension = "txt";
        $media->mime_type = "text/plain";
        $media->aggregate_type = "text";
        $media->size = 400;
        $media->disk = 'public';
        $media->save();

        return $media->refresh();
    }


}
