<?php


function tckn_verify($values)
{

    $xmlText = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
    <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
    <TCKimlikNo>' . $values["tckn"] . '</TCKimlikNo>
    <Ad>' . $values["name"] . '</Ad>
    <Soyad>' . $values["surname"] . '</Soyad>
    <DogumYili>' . $values["birthyear"] . '</DogumYili>
    </TCKimlikNoDogrula>
    </soap:Body>
    </soap:Envelope>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,            "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,           true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS,    $xmlText);
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
        'POST /Service/KPSPublic.asmx HTTP/1.1',
        'Host: tckimlik.nvi.gov.tr',
        'Content-Type: text/xml; charset=utf-8',
        'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
        'Content-Length: ' . strlen($xmlText)
    ));
    $return = curl_exec($ch);
    curl_close($ch);

    return strip_tags($return);
}

$userinfo = [
    "name" => "ÖMER ALPAY",
    "surname" => "KADIOĞLU",
    "birthyear" => "1111",
    "tckn" => "11111111111"
];

$tckn_result = tckn_verify($userinfo);

if ($tckn_result == "true") {

    echo "Doğrulama başarılı";
} else {

    echo "Doğrulama başarısız";
}
