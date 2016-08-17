<?php

namespace KeltyNN\Serializers;

class Image {
    /**
     * Serialize a given image for a neural net.
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public static function serialize($filename, $network) {
        $max = $network->getInputCount();

        $image = new \Imagick($filename);
    }
}
