<?php

use PhPresent\Adapter;
use PhPresent\Graphic;
use ForumPhp2019\Slides;

$bitmapLoader = new Adapter\Imagick\Graphic\BitmapLoader();
$bitmapSeqLoader = new Adapter\Imagick\Graphic\BitmapSequenceLoader();

$presentation
    ->addSlide($mysteriousSlide = new Slides\Mysterious())
    ->addSlide($whatDoYouDoSlide = new Slides\BigText("What do you\ndo with\nPHP?"))
    ->addSlide(new Slides\BigText("Website?"))
    ->addSlide(new Slides\BigText("API?"))
    ->addSlide(new Slides\BigText("CLI?"))
    ->addSlide(new Slides\Gif(
        $bitmapSeqLoader->fromFile(__DIR__.'/assets/boring.gif')
    ))
    ->addSlide(new Slides\BigText("What about\n…"))
    ->addSlide(new Slides\BigText("Software?", Graphic\Color::RGB(234, 12, 128)))
    ->addSlide(new Slides\BigText("Music?", Graphic\Color::blue()))
    ->addSlide(new Slides\BigText("GUI?", Graphic\Color::red()))
    ->addSlide(new Slides\BigText("Data\nVisualization?", Graphic\Color::RGB(128, 12, 234)))
    ->addSlide(new Slides\BigText("Video\nGames?", Graphic\Color::green()))
    ->addSlide(new Slides\Gif(
        $bitmapSeqLoader->fromFile(__DIR__.'/assets/confused.gif')
    ))
    ->addSlide(new Slides\BigImage($bitmapLoader->fromFile(__DIR__.'/assets/php.png')))
    ->addSlide(new Slides\Quote(
        $bitmapLoader->fromFile(__DIR__.'/assets/rasmus.png'),
        "There's an\nextension\nfor that!"
    ))
    ->addSlide(new Slides\BigImage($bitmapLoader->fromFile(__DIR__.'/assets/SDL.png')))
    ->addSlide(new Slides\GitRepo(
        "PHP-SDL",
        "https://github.com/Ponup/php-sdl"
    ))
    ->addSlide(new Slides\TitleAndImage(
        "Initialization",
        $bitmapLoader->fromFile(__DIR__.'/assets/SDL_Init.png')
    ))
    ->addSlide(new Slides\TitleAndImage(
        "Events Loop",
        $bitmapLoader->fromFile(__DIR__.'/assets/SDL_poll.png')
    ))
    ->addSlide(new Slides\BigImage($bitmapLoader->fromFile(__DIR__.'/assets/SDL_HelloWorld-1.png')))
    ->addSlide(new Slides\TitleAndImage(
        "Textures",
        $bitmapLoader->fromFile(__DIR__.'/assets/SDL_texture.png')
    ))
    ->addSlide(new Slides\TitleAndImage(
        "Rendering",
        $bitmapLoader->fromFile(__DIR__.'/assets/SDL_render.png')
    ))
    ->addSlide(new Slides\BigImage($bitmapLoader->fromFile(__DIR__.'/assets/SDL_HelloWorld-2.png')))
    ->addSlide(new Slides\TitleAndImage(
        "Inputs",
        $bitmapLoader->fromFile(__DIR__.'/assets/SDL_events.png')
    ))
    ->addSlide(new Slides\GitRepo(
        "PhpOkoban",
        "https://github.com/b-viguier/PhpOkoban"
    ))
    ->addSlide(new Slides\Gif(
            $bitmapSeqLoader->fromFile(__DIR__.'/assets/phpokoban.gif'))
    )
    ->addSlide(new Slides\GitRepo(
        "InPhpinity",
        "https://github.com/b-viguier/Inphpinity"
    ))
    ->addSlide(new Slides\Gif(
        $bitmapSeqLoader->fromFile(__DIR__.'/assets/inphpinity.gif'))
    )
    ->addSlide(new Slides\PhPresent(
        "PhPresent",
        "https://github.com/b-viguier/PhPresent",
        $bitmapLoader->fromFile(__DIR__.'/assets/php.png')
    ))
    ->addSlide(new Slides\GitRepo(
        "ForumPhp2019-LT",
        "https://github.com/b-viguier/ForumPhp2019-LT"
    ))
    ->addSlide(new Slides\BigText("Why\n?!?"))
    ->addSlide(new Slides\Quote(
        $bitmapLoader->fromFile(__DIR__.'/assets/twain.jpg'),
        "They did not\nknow it was\nimpossible,\nso they did it\n…\nin PHP")
    )
    ->addSlide($mysteriousSlide = new Slides\Mysterious())
    ->addSlide($whatDoYouDoSlide = new Slides\BigText("What do you\ndo with\nPHP?"))
    ->addSlide(new Slides\Fun(
        "Have Fun!",
        $bitmapLoader->fromFile(__DIR__.'/assets/elephpant.png')
    ));
