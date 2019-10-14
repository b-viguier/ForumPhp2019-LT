<?php
require __DIR__.'/vendor/autoload.php';

use PhPresent\Adapter;
use PhPresent\Geometry;
use PhPresent\Graphic;
use PhPresent\Presentation;
use ForumPhp2019\Slides;

$bitmapLoader = new Adapter\Imagick\Graphic\BitmapLoader();
$presentation = new Presentation\SlideShow(
    Graphic\Theme::createDefault(),
    new Presentation\Template\Simple\FullscreenColor(Graphic\Color::white())
);

$presentation
    ->addSlide(new Slides\Mysterious())
    ->addSlide(new Slides\BigText("What do you\ndo with\nPHP?"))
    ->addSlide(new Slides\BigText("Websites?"))
    ->addSlide(new Slides\BigText("API?"))
    ->addSlide(new Slides\BigText("CLI?"))
;

$screen = Presentation\Screen::fromSizeWithExpectedRatio(Geometry\Size::fromDimensions(800, 450));
$engine = new Adapter\SDL\Render\Engine($screen);
$drawer = new Graphic\Drawer\Cache(new Adapter\Imagick\Graphic\Drawer());
$engine->start($presentation, $drawer);
