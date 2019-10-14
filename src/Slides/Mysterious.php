<?php

namespace ForumPhp2019\Slides;

use PhPresent\Geometry;
use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class Mysterious implements Slide
{
    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $font = Graphic\Font::createDefaultSans()
            ->withStyle(Graphic\Font::STYLE_BOLD)
            ->withSize($screen->safeArea()->size()->height());
        $text = $drawer->createText('?', $font);
        $bitmap = $drawer->drawText($text)->toBitmap($text->area()->size());
        $this->sprite = Sprite::fromBitmap($bitmap);
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        $center = $screen->safeArea()->center();
        while (true) {
            $rect = Geometry\Rect::fromTopLeftAndSize(
                $this->sprite->origin(),
                $this->sprite->bitmap()->size()->scaledBy(
                    1 - (0.2 * 0.5 * sin($timestamp->slideRelative() / 500) + 0.1)
                )
            )->centeredOn($center);

            $timestamp = yield new Frame(
                $this->sprite->moved($rect->topLeft())->resized($rect->size())
            );
        }
    }

    /** @var Sprite */
    private $sprite;
}
