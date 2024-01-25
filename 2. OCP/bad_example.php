<?php

class GraphicEditor {
    public function drawShape(Shape $shape): void 
    {
        if ($shape->type == 1) {
            $this->drawRectangle();
        } elseif ($shape->type == 2) {
            $this->drawCircle();
        }
    }

    public function drawCircle(): void 
    {
        echo "Draw a circle";
    }

    public function drawRectangle(): void
    {
        echo "Draw a rectangle";
    }
}

class Shape {
    public int $type;
}

class Rectangle extends Shape {
    public function __construct()
    {
        $this->type = 1;
    }
}

class Circle extends Shape {
    public function __construct()
    {
        $this->type = 2;
    }
}