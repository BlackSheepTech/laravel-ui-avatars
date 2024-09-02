<?php

namespace BlackSheepTech\UiAvatars;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UiAvatarsService
{
    private string $baseUrl;

    private ?string $name;

    private string $background;

    private string $color;

    private int $size;

    private float $fontSize;

    private int $length;

    private bool $rounded;

    private bool $bold;

    private bool $uppercase;

    private string $format;

    public function __construct()
    {
        $this->baseUrl = config('ui-avatars.base_url', 'https://ui-avatars.com/api/');

        $this->loadDefaults();

        throw_unless(filter_var($this->baseUrl, FILTER_VALIDATE_URL), new \InvalidArgumentException('Invalid base URL provided.'));
    }

    private function loadDefaults(): void
    {
        $defaults = config('ui-avatars.defaults');

        $this->name = $defaults['name'];
        $this->background = $defaults['background'];
        $this->color = $defaults['color'];
        $this->size = $defaults['size'];
        $this->fontSize = $defaults['font-size'];
        $this->length = $defaults['length'];
        $this->rounded = $defaults['rounded'];
        $this->bold = $defaults['bold'];
        $this->uppercase = $defaults['uppercase'];
        $this->format = $defaults['format'];
    }

    public static function make(): self
    {
        return new static;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function background(string $background = 'random'): self
    {
        $this->background = $this->sanitizeColorInput($background, 'background color', true);

        return $this;
    }

    public function color(string $color = '8b5d5d'): self
    {
        $this->color = $this->sanitizeColorInput($color, 'font color');

        return $this;
    }

    public function size(int $size = 64): self
    {
        $this->size = $this->validateRange($size, 16, 512, 'size');

        return $this;
    }

    public function fontSize(float $fontSize = 0.5): self
    {
        $this->fontSize = $this->validateRange($fontSize, 0.1, 1.0, 'font size');

        return $this;
    }

    public function length(int $length = 2): self
    {
        $this->length = $length;

        return $this;
    }

    public function rounded(bool $rounded = true): self
    {
        $this->rounded = $rounded;

        return $this;
    }

    public function bold(bool $bold = true): self
    {
        $this->bold = $bold;

        return $this;
    }

    public function uppercase(bool $uppercase = true): self
    {
        $this->uppercase = $uppercase;

        return $this;
    }

    public function format(string $format = 'png'): self
    {
        throw_unless(in_array($format, ['png', 'svg']), new \InvalidArgumentException('Invalid format provided. Only png and svg are allowed.'));

        $this->format = $format;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->baseUrl.'?'.http_build_query($this->buildQueryParams());
    }

    public function download(?string $fileName = null): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo file_get_contents($this->getUrl());
        }, $fileName ? "$fileName.$this->format" : Str::random(40).'.'.$this->format);
    }

    public function saveTo(string $path, ?string $fileName = null, ?string $disk = null): string|false
    {
        try {
            Storage::disk($disk ?? config('filesystem.default'))->put(
                $filename = $path.'/'.($fileName ? "$fileName.$this->format" : Str::random(40).'.'.$this->format),
                file_get_contents($this->getUrl())
            );
        } catch (\Throwable $throwable) {
            throw $throwable;
        }

        return $filename;
    }

    private function buildQueryParams(): array
    {
        if (is_null($this->name)) {
            throw new \InvalidArgumentException('Name must be provided.');
        }

        $apiDefaults = config('ui-avatars.api-defaults');

        return array_merge(
            ['name' => $this->name],
            $this->background !== $apiDefaults['background'] ? ['background' => $this->background] : [],
            $this->color !== $apiDefaults['color'] ? ['color' => $this->color] : [],
            $this->size !== $apiDefaults['size'] ? ['size' => $this->size] : [],
            $this->fontSize !== $apiDefaults['font-size'] ? ['font-size' => $this->fontSize] : [],
            $this->length !== $apiDefaults['length'] ? ['length' => $this->length] : [],
            $this->rounded !== $apiDefaults['rounded'] ? ['rounded' => $this->rounded ? 'true' : 'false'] : [],
            $this->bold !== $apiDefaults['bold'] ? ['bold' => $this->bold ? 'true' : 'false'] : [],
            $this->uppercase !== $apiDefaults['uppercase'] ? ['uppercase' => $this->uppercase ? 'true' : 'false'] : [],
            $this->format !== $apiDefaults['format'] ? ['format' => $this->format] : []
        );
    }

    private function sanitizeColorInput(string $color, string $parameter, bool $canBeRandom = false, bool $canBeTransparent = false): string
    {
        $color = Str::of($color)->remove('#');
        $this->validateHexColor($color, $parameter, $canBeRandom, $canBeTransparent);

        return $color;
    }

    private function validateHexColor(string $color, string $parameter = 'color', bool $canBeRandom = false, bool $canBeTransparent = false): void
    {
        $pattern = '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3}'.($canBeRandom ? '|random' : null).($canBeTransparent ? '|transparent' : null).')$/i';

        throw_unless(Str::of($color)->test($pattern), new \InvalidArgumentException("Invalid $parameter provided. Only hex colors".($canBeRandom ? ', " or random"' : '').($canBeTransparent ? ', and "transparent"' : '').' are allowed.'));
    }

    private function validateRange(int|float $value, int|float|null $min, int|float|null $max, string $type): int|float
    {
        throw_if(is_null($min) && is_null($max), new \InvalidArgumentException('Invalid range provided. Minimum and maximum values cannot both be null.'));

        if (is_null($min)) {
            throw_unless($value <= $max, new \InvalidArgumentException("Invalid {$type} provided. Must be less than or equal {$max}."));
        } elseif (is_null($max)) {
            throw_unless($value >= $min, new \InvalidArgumentException("Invalid {$type} provided. Must be greater than or equal {$min}."));
        }

        throw_if($min > $max, new \InvalidArgumentException('Invalid range provided. Minimum value must be less than maximum value.'));

        throw_unless($value >= $min && $value <= $max, new \InvalidArgumentException("Invalid {$type} provided. Must be between {$min} and {$max}."));

        return $value;
    }
}
