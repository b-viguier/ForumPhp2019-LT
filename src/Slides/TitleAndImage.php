<?php

namespace ForumPhp2019\Slides;

use PhPresent\Geometry\Vector;
use PhPresent\Graphic;
use PhPresent\Geometry\Rect;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class TitleAndImage implements Slide
{
    public function __construct(string $title, Graphic\Bitmap $bitmap)
    {
        $this->title = $title;
        $this->bitmap = $bitmap;
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $center = $screen->safeArea()->center();

        $text = $drawer->createText(
            $this->title,
            $theme->fontH1()->relativeTo($screen->safeArea()->size()->height())
        );
        $txtRect = $text->area()
            ->hCenteredWith($center)
            ->topAlignedWith($screen->safeArea()->topLeft());

        $imgRect = Rect::fromSize($this->bitmap->size())
            ->scaledBy(min(
                $screen->safeArea()->size()->width() / $this->bitmap->size()->width(),
                $screen->safeArea()->size()->height() / $this->bitmap->size()->height(),
            ))
            ->centeredOn($center)
            ->movedBy(Vector::fromCoordinates(0, $txtRect->size()->height() / 2))
        ;

        $this->frame = new Frame(
            Sprite::fromBitmap($this->bitmap)
                ->moved($imgRect->topLeft())->resized($imgRect->size()),
            Sprite::fromBitmap($drawer->drawText($text)->toBitmap($text->area()->size()))
                ->moved($txtRect->topLeft())
        );
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        return $this->frame;
    }

    /** @var string */
    private $title;
    /** @var Frame */
    private $frame;
    /** @var Graphic\Bitmap */
    private $bitmap;
}
