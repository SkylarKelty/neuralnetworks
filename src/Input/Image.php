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
        $w = $image->getImageWidth();
        $h = $image->getImageHeight();

        while ($w * $h * 3 > $max) {
            $tmp = $max / 3;
            $aspect = $w / $h;
            $w = $w - 10;
            $h = $h - floor(10 * $a);
        }

        $image->adaptiveResizeImage($w, $h);

        // Build a flattened RGB array.
        $flattened = array();

        $it = $image->getPixelIterator();
        foreach ($it as $row => $pixels) {
            $r[$row] = array();
            $g[$row] = array();
            $b[$row] = array();
            foreach ($pixels as $column => $pixel) {
                $rgb = $pixel->getColor();
                $flattened[] = $rgb[0];
                $flattened[] = $rgb[1];
                $flattened[] = $rgb[2];
            }
        }

        return $flattened;
    }
}
