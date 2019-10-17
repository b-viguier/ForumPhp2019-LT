<?php

namespace ForumPhp2019\Slides;

use PhPresent\Geometry\Rect;
use PhPresent\Geometry\Vector;
use PhPresent\Graphic;
use PhPresent\Presentation\Frame;
use PhPresent\Presentation\Screen;
use PhPresent\Presentation\Slide;
use PhPresent\Presentation\Sprite;
use PhPresent\Presentation\Timestamp;

class PhPresent implements Slide
{
    public function __construct(string $title, string $url, Graphic\Bitmap $logo)
    {
        $this->title = $title;
        $this->url = $url;
        $this->logoSprite = Sprite::fromBitmap($logo);
    }

    public function preload(Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme): void
    {
        $this->direction = Vector::fromCoordinates(1, 1);

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

        $this->titleSprite = Sprite::fromBitmap($bitmap)->moved($spritePosition);

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

        $urlRect = $text->area()->hCenteredWith($screenCenter)->topAlignedWith($titleRect->bottomRight());
        $this->urlSprite = Sprite::fromBitmap($bitmap)->moved($urlRect->topLeft());

        $logoPosition = Rect::fromSize($this->logoSprite->size())
            ->hCenteredWith($screenCenter)
            ->topAlignedWith($urlRect->bottomRight())->topLeft();
        $this->logoSprite = $this->logoSprite->moved($logoPosition);
    }

    public function render(Timestamp $timestamp, Screen $screen, Graphic\Drawer $drawer, Graphic\Theme $theme)
    {
        $lastTimestamp = $timestamp;
        while(true) {
            $logoRect = Rect::fromTopLeftAndSize($this->logoSprite->origin(), $this->logoSprite->size());
            $newLogoRect = $logoRect->movedBy($this->direction->scaledBy(($timestamp->slideRelative()-$lastTimestamp->slideRelative()) / 5));

            // Bouncing
            if($newLogoRect->topLeft()->x() < $screen->fullArea()->topLeft()->x()) {
                $this->direction = Vector::fromCoordinates(-$this->direction->dx(), $this->direction->dy());
                $newLogoRect->movedBy(Vector::fromCoordinates(
                    2 * ($screen->fullArea()->topLeft()->x() - $newLogoRect->topLeft()->x()), 0
                ));
            }
            if($newLogoRect->topLeft()->y() < $screen->fullArea()->topLeft()->y()) {
                $this->direction = Vector::fromCoordinates($this->direction->dx(), -$this->direction->dy());
                $newLogoRect->movedBy(Vector::fromCoordinates(
                    0, 2 * ($screen->fullArea()->topLeft()->y() - $newLogoRect->topLeft()->y())
                ));
            }
            if($newLogoRect->bottomRight()->x() > $screen->fullArea()->bottomRight()->x()) {
                $this->direction = Vector::fromCoordinates(-$this->direction->dx(), $this->direction->dy());
                $newLogoRect->movedBy(Vector::fromCoordinates(
                    2 * ($screen->fullArea()->bottomRight()->x() - $newLogoRect->bottomRight()->x()), 0
                ));
            }
            if($newLogoRect->bottomRight()->y() > $screen->fullArea()->bottomRight()->y()) {
                $this->direction = Vector::fromCoordinates($this->direction->dx(), -$this->direction->dy());
                $newLogoRect->movedBy(Vector::fromCoordinates(
                    0, 2 * ($screen->fullArea()->bottomRight()->y() - $newLogoRect->bottomRight()->y())
                ));
            }
            $this->logoSprite = $this->logoSprite->moved($newLogoRect->topLeft());

            $lastTimestamp = $timestamp;
            $timestamp = yield new Frame(
                $this->logoSprite,
                $this->titleSprite,
                $this->urlSprite
            );
        }
    }

    /** @var string */
    private $title;
    /** @var string */
    private $url;

    /** @var Sprite */
    private $titleSprite;
    /** @var Sprite */
    private $urlSprite;
    /** @var Sprite  */
    private $logoSprite;

    /** @var Vector */
    private $direction;
}
