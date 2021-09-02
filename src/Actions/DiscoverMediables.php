<?php


namespace Plank\MediaManager\Actions;


class DiscoverMediables
{
    /**
     * Attempt to find all classes that use the Mediable trait.
     * Achieves this by first ensuring the class is a model as well as having the method bootMediable.
     * Note: this method may miss classes that are not auto-discovered during bootstrapping
     * @return array
     */
    public static function execute()
    {
        return collect(get_declared_classes())->filter(function ($class) {
            return (substr($class, 0, 11) === 'App\Models\\') && method_exists($class, "bootMediable");
        })->toArray();
    }
}
