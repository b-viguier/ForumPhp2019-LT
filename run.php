#!/usr/bin/env php -d memory_limit=2048M
<?php
require __DIR__.'/vendor/autoload.php';

use PhPresent\Adapter;
use PhPresent\Geometry;
use PhPresent\Graphic;
use PhPresent\Presentation;
use ForumPhp2019\Slides;

$defaultTheme = Graphic\Theme::createDefault();
$myTheme = $defaultTheme
    ->withFontH1(Graphic\RelativeFont::fromFont(
            Graphic\Font::createDefaultSans()->withSize(20),
            100
    ))
    ;

$bitmapLoader = new Adapter\Imagick\Graphic\BitmapLoader();
$bitmapSeqLoader = new Adapter\Imagick\Graphic\BitmapSequenceLoader();
$presentation = new Presentation\SlideShow(
    $myTheme,
    new Presentation\Template\Simple\FullscreenColor(Graphic\Color::white())
);

$drawer = new Adapter\Imagick\Graphic\Drawer();

$presentation
    ->addSlide($mysteriousSlide = new Slides\Mysterious())
    ->addSlide($whatDoYouDoSlide = new Slides\BigText("What do you\ndo with\nPHP?"))
    ->addSlide(new Slides\BigText("Website?"))
    ->addSlide(new Slides\BigText("API?"))
    ->addSlide(new Slides\BigText("CLI?"))
    ->addSlide(new Slides\Gif(
            $bitmapSeqLoader->fromFile(__DIR__.'/assets/boring.gif'))
    )
    ->addSlide(new Slides\BigText("What about\n…"))
    ->addSlide(new Slides\BigText("Music?", Graphic\Color::blue()))
    ->addSlide(new Slides\BigText("GUI?", Graphic\Color::red()))
    ->addSlide(new Slides\BigText("Video\nGames?", Graphic\Color::green()))
    ->addSlide(new Slides\Gif(
            $bitmapSeqLoader->fromFile(__DIR__.'/assets/confused.gif'))
    )
    ->addSlide(new Slides\BigImage(
    // Bug workaround: PNG has to be converted in BMP
        $drawer->clear()->drawBitmap(
            $bitmap = $bitmapLoader->fromFile(__DIR__.'/assets/elephpant.png'),
            Geometry\Rect::fromSize($bitmap->size()),
            Geometry\Rect::fromSize($bitmap->size())
        )->toBitmap($bitmap->size())
    ))
    ->addSlide(new Slides\BigImage(
    // Bug workaround: PNG has to be converted in BMP
        $drawer->clear()->drawBitmap(
            $bitmap = $bitmapLoader->fromFile(__DIR__.'/assets/SDL.png'),
            Geometry\Rect::fromSize($bitmap->size()),
            Geometry\Rect::fromSize($bitmap->size())
        )->toBitmap($bitmap->size())
    ))
    ->addSlide(new Slides\Quote(
            $bitmapLoader->fromFile(__DIR__.'/assets/rasmus.png'),
            "There's an\nextension\nfor that!")
    )
    ->addSlide(new Slides\GitRepo(
        "PHP-SDL",
        "https://github.com/Ponup/php-sdl"
    ))
    ->addSlide(new Slides\GitRepo(
            "PhpOkoban",
        "https://github.com/b-viguier/PhpOkoban"
    ))
    ->addSlide(new Slides\Gif(
            $bitmapSeqLoader->fromFile(__DIR__.'/assets/phpokoban.gif'))
    )
    ->addSlide(new Slides\GitRepo(
        "Inphpinity",
        "https://github.com/b-viguier/Inphpinity"
    ))
    ->addSlide(new Slides\Gif(
            $bitmapSeqLoader->fromFile(__DIR__.'/assets/inphpinity.gif'))
    )
    ->addSlide(new Slides\GitRepo(
        "PhPresent",
        "https://github.com/b-viguier/PhPresent"
    ))
    ->addSlide(new Slides\BigText("Why?!?"))
    ->addSlide(new Slides\Quote(
            $bitmapLoader->fromFile(__DIR__.'/assets/twain.jpg'),
            "They did not\nknow it was\nimpossible,\nso they did it\n…\nin PHP")
    )
    ->addSlide($mysteriousSlide = new Slides\Mysterious())
    ->addSlide($whatDoYouDoSlide = new Slides\BigText("What do you\ndo with\nPHP?"))
;

$screen = Presentation\Screen::fromSizeWithExpectedRatio(Geometry\Size::fromDimensions(800, 450));
$engine = new Adapter\SDL\Render\Engine($screen);
$engine->start($presentation, $drawer);
