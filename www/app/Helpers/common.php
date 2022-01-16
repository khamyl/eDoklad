<?php
/**
 * URL: https://stackoverflow.com/questions/3942878/how-to-decide-font-color-in-white-or-black-depending-on-background-color 
 * fg_color: calculated forground (font) color to be in contrast with the background color to make the text better readable
 */
function isColorDarkAdv($color){

    $calcContrast = function ($c) {
        if ($c <= 0.03928) {
            return $c / 12.92;
        }
        else {
            return pow(($c + 0.055) / 1.055, 2.4);
        }
    };

    $r = hexdec(substr($color, 1, 2));
    $g = hexdec(substr($color, 3, 2));
    $b = hexdec(substr($color, 5, 2));

    //Calculate contrast
    $norm_colors = [$r / 255, $g / 255, $b / 255];
    $c = array_map($calcContrast, $norm_colors);

    //Calculate luminance
    $l = 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
    return ($l < 0.270);

}

function isColorDark($color) {
    
    $r = hexdec(substr($color, 1, 2));
    $g = hexdec(substr($color, 3, 2));
    $b = hexdec(substr($color, 5, 2));

    return (($r*0.299 + $g*0.587 + $b*0.114) < 186);
} 