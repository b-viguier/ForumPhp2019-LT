<?php

namespace ForumPhp2019\Slides;

use PhPresent\Geometry\Rect;
use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class BigImage implements Slide
{
    public function __construct(Graphic\Bitmap $bitmap)
    {
        $this->bitmap = $bitmap;
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        // Centering
        $rect = Rect::fromSize($this->bitmap->size())
            ->scaledBy(min(
                $screen->safeArea()->size()->width() / $this->bitmap->size()->width(),
                $screen->safeArea()->size()->height() / $this->bitmap->size()->height(),
            ))
            ->centeredOn($screen->safeArea()->center())
        ;
        $this->frame = new Frame(
            Sprite::fromBitmap($this->bitmap)->moved($rect->topLeft())->resized($rect->size())
        );
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        return $this->frame;
    }

    /** @var Frame */
    private $frame;
    /** @var Graphic\Bitmap */
    private $bitmap;
}
