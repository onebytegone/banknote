<?php

/**
 * Converts package data to arrray
 *
 * @copyright 2015 Ethan Smith
 */

class PackageExporter {

    public function exportPackage($package) {
        $self = $this;
        return array_map(function ($item) use ($self) {
            echo is_array($item) ? "Array" : get_class($item);

            if (is_array($item)) {
                return $self->exportPackage($item);
            }

            if ($item instanceof PackageIO) {
                return $item->exportToPackage();
            }

            return $item;
        }, $package);
    }
}

interface PackageIO {
    static public function buildFromPackage($data);
    public function exportToPackage();
}
