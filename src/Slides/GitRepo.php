<?php

namespace ForumPhp2019\Slides;

use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class GitRepo implements Slide
{
    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $screenCenter = $screen->safeArea()->center();
        $screenHeight = $screen->safeArea()->size()->height();

        // Title
        $font = $theme->fontH1()
            ->relativeTo($screenHeight)
            ->withAlignment(Graphic\Font::ALIGN_CENTER);

        $text = $drawer->createText($this->title, $font);
        $bitmap = $drawer->drawText($text)
            ->toBitmap($text->area()->size());

        $spritePosition = ($titleRect = $text->area()->hCenteredWith($screenCenter)->bottomAlignedWith($screenCenter))->topLeft();

        $titleSprite = Sprite::fromBitmap($bitmap)->moved($spritePosition);

        // Subtitle
        $drawer->clear();
        $font = Graphic\Font::createDefaultMono()
            ->withSize($font->size() / 3)
            ->withBrush($font->brush()
                ->withFillColor($urlColor = Graphic\Color::blue())
                ->withStrokeColor($urlColor)
            )
            ->withAlignment(Graphic\Font::ALIGN_CENTER);

        $text = $drawer->createText($this->url, $font);
        $bitmap = $drawer->drawText($text)
            ->toBitmap($text->area()->size());

        $spritePosition = $text->area()->hCenteredWith($screenCenter)->topAlignedWith($titleRect->bottomRight())->topLeft();

        $urlSprite = Sprite::fromBitmap($bitmap)->moved($spritePosition);

        $this->frame = new Frame($titleSprite, $urlSprite);
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        return $this->frame;
    }

    /** @var string */
    private $title;
    /** @var string */
    private $url;
    /** @var Frame */
    private $frame;
}
