<?php
namespace Plank\MediaManager;

use App\Exceptions\MediaManagerException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use phpDocumentor\Reflection\Types\ClassString;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

/**
 * Responsible for handling all file / image transformations, such as resizing, compressing, etc...
 * A convention of this class is that any functions that perform a image transformation, should accept $image as the *first* parameter
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
     * @param ClassString $media
     * @param array|null $config
     * @param string $imageDriver
     */
    public function __construct($media = Media::class, array $config = null, $imageDriver = self::DRIVER_IMAGICK)
    {
        $this->config = $config ?: config('media-manager', []);
        $this->manager = new ImageManager(['driver' => $imageDriver]);
        $this->media = $media;
    }

    /**
     * Takes an image or filename and attempts to change it's size to match the passed size on via the dimension specifed
     * by $method. That is to say it will be $dimension long on $method (height or width) while maintianing aspect ratio
     * @param $image
     * @param $dimension
     * @param null $disk
     * @param string $method
     * @return Image
     * @throws MediaManagerException
     */
    public function resize($image, $dimension, $method = self::RESIZE_WIDTH)
    {
        if ($image instanceof $this->media) {
            $imagePath = $image->getAbsolutePath;
        } else {
            $imagePath = $this->media->whereBasename($image)->firstOrFail()->getAbsolutePath();
        }
        return $this->manager->make($image)->$method($dimension)->save();
    }

    /**
     * Checks that the passed disk exists, and throws an exception if the disk is not accessible or non-existant. if
     * no disk is passed, the default mediable disk is passed instead.
     * @param null $disk
     * @return \Illuminate\Config\Repository|mixed|null
     * @throws MediaManagerException
     */
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

    /**
     * Checks for the existiance of the passed directory on the specified disk.
     * @param $disk
     * @param $directory
     * @return string
     */
    public function verifyDirectory($disk, $directory)
    {
        $filesystem = Storage::disk($disk);
        if (!$filesystem->isDirectory($directory)) {
            MediaManagerException::directoryNotFound($disk, $directory);
        }
        return trim($directory, '/');
    }
}
