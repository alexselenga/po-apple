<?php

namespace common\entities;

interface AppleInterface
{
    public function __construct($color = null);
    public static function getApple($id): AppleInterface;
    public static function generateApples($count = 10);
    public static function removeApples();
    public function fallToGround();
    public function eat($percent);
    public function delete();
    public function getColor(): string;
    public function getSize(): float;
    public function getStatus(): int;
}