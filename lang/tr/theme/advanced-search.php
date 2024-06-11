<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Classes Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'GELİŞKİN ARAMA',
    'subtitle-1' => 'TAM EŞLEŞME ÖZELLİĞİ',
    'subtitle-1-description' => '<p>Marka Legal Takip, anahtar kelimelerinizin benzerlerini de sonuçlarda çıkarır. Benzer markaları kaçırmamak çoğu durumda istenen bir özelliktir fakat bazı durumlarda sistemin sadece tam eşleşmeleri önünüze getirmesini ve aranan o markada benzerlik özelliklerini çalıştırmamasını isteyebilirsiniz. Bunun için tam eşleşme özelliğini kullanabilirsiniz.<br><br>Sistem, tam eşleşme özelliğini tırnak işaretleri (“ “) ile anlar. İki tırnak işareti arasına bir ifade yerleştirildiğinde bu tam eşleşme istenildiği şeklinde yorumlanır ve sadece yerleştirilen ifadenin tam olarak eşleştiği markalar sonuçlara dahil edilir. Tam eşleşme özelliğini kullanmak için markanızda iki adet çift tırnak işareti kullanabilir veya marka girişi sırasında “tam eşleşme” kutucuğuna tıklayabilirsiniz.</p>',
    'subtitle-2' => 'Tam eşleşme özelliği ile birebir arama',
    'subtitle-2-description' => '<p>Bazı marka sahipleri benzer markalara itiraz etmekle ilgilenmezler ve sadece birebir eşleşen marka varsa bunu görmek isterler. Bu durumda tam eşleşme özelliğini markanın tamamı için kullanmak uygun bir seçenektir.</p>',
    'subtitle-2-description-2' => '<p>Marka ekleme alanında markamızı yazıp tam eşleşme kutucuğunu işaretlediğimizde bu ayarı gerçekleştirebiliriz.</p>',
    'subtitle-3' => 'Tam eşleşme özelliği ile kelime zorunlu tutma',
    'subtitle-3-description' => '<p>Bazı markalar birkaç kelimeden oluşur. Üç ve daha fazla sayıda kelime içeren markalar için sistem sonuçlarda tüm kelimelerin içermesini zorunlu tutmaz. Bu durumda bazı zamanlar eşleşmede olmasını kesin olarak istediğiniz kelimeler olabilir. Örneğin üç kelimeli bir marka olarak <strong>elektrik ticaret sanayi</strong> markasını düşünelim. Eğer sonuçlarda sadece <strong>ticaret sanayi</strong> olanlarla ilgilenmiyorsak, <strong>elektrik</strong> kelimesinin sonuçlarda olmasını zorunlu tutabiliriz.</p>',
    'subtitle-3-description-2' => '<p>Aramayı <strong>"elektrik" ticaret sanayi</strong> olarak düzenleyelim.</p>',
    'subtitle-4' => 'Tam eşleşme özelliği ile kelime eşleşmesi filtreleme',
    'subtitle-4-description' => '<p>Bazı kelimeler, özellikle kısa kelimeler, çok sayıda diğer kelime ile benzer olabilir. Örneğin “marka” kelimesini düşünelim. Eğer her bültende sıklıkla "market" gibi benzer kelimeler ile eşleşiyor fakat bunların hiçbiri ile ilgilenmiyorsak marka kelimesini tam eşleşme yaparak diğer tüm ilgisiz benzerleri filtreleyebiliriz.</p>',
    'subtitle-4-description-2' => '<p>Şimdi <strong>marka</strong> kelimesini tam eşleşme içine alarak tekrar arayalım.</p>',
    'subtitle-5' => 'Tam eşleşme özelliği ile yalnızca belirli benzerlikleri engelleme',
    'subtitle-5-description' => '<p>Tam eşleşme özelliği, bir kelimenin içerisindeki sadece belirli karakterlere de uygulanabilir. Bu durumda, çıkan sonuçlar arasında eşleşen kelimede tam eşleşmesi istenen tırnak içerisindeki ifadenin birebir olarak geçmediği sonuçlar filtrelenir.</p>',
    'subtitle-5-description-2' => '<p>Aradığınız anahtar kelimeye göre bazen bir karakteri tam eşleşmeye almak, sonuçları istediğiniz hale getirebilir.</p>',
    'subtitle-5-description-3' => '<p>Şimdi <strong>okulları</strong> anahtar kelimesini arayalım ve sonuçlarını görelim.</p>',
    'subtitle-5-description-4' => '<p><strong>okullar-oğullar</strong> benzerliğinden dolayı istemediğimiz sonuçlarla karşılaştık. Bunun nedeni <strong>k-ğ</strong> benzerliği.</p>',
    'subtitle-5-description-5' => '<p>Anahtar kelimemizi <strong>o"k"ullar</strong> olarak değiştirelim ve tekrar arayalım.</p>',
    'subtitle-5-description-6' => '<p>Sonuçlarda da görüldüğü gibi k-ğ benzerliğinden dolayı istemediğimiz sonuçlar filtrelendi.</p>',
    'subtitle-6' => 'DIŞLANAN KELİMELER',
    'subtitle-6-description' => '<p class="mt-4">Arama yaparken sonuçlarda çıkan/çıkması muhtemel bazı kelimeleri dışlamak isteyebilirsiniz. Bunun için dışlanan kelimeler filtresini kullanabilirsiniz.</p>',
    'subtitle-6-description-2' => '<p>Eklediğiniz dışlanan kelime, aradığınız anahtar kelime ile çıkan sonuçlar içinde bire bir olarak bulunuyorsa filtreleme yapılır ve size gösterilmez.</p>',
    'subtitle-6-description-3' => '<p>Dışlanan kelimeleri takip edilen markayı gözden kaçırma riski olmadan rahatlıkla kullanabilirsiniz. Çünkü dışlanan kelimeler ancak anahtar kelime ile eşleşen kelime için dikkate alınır ve sonucun filtrelenmesi için eşleşen kelimenin dışlanan kelime ile bire bir aynı olması gerekir.</p>',
    'subtitle-6-description-4' => '<p>Filtreleme yaparken tam eşleşme ile aradığınızda aradığınız metin sonuçlarda bire bir olarak çıkacaktır. Tam eşleşme sağlandığı halde eşleşen kelime ön ek ve son ek alabilir.</p>',
    'subtitle-6-description-5' => '<p class="mt-4">Herhangi bir dışlanan kelime eklemeden <strong>arteng</strong> anahtar kelimesi için sonuçları arayalım.</p>',
    'subtitle-6-description-6' => '<p>Şimdi de daha net sonuçlar almak için bir adet dışlanan kelime ekleyelim.</p>',
    'subtitle-6-description-7' => '<p>Bu örnekte bir adet dışlanan kelime ekledik. Burada dışlanan kelime eklediğinizde eklenen kelime birebir olarak eşleşen anahtar kelimede geçmelidir.</p>',
    'subtitle-6-description-8' => '<p>Örnekte bulunan 2 numaralı markada <strong>garden</strong> kelimesi tamamen eşleştiği için sonuçlarda gösterilmemiştir.</p>',
];
