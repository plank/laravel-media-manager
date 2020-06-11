<?php

namespace App\Exceptions;

use Exception;

class MediaManagerException extends Exception
{

    public static function diskNotAllowed($disk)
    {
        return new static("You do not have permission to access the filesystem disk `{$disk}`. Verify your configurations for admin.media.allowed_disks.");
    }

    public static function diskNotFound($disk)
    {
        return new static("Cannot find a filesystem disk named `{$disk}`");
    }

    public static function directoryNotFound($disk, $path)
    {
        return new static("Cannot find a directory `{$path}` on filesystem `{$disk}`");
    }

    public static function directoryAlreadyExists($disk, $path)
    {
        return new static("Cannot create directory `{$path}` on filesystem `{$disk}` as another file or directory by that name already exists.");
    }

    public static function fileNotFound($disk, $path)
    {
        return new static("Cannot find a file `{$path}` on filesystem `{$disk}`");
    }
}
