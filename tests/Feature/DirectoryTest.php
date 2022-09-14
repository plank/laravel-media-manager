<?php

namespace Plank\MediaManager\Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Tests\TestCase;

class DirectoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private $disk = 'local';

    private function testSetup($initialState)
    {
        if (isset($initialState['directories'])) {
            $initialState['directories'] = array_unique($initialState['directories']);
            foreach ($initialState['directories'] as $directory) {
                Storage::disk($this->disk)->makeDirectory($directory);
            }
        }

        if (isset($initialState['files'])) {
            $initialState['files'] = array_unique($initialState['files']);
            foreach ($initialState['files'] as $file) {
                Storage::disk($this->disk)->put($file, '');

                $pathItems = explode('/', $file);
                $fullFilename = array_pop($pathItems);
                $filenameItems = explode('.', $fullFilename);
                $extension = array_pop($filenameItems);
                $filename = implode('.', $filenameItems);
                $directory = implode('/', $pathItems);

                $media = new Media();
                $media->disk = $this->disk;
                $media->directory = $directory;
                $media->filename = $filename;
                $media->extension = $extension;
                $media->mime_type = 'image/jpeg';
                $media->aggregate_type = 'image';
                $media->size = 1024;
                $media->save();
            }
        }
    }

    private function checkFinalState($finalState)
    {
        $items = [];
        if (isset($finalState['directories'])) {
            $items = array_merge($items, $finalState['directories']);
        }

        if (isset($finalState['files'])) {
            $items = array_merge($items, $finalState['files']);
        }

        foreach ($items as $item) {
            $this->assertTrue(Storage::disk($this->disk)->has($item));
        }
    }

    private function testCleanup($finalState)
    {
        if (isset($finalState['files'])) {
            foreach ($finalState['files'] as $file) {
                if (Storage::disk($this->disk)->exists($file)) {
                    Storage::disk($this->disk)->delete($file);
                }
            }
        }

        if (isset($finalState['directories'])) {
            foreach ($finalState['directories'] as $directory) {
                if (Storage::disk($this->disk)->exists($directory)) {
                    Storage::disk($this->disk)->deleteDirectory($directory);
                }
            }
        }
    }

    /**
     * Data provider to test creating directories
     */
    public function creatingProvider()
    {
        return [
            'test_directory_with_same_name_doesnt_exist' => [
                'initialState' => [],
                'finalState' => [
                    'directories' => [
                        'folder01',
                    ],
                ],
                'directoryToCreate' => 'folder01',
                'expectedSuccess' => true,
            ],
            'test_directory_with_same_name_already_exists' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                    ],
                ],
                'finalState' => [
                    'directories' => [
                        'folder01',
                    ],
                ],
                'directoryToCreate' => 'folder01',
                'expectedSuccess' => false,
            ],
        ];
    }

    /**
     * @param array  $initialState
     * @param array  $finalState
     * @param string $directoryToCreate
     * @param bool   $expectedSuccess
     *
     * @test
     * @dataProvider creatingProvider
     * */
    public function a_directory_can_be_created(array $initialState, array $finalState, string $directoryToCreate, bool $expectedSuccess): void
    {
        // setup
        $this->testSetup($initialState);

        // call endpoint
        $response = $this->post(
            route('media-api.directory.create'),
            [
                'disk' => $this->disk,
                'path' => $directoryToCreate,
            ],
        );

        // make assertions
        if ($expectedSuccess) {
            $response->assertOk();
            $response->assertJsonFragment([
                'success' => true,
                'path' => $directoryToCreate,
            ]);
        } else {
            $response->assertStatus(500);
            $this->assertTrue(isset($response->exception));
            $this->assertTrue($response->exception->getMessage() == "Cannot create directory `{$directoryToCreate}` on filesystem `{$this->disk}` as another file or directory by that name already exists.");
        }

        $this->assertTrue(Storage::disk($this->disk)->has($directoryToCreate));
        $this->checkFinalState($finalState);

        //cleanup
        $this->testCleanup($finalState);
    }

    /**
     * Data provider to test deleting directories
     */
    public function deletingProvider()
    {
        return [
            'test_directory_with_no_files' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                    ],
                ],
                'finalState' => [],
                'directoryToDelete' => 'folder01',
            ],
            'test_directory_with_one_file' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                    ],
                    'files' => [
                        'folder01/file01.jpg',
                    ],
                ],
                'finalState' => [],
                'directoryToDelete' => 'folder01',
            ],
            'test_directory_with_multiple_files' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                    ],
                    'files' => [
                        'folder01/file01.jpg',
                        'folder01/file02.jpg',
                        'folder01/file03.jpg',
                    ],
                ],
                'finalState' => [],
                'directoryToDelete' => 'folder01',
            ],
            'test_directory_multilevel_with_one_file' => [
                'initialState' => [
                    'directories' => [
                        'folder01/folder02/folder03',
                    ],
                    'files' => [
                        'folder01/folder02/folder03/file01.jpg',
                    ],
                ],
                'finalState' => [],
                'directoryToDelete' => 'folder01',
            ],
            'test_directory_multilevel_with_multiple_files' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder01/folder02/folder03',
                        'folder01/folder02/folder04',
                        'folder05',
                    ],
                    'files' => [
                        'folder01/folder02/folder03/file01.jpg',
                        'folder01/folder02/folder03/file02.jpg',
                        'folder01/folder02/file03.jpg',
                        'folder01/file04.jpg',
                        'folder01/file05.jpg',
                    ],
                ],
                'finalState' => [
                    'directories' => [
                        'folder05'
                    ],
                ],
                'directoryToDelete' => 'folder01',
            ],
            'test_directory_multilevel_with_multiple_files_name_collision' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder015',
                        'folder01/folder02/folder03',
                        'folder01/folder02/folder04',
                    ],
                    'files' => [
                        'folder01/file04.jpg',
                        'folder01/file05.jpg',
                        'folder01/folder02/file03.jpg',
                        'folder01/folder02/folder03/file01.jpg',
                        'folder01/folder02/folder03/file02.jpg',
                        'folder015/file06.jpg',
                    ],
                ],
                'finalState' => [
                    'directories' => [
                        'folder015',
                    ],
                    'files' => [
                        'folder015/file06.jpg',
                    ],
                ],
                'directoryToDelete' => 'folder01',
            ],
        ];
    }

    /**
     * @param array  $initialState
     * @param array  $finalState
     * @param string $directoryToDelete
     *
     * @test
     * @dataProvider deletingProvider
     * */
    public function a_directory_can_be_deleted(array $initialState, array $finalState, string $directoryToDelete): void
    {
        // setup
        $this->testSetup($initialState);

        // call endpoint
        $response = $this->post(route('media-api.directory.destroy'), [
            'disk' => $this->disk,
            'path' => $directoryToDelete,
        ]);

        // make assertions
        $response->assertOk();
        $response->assertJsonFragment([
            'success' => true,
            'parentFolder' => $directoryToDelete,
        ]);

        $count = Media::where('disk', $this->disk)->where(function (Builder $q) use ($directoryToDelete) {
            $directoryToDelete = str_replace(['%', '_'], ['\%', '\_'], $directoryToDelete);
            $q->where('directory', $directoryToDelete);
            $q->orWhere('directory', 'like', $directoryToDelete . '/%');
        })->count();

        $this->assertTrue($count == 0);
        $this->assertFalse(Storage::disk($this->disk)->has($directoryToDelete));
        $this->checkFinalState($finalState);

        // cleanup
        $this->testCleanup($finalState);
    }

    /**
     * Data provider to test moving directories
     */
    public function movingProvider()
    {
        return [
            'test_directory_with_no_files' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder02',
                    ],
                ],
                'finalState' => [
                    'directories' => [
                        'folder02',
                        'folder02/folder01',
                    ],
                ],
                'directoryToMove' => 'folder01',
                'destination' => 'folder02',
                'rename' => null,
                'expectedSuccess' => true,
            ],
            'test_directory_with_one_file' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder02',
                    ],
                    'files' => [
                        'folder01/file01.jpg',
                    ]
                ],
                'finalState' => [
                    'directories' => [
                        'folder02',
                        'folder02/folder01',
                    ],
                    'files' => [
                        'folder02/folder01/file01.jpg',
                    ]
                ],
                'directoryToMove' => 'folder01',
                'destination' => 'folder02',
                'rename' => null,
                'expectedSuccess' => true,
            ],
            'test_directory_with_multiple_files' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder02',
                    ],
                    'files' => [
                        'folder01/file01.jpg',
                        'folder01/file02.jpg',
                        'folder01/file03.jpg',
                    ]
                ],
                'finalState' => [
                    'directories' => [
                        'folder02',
                        'folder02/folder01',
                    ],
                    'files' => [
                        'folder02/folder01/file01.jpg',
                        'folder02/folder01/file02.jpg',
                        'folder02/folder01/file03.jpg',
                    ]
                ],
                'directoryToMove' => 'folder01',
                'destination' => 'folder02',
                'rename' => null,
                'expectedSuccess' => true,
            ],
            'test_directory_with_no_files_name_collision' => [
                'initialState' => [
                    'directories' => [
                        'folder01',
                        'folder02',
                        'folder02/folder01'
                    ],
                ],
                'finalState' => [
                    'directories' => [
                        'folder01',
                        'folder02',
                        'folder02/folder01',
                    ],
                ],
                'directoryToMove' => 'folder01',
                'destination' => 'folder02',
                'rename' => null,
                'expectedSuccess' => false,
            ],
        ];
    }

    /**
     * @param array       $initialState
     * @param array       $finalState
     * @param string      $directoryToMove
     * @param string      $destination
     * @param string|null $rename
     * @param bool        $expectedSuccess
     *
     * @test
     * @dataProvider movingProvider
     * */
    public function a_directory_can_be_moved(array $initialState, array $finalState, string $directoryToMove, string $destination, $rename, bool $expectedSuccess): void
    {
        // setup
        $this->testSetup($initialState);

        // call endpoint
        $response = $this->post(route('media-api.directory.update'), [
            'disk' => $this->disk,
            'source' => $directoryToMove,
            'destination' => $destination,
            'rename' => $rename,
        ]);

        $finalPath = $destination . '/' . $directoryToMove;

        // make assertions
        if ($expectedSuccess) {
            $response->assertOk();
            $response->assertJsonFragment([
                'success' => true,
            ]);
            $this->assertFalse(Storage::disk($this->disk)->has($directoryToMove));
        } else {
            $response->assertStatus(500);
            $this->assertTrue(isset($response->exception));
            $this->assertTrue($response->exception->getMessage() == "Cannot create directory `{$finalPath}` on filesystem `{$this->disk}` as another file or directory by that name already exists.");
        }
        $this->assertTrue(Storage::disk($this->disk)->has($finalPath));
        $this->checkFinalState($finalState);

        // cleanup
        $this->testCleanup($finalState);
    }

    // an_empty_directory_can_be_renamed
    // a_directory_containing_media_can_be_renamed
}
