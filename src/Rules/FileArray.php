<?php

namespace Plank\MediaManager\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileArray implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $areFiles = false;
        if (is_array($value)) {
            foreach ($value as $item) {
                $areFiles = $areFiles && ($item instanceof UploadedFile && $item->isValid());
            }
        }
        return ($value instanceof UploadedFile && $value->isValid()) || $areFiles;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must upload a file or collection of files.';
    }
}
