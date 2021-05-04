<?php
namespace Plank\MediaManager\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Tests\TestCase;
use Ramsey\Uuid\Uuid;


class DirectoryTest extends TestCase
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
    public function a_directory_can_be_created()
    {
        $path = $this->root . 'test';
        $create = $this->post('/media-api/directory/create', ['path' => $path, 'disk' => "public"]);
        $content = $create->getOriginalContent();

        $create->assertStatus(200);
        $this->assertTrue($content['success']);
        $this->assertDirectoryExists($this->storage->path($path));
    }

    /**
     * @test
     */
    public function a_directory_can_be_deleted()
    {
        $path = $this->root . 'test';
        $this->storage->makeDirectory($path);
        $destroy = $this->post('/media-api/directory/destroy', ['path' => $path, 'disk' => "public"]);
        $content = $destroy->getOriginalContent();

        $destroy->assertStatus(200);
        $this->assertTrue($content['success']);
        // Deprecation Notice: Use assertDirectoryDoesNotExist after moving to PHPUnit 10
        $this->assertDirectoryNotExists($this->storage->path($path));
    }

    /**
     * @test
     */
    public function a_directory_containing_media_can_be_updated()
    {
        $path = $this->root . 'fake';
        $childPath = $path . "-child";
        $rename = "child-directory";
        $this->storage->makeDirectory($path);
        $this->storage->makeDirectory($childPath);
        $this->storage->put($path . "-child/important-data.txt", "a" . str_repeat("h", rand(1, 50000)));

        // until object based factories are the only thing we can use, we do this painfully...
        $media = new Media();
        $media->directory = $childPath;
        $media->filename = "important-data";
        $media->extension = "txt";
        $media->mime_type = "text/plain";
        $media->aggregate_type = "text";
        $media->size = 400;
        $media->disk = 'public';
        $media->save();

        $update = $this->post("/media-api/directory/update", [
            'disk' => "public",
            'source' => $childPath,
            'destination' => $path,
            'rename' => $rename
        ]);

        $content = $update->getOriginalContent();

        $destination = $path . "/{$rename}";
        // Check the directory was moved and renamed properly
        $update->assertStatus(200);
        $this->assertDirectoryExists($this->storage->path($destination));
        $this->assertFileExists($this->storage->path($destination) . "/important-data.txt");
        $this->assertEquals($destination, $media->refresh()->directory);
        $this->assertTrue($content['success']);
    }


}
