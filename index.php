<?php

//Imports
require 'vendor/autoload.php';

use GuzzleHttp\Client;

//Config pages
$client = new Client([
    'base_uri' => 'http://www.guiatrabalhista.com.br',
    'timeout'  => 5.0,
]);

//Request
$response = $client->request('GET', '/guia/salario_minimo.htm');
$body = $response->getBody()->getContents();

$doc = new DOMDocument();
@$doc->loadHTML($body);

$matriz = [];

//collumns VIGÊNCIA, VALOR MENSAL, VALOR DIÁRIO, VALOR HORA, NORMA LEGAL, D.O.U.
//Scrapper Html Tags
$td = $doc->getElementsByTagName('td');

$data = [];
$row = 0;
$collum = 0;

foreach ($td as $collumns) {
    // print_r($collumns);
    $row++;
    $collum++;

    // echo "{$collumns->textContent} coluna {$collum}";
    switch ($collum) {
        case 1:
            $data['vigencia'] = $collumns->textContent;
            break;
        case 2:
            $data['valor_mensal'] = $collumns->textContent;
            break;
        case 3:
            $data['valor_diario'] = $collumns->textContent;
            break;
        case 4:
            $data['valor_hora'] = $collumns->textContent;
            break;
        case 5:
            $data['norma_legal'] = $collumns->textContent;
            break;
        case 6:
            $data['dou'] = $collumns->textContent;
            break;
    }

    if ($collum == 6) {
        array_push($matriz, $data);
        $collum = 0;
    }
}


print_r($matriz);
