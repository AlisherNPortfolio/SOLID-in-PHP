# Liskov's Substitution Principle

Biz doim dastur modulini va bir qancha klaslar iyerarxiyasini yaratamiz. Shu bilan birga, ayrim klaslarni boshqa klaslardan meros olib, kengaytiramiz.

Mana shu holatda, biz yangi meros olingan klas ota klasning funksiyalarini o'zgartirmay, faqat shunchaki uning merosxo'ri bo'lishiga ishonch hosil qilishimiz kerak. Aks holda yangi klaslar mavjud modullarda ishlatilganida kutilmagan natijalarning kelib chiqishiga sabab bo'ladi.

> LSPga ko'ra, agar dastur moduli biror klasdan foydalanayotgan bo'lsa, bu klas o'rniga ishlatiladigan shu klasning bola klasi dastur modulining ishiga ta'sir qilmasligi kerak.

Bola klaslar doimo o'zlarining ota klaslari o'rnini hech qanday muammosiz mos egallay olishi kerak.

# Misol

1-misol (LSPni buzuvchi holat)

Quyida LSPni buzuvchi klassik misol keltirilgan. Misolda ikkita klas - `Rectangle` va `Square` klaslari berilgan. Faraz qilamiz, `Rectangle` obyekti dasturning qaysidir qismida ishlatilgan. Endi, bu klasdan meros olib `Square` klasini yaratamiz. `Square` ayrim holatlarga qarab, factory patterni orqali olinadi va bunda biz qanday turdagi obyekt qaytayotganini bilmaymiz. Lekin u `Rectangle` obyekti ekanligni bilamiz (chunki u `Rectangle`dan meros olgan). Shu holatda, `Rectangle` obyektini olamiz va bo'yiga 5, eniga 10 ni berib, yuzasini hisoblaymiz. To'g'ri to'rburchak (rectangle) uchun yuza 5*10=50 chiqishi kerak edi. Lekin, natija 100 chiqyapti:

```php
<?php
class Rectangle
{
    private int $width;
    private int $height;

    public function setWidth(int $width)
    {
	$this->width = $width;
    }

    public function setHeight(int $height)
    {
	$this->height = $height;
    }

    public function getWidth(): int
    {
	return $this->width;
    }

    public function getHeight(): int
    {
	return $this->height;
    }

    public function getArea(): int
    {
	return $this->width * $this->height;
    }
}

class Square extends Rectangle
{
    public function setWidth(protected int $width)
    {
	$this->width = $width;
	$this->height = $width;
    }

    public function setHeight(protected int $height)
    {
	$this->width = $height;
	$this->height = $height;
    }
}

class LSPTest
{
    public function __construct()
    {
	$rectangle = self::getNewRectangle();
	$rectangle->setWidth(5);
	$rectangle->setHeight(10);

	echo $rectangle->getArea(); // 100
    }

    private static function getNewRectangle()
    {
	return new Square();
    }
}
```

Bu misoldan ko'rinib turibdiki, meros olingan klas ota klasining funksiyalarini o'zgartirmasligi kerak.
