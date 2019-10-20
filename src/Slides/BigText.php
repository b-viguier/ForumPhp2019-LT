<?php

namespace ForumPhp2019\Slides;

use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class BigText implements Slide
{
    public function __construct(string $text, Graphic\Color $color = null)
    {
        $this->text = $text;
        $this->color = $color ?? Graphic\Color::black();
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        // Initial guess
        $font = Graphic\Font::createDefaultSans()
            ->withStyle(Graphic\Font::STYLE_BOLD)
        ;
        $font = $font->withBrush(
            $font->brush()
                ->withFillColor($this->color)
                ->withStrokeWidth(4)
        );
        $text = $drawer->createText($this->text, $font);

        // Fix font size to fit the screen
        $font = $font->withSize(
            $font->size() * min(
                $screen->safeArea()->size()->height()*0.9 / $text->area()->size()->height(),
                $screen->safeArea()->size()->width()*0.9 / $text->area()->size()->width()
            )
        );
        $text = $drawer->createText($this->text, $font);
        $bitmap = $drawer->drawText($text)->toBitmap($text->area()->size());

        // Centering
        $rect = $text->area()->centeredOn($screen->safeArea()->center());
        $this->frame = new Frame(
            Sprite::fromBitmap($bitmap)->moved($rect->topLeft())
        );
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        return $this->frame;
    }

    /** @var Frame */
    private $frame;
    /** @var string */
    private $text;
    /** @var Graphic\Color */
    private $color;
}
