<?php
session_start();

// Generate random CAPTCHA code
$captcha_code = substr(md5(rand()), 0, 6);
$_SESSION['captcha'] = $captcha_code;

// Set content type
header('Content-Type: image/png');

// Create image
$image_width = 150;
$image_height = 50;
$image = imagecreate($image_width, $image_height);

// Colors
$background_color = imagecolorallocate($image, 255, 255, 255); // White
$text_color = imagecolorallocate($image, 0, 0, 0);             // Black
$line_color = imagecolorallocate($image, 64, 64, 64);          // Grey
$dot_color = imagecolorallocate($image, 100, 100, 100);        // Dark Grey

// Add random lines
for ($i = 0; $i < 10; $i++) {
    imageline(
        $image,
        rand(0, $image_width),
        rand(0, $image_height),
        rand(0, $image_width),
        rand(0, $image_height),
        $line_color
    );
}

// Add random dots
for ($i = 0; $i < 500; $i++) {
    imagesetpixel(
        $image,
        rand(0, $image_width),
        rand(0, $image_height),
        $dot_color
    );
}

// Add distorted text
$font = 5;
$x = rand(10, 20);
for ($i = 0; $i < strlen($captcha_code); $i++) {
    $angle = rand(-30, 30); // Random angle for each character
    $y = rand(10, $image_height / 2); // Random Y position
    imagestring($image, $font, $x, $y, $captcha_code[$i], $text_color);
    $x += 20; // Move X position for next character
}

// Output image
imagepng($image);
imagedestroy($image);
?>


