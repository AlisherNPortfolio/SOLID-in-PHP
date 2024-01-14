# Dependency Inversion Principle

DIP dastur yaratishning (software design) asos tamoyillaridan biri hisoblanadi. DIPga ko'ra, yuqori darajadagi (murakkab vazifalarni bajarishga mo'ljallangan) modullar past darajadagi (eng sodda amallarni baruvchi) modullarga bog'liq bo'lmasligi kerak. Ammo, ikkalasi ham abstraksiyadan foydalanishi kerak.

DIPning asosida abstraksiya detallarga (klaslarning vazifalariga) bog'liq bo'lmasligi, balki detallar abstraksiyaga bog'liq bo'lishi kerakligi yotadi. DIP abstrakt qatlam yaratish orqali bog'lanishlarni minimallashtirib, kodni yozishni osonlashtiradi. DIPning asosiy jihati bo'lgan Dependency Injection komponentga tashqi resurslarni (obyektlar va boshqa ma'lumotlar) uzatadi va bu uzatish konstruktor, metod yoki property injection orqali amalga oshiriladi.

Dastur yaratish jarayonida fundamental amallarni bajaradigan (m: disk yoki tarmoq protokollari bilan ishlaydigan) quyi darajadagi klaslar va murakkab vazifalarni bajaruvchi (m: biznes jarayonini) murakkab klaslar hisobga olib ketiladi.

Bu ikki turdagi klaslarni ishlatishda quyi darajadagi klaslardan foydalanib, yuqori darajadagi klaslarni yaratish tabiiy ko'rinishi mumkin. Ammo bu holatda biz yaratgan dasturga funksionalliklar qo'shish, support qilish ancha qiyin bo'lib qoladi. Mana shu holatda, agar quyi darajadagi klaslarni  almashtirmoqchi bo'lsak, nima bo'ladi?

Keling, tushunarliroq bo'lishi uchun, klaviaturadan belgilarni o'qib, ularni printer qurilmasiga yozadigan nusxa ko'chirish modulining klassik misolini ko'rib chiqaylik. Asosiy vazifani bajaruvchi kodlarni o'z ichiga olgan yuqori darajadagi klas Copy klasidir. Quyi darajadagi klaslar KeyboardReader va PrinterWriter klaslari hisoblanadi.

Noto'g'ri ko'rinishdagi kod yozishda yuqori darajadagi klas to'g'ridan-to'g'ri quyi darajadagi klaslardan foydalanib, ularga ko'p jihatdan bog'liq bo'ladi. Mana shu holatda, agar PrinterWriter klasni yangi FileWriter klasiga o'zgartirmoqchi bo'lsak, Copy klasiga o'zgaritish kiritishimizga to'g'ri keladi. (Faraz qilaylik, bu juda murakkab klas bo'lib, testlash uchun juda qiyin).

Mana shunday muammolarga duch kelmaslik uchun yuqori va quyi darakali klaslar orasiga abstrakt qatlam qo'shishimiz kerak bo'ladi. Yuqori darajali modullar juda murakkab bo'lishini hisobga olib, ularni quyi darajali modullarga bog'liq bo'lmasligini ta'minlash uchun yangi abstrakt qatlamni quyi darajali modul asosida yaratmaslik kerak. Balki, quyi darajali modullar abstrakt qatlam asosida yaratiladi.

> Bu tamoyilga ko'ra, klaslar strukturasini yaratish yuqori darajali modullardan quyi darajali modullarga tomon amalga oshirilishi kerak:
>
> Yuqori darajali klaslar ===> Abstrakt qatlam ===> Quyi darajali klaslar

* Yuqori darajali modullar quyi darajali modullarga bog'liq bo'lmasligi kerak, lekin ikkalasi ham abstrakt qatlamga bog'liq bo'lishi kerak.
* Abstraksiya detallarga (klaslarning vazifalariga) bog'liq bo'lmay, balki detallar abstraksiyaga bog'liq bo'lishi kerak.

# Misol

Quyida DIPga mos kelmaydigan misol keltirilgan. Bizda yuqori darajali Manager klas va quyi darali Worker klasi mavjud. Kompaniyaga yangi ishchilarni qo'shish bilan bog'liq bo'lgan o'zgarishlarni modellashtirish uchun dasturimizga yangi modul qo'shamiz. Buning uchun SuperWorker nomli yangi klasni yaratamiz.

Faraz qilamiz, Manager klasi juda murakkab klas. Endi esa, shu klasga yangi SuperWorker klasini ishlatmoqchimiz. Bunda paydo bo'ladigan muammolarni ko'rib chiqaylik:

* Manager klasini o'zgartirishimiz kerak (klas juda murakkabligini hisobga olsak, bu juda qiyin ish bo'ladi)
* Bu Manager klasidagi ayrim funksionalliklarga yomon ta'sir qilishi mumkin
* Unit testlash qayta qilinishi kerak bo'ladi.

Yuqoridagi muammolarni bartaraf etishga ko'p vaqt sarflashga to'g'ri keladi, hattoki boshqa muammolar ham kelib chiqishi mumkin. Agar dastur DIP asosida yozilsa, bu muammolar paydo bo'lishini oldini olish mumkin.

DIP asosida yuqorida keltirilgan misolga yana bir IWorker interfeysini qo'shamiz va uni Manager hamda Worker klaslarida ishlatamiz. Yangi SuperWorker klasini qo'shganimizda, bu klas uchun ham shu interfeysni ishlatamiz. Bunda mavjud klaslarda hech qanday o'zgarish qilishga hojat bo'lmaydi.

1-misol (DIP ishlatilmagan holat):

```php
<?php

class Worker {
    public function work(): void
    {
        # working
    }
}

class Manager {
    private $worker;

    public function setWorker(Worker $worker): void
    {
        $this->worker = $worker;
    }

    public function manage(): void
    {
        $this->worker->work();
    }
}

class SuperWorker {
    public function work(): void
    {
        # working much more
    }
}
```

Kodda ko'rinib turganidek, yangi klasni Manager klasga inject qilishda muammolar paydo bo'ladi (chunki `setWorker` metodi faqat `Worker` tipidagi obyektni qabul qiladi).

2-misol (DIP qo'llangan holat)

Endi shu kodni, DIP asosida qayta yozib ko'ramiz. Buning uchun yuqoridagi klaslarga `IWorker` interfeysini qo'shib, muammoni hal qilamiz.

* Yangi `SuperWorker` klasi qo'shilganida `Manager` klasiga o'zgaritirish kiritish shart bo'lmaydi.
* `Manager` klasini o'zgartirmaganimiz sababli yangi paydo bo'lishi mumkin bo'lgan xatolarni oldini olgan bo'lamiz.
* `Manager` klasi uchun qaytadan unit testlash qilish shart bo'lmaydi.

```php
<?php

interface IWorker {
    public function work(): void;
}

class Worker implements IWorker
{
    public function work(): void
    {
	# working
    }
}

class SuperWorker implements IWorker
{
    public function work(): void
    {
	# working much more
    }
}

class Manager 
{
    private $worker;

    public function setWorker(IWorker $worker): void
    {
	$this->worker = $worker;
    }

    public function manage(): void
    {
	$this->worker->work();
    }
}
```
