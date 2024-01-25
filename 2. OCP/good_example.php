<?php

class GraphicEditor {
    public function drawShape(Shape $shape): void
    {
        $shape->draw();
    }
}

abstract class Shape 
{
    public abstract function draw(): void;
}

class Rectangle extends Shape
{
    public function draw(): void
    {
        echo "Draw a rectanle";
    }
}

class Circle extends Shape
{
    public function draw(): void
    {
        echo "Draw a circle";
    }
}