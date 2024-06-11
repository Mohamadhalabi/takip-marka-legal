<p style="font-family: Helvetica,serif;line-height: 23px">Sayın {{ $user->name }},<br>
    Yeni marka bültenleri arasında yakın marka araştırmasını içeren size özel {{Carbon\Carbon::parse($date)->format('d-m-Y')}} tarihli raporunuz hazırdır. Bu raporda incelenen bültenler:<br><br>
    @foreach($json as $js)
        * {{ substr($js['title'],0,3) }} Sayılı Resmi Marka Bülteni <br>
    @endforeach
    <br>
    Rapora ekteki pdf'ten erişebilir veya kontrol panelinize giriş yaparak inceleyebilirsiniz.<br><br>
    <a class="btn btn-primary" href="https://takip.marka.legal/dashboard/report/{{ $report->id }}" style="
    display: block;
    width: 180px;
    height: 25px;
    background: #2d3748;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
    margin-left: 40%;
    text-decoration: none;
">Rapor Göster</a><br>
    Saygılarımızla,<br>
    Marka Legal Ekibi
</p>
