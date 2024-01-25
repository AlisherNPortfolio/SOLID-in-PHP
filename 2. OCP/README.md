# Open Close Principle

Mukammal dastur dizayni va kod yozish - bu kod yozish davomida tez-tez takrorlanib turadigan o'zgarishlarni hisobga olishi ketish degani. Odatda, dasturga yangi funksiya qo'shilganda ko'plab o'zgarishlar qilinadi. Bunda iloji boricha kodda kamroq o'zgarish qilish kerak, chunki mavjud kod allaqachon testdan o'tgan bo'ladi va qilinadigan o'zgarishlar oldin yozilgan kodlarga ta'sir qilishi mumkin.

OCPga ko'ra dasturga qo'shimcha funksionallik qo'shish paytida, imkoni boricha kodda kamroq o'zgarishlar qilish kerak. Qilinadigan o'zgarishlar iloji boricha kamroq bo'lishi uchun yangi funksionalliklar yangi klaslar ko'rinishida bo'lishi kerak.

> Dasturdagi kod obyektlari - klaslar, modullar va funksiyalar kengayishga ochiq, o'zgarishga yopiq bo'lishi kerak

Quyida OCP ishlatilmagan misol keltirilgan. Ushbu misolda grafik muharrir turli shakllarni chizish uchun ishlatiladi. Ko'rinib turibdiki, u OCP amal qilmayapti, chunki GraphicEditor klassi qo'shilishi kerak bo'lgan har bir yangi shakl klasi uchun o'zgartirilishi kerak bo'ladi. Quyida, ushbu koddagi bir nechta kamchiliklar keltirib o'tilgan:

* Har bir qo'shilgan yangi shakl uchun GraphicEditor-ning unit testi qayta bajarilishi kerak.
* Yangi shakl turi qo'shilganda, uni qo'shishga ko'p vaqt ketadi, chunki uni qo'shgan dasturchi GraphicEditor kodining ishlashini o'rganib chiqishi kerak.
* Yangi shaklni qo'shish, hattoki u to'g'ri ishlab turgan bo'lsa ham, mavjud kodning ishiga yomon ta'sir ko'rsatishi mumkin.

```php
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
```

Quyidagi misolda esa OCP-ga asoslanib yozilgan kod keltirilgan. Ushbu misolda biz GraphicEditor-da shakllarni chizish uchun abstrakt draw() metodini e'lon qilamiz, uni ishlatishni shakl klaslarining o'zida qoldiramiz. OCP dan foydalanish oldingi dizayndagi muammolardan qochadi, chunki yangi shakl sinfi qo'shilganda GraphicEditor klasini o'zgartirishga hojat qolmaydi:

```php
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
```
