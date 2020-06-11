<?php
namespace Plank\MediaManager;

use App\Exceptions\MediaManagerException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

/**
 * Responsible for handling all file / image transformations, such as resizing, compressing, etc...
 * Class MediaManager
 * @package Plank\MediaManager
 */
class MediaManager
{
    const DRIVER_IMAGICK = 'imagick';
    const DRIVER_GD = 'gd';
    const RESIZE_WIDTH = 'widen';
    const RESIZE_HEIGHT = 'heighten';

    public $config;
    public $manager;
    public $media;

    /**
     * Constructor.
     * @param string $imageDriver
     * @param array|null $config
     */
    public function __construct($media = Media::class, array $config = null, $imageDriver = self::DRIVER_IMAGICK)
    {
        $this->config = $config ?: config('media-manager', []);
        $this->manager = new ImageManager(['driver' => $imageDriver]);
        $this->media = $media;
    }

    public function resize($image, $dimension, $disk = null, $method = self::RESIZE_WIDTH)
    {
        $disk = $this->verifyDisk($disk);
        if ($image instanceof $this->media) {
            $imagePath = $image->getAbsolutePath;
        } else {
            $imagePath = $this->media->whereBasename($image)->firstOrFail()->getAbsolutePath();
        }
        return $this->manager->make($image)->$method($dimension)->save();
    }

    public function verifyDisk($disk = null)
    {
        if (!$disk) {
            $disk = config('mediable.default_disk');
        }

        if (!in_array($disk, config('mediable.allowed_disks'))) {
            throw MediaManagerException::diskNotAllowed($disk);
        }

        if (is_null(config("filesystems.disks.{$disk}"))) {
            throw MediaManagerException::diskNotFound($disk);
        }
        return $disk;
    }

    public function verifyDirectory($disk, $directory)
    {
        $filesystem = Storage::disk($disk);
        if (!$filesystem->isDirectory($directory)) {
            MediaManagerException::directoryNotFound($disk, $directory);
        }
        return trim($directory, '/');
    }
}
