<?php

namespace ForumPhp2019\Slides;

use PhPresent\Presentation;
use PhPresent\Graphic;
use PhPresent\Geometry;

class Gif implements Presentation\Slide
{
    public function __construct(Graphic\BitmapSequence $bitmapSequence)
    {
        $this->bitmapSequence = $bitmapSequence;
    }

    public function preload(Presentation\Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $bitmap = $drawer->drawRectangle(
            Geometry\Rect::fromSize($onePixelSize = Geometry\Size::fromDimensions(1, 1)),
            Graphic\Brush::createFilled(Graphic\Color::black())
        )->toBitmap($onePixelSize);

        $this->backgroundSprite = Presentation\Sprite::fromBitmap($bitmap)
            ->moved($screen->fullArea()->topLeft())
            ->resized($screen->fullArea()->size())
        ;
    }

    public function render(Presentation\Timestamp $timestamp, Presentation\Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        $sizeRatio = min(
            $screen->fullArea()->size()->width() / $this->bitmapSequence->size()->width(),
            $screen->fullArea()->size()->height() / $this->bitmapSequence->size()->height()
        );
        $target = Geometry\Rect::fromSize($this->bitmapSequence->size()->scaledBy($sizeRatio))
            ->centeredOn($screen->fullArea()->center());
        while (true) {
            $timestamp = yield new Presentation\Frame(
                $this->backgroundSprite,
                Presentation\Sprite::fromBitmap(
                    $this->bitmapSequence->content($timestamp->slideRelative())
                )->moved($target->topLeft())
                ->resized($target->size())
            );
        }
    }

    /** @var Graphic\BitmapSequence */
    private $bitmapSequence;
    /** @var Presentation\Sprite */
    private $backgroundSprite;
}
