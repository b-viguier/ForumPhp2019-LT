<?php

namespace ForumPhp2019\Slides;

use PhPresent\Geometry;
use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Template\Simple\FullscreenImage;
use PhPresent\Presentation\Timestamp;

class Quote implements Slide
{
    public function __construct(Graphic\Bitmap $background, string $text)
    {
        $this->background = $background;
        $this->text = $text;
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $bgSlide = new FullscreenImage($this->background);
        $bgSlide->preload($screen, $drawer, $theme);
        $this->frame = $bgSlide->render(Timestamp::origin(0), $screen, $drawer, $theme);

        $drawer->clear();
        $font = $theme->fontH1()->relativeTo($screen->safeArea()->size()->height()*0.6)->withStyle(Graphic\Font::STYLE_ITALIC);
        $font = $font->withBrush($font->brush()->withFillColor(Graphic\Color::white())->withStrokeColor(Graphic\Color::white()));
        $text = $drawer->createText(
            $this->text,
            $font
        );
        $rect = $text->area()->vCenteredWith($screen->fullArea()->center());

        $this->frame = $this->frame->withPushedSprites(
            Sprite::fromBitmap(
                $drawer->drawText($text)->toBitmap($text->area()->size())
            )->moved(
                Geometry\Point::fromCoordinates(
                    $screen->fullArea()->size()->width()*0.95 - $rect->size()->width(),
                    $rect->topLeft()->y()
                )
            )
        );
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        return $this->frame;
    }

    /** @var Frame */
    private $frame;
    /** @var Graphic\Bitmap */
    private $background;
    /** @var string */
    private $text;
}
