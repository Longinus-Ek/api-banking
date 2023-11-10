<?php

namespace Longinus\Apibanking\Render;

use Longinus\Apibanking\Traits\Arquivos;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class Render extends Mpdf
{
    use Arquivos;

    /**
     * @throws MpdfException
     */
    public function __construct(array $config = [], $container = null)
    {
        parent::__construct($config, $container);
    }

    /**
     * @throws MpdfException
     */
    public function generatePDF(array $boleto, string $path)
    {
        $dados = $boleto;

        $conteudo = '<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>rel_renderBol_v2</title>
    <style type="text/css"> * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }
    .s1 {
        color: black;
        font-family: "Times New Roman", serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
    }
    .s2 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 8pt;
    }
    .s3 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 7pt;
    }
    .s4 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 15pt;
    }
    .s5 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 10pt;
    }
    .s6 {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 6pt;
    }
    .position1 {
        border-top-style: solid;
        border-top-width: 1pt;
        border-left-style: solid;
        border-left-width: 1pt;
        border-bottom-style: solid;
        border-bottom-width: 1pt;
        border-right-style: solid;
        border-right-width: 1pt
    }
    .position2 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position3 {
        border-top-style:solid;
        border-top-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position4 {
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position5 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:2pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position6 {
        border-top-style:solid;
        border-top-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position7 {
        border-bottom-style:solid;
        border-bottom-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position8 {
        border-left-style:solid;
        border-left-width:1pt;
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position9 {
        border-bottom-style:solid;
        border-bottom-width:1pt
    }
    .position10 {
        border-top-style:solid;
        border-top-width:2pt
    }
    .position11 {
        border-top-style:solid;
        border-top-width:2pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position12 {
        border-top-style:solid;
        border-top-width:2pt;
        border-left-style:solid;
        border-left-width:1pt
    }
    .position13 {
        border-top-style:solid;
        border-top-width:1pt;
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position14 {
        border-left-style:solid;
        border-left-width:1pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    .position15 {
        border-left-style:solid;
        border-left-width:1pt
    }
    .position16 {
        border-right-style:solid;
        border-right-width:1pt
    }
    .position17 {
        border-top-style:solid;
        border-top-width:2pt;
        border-right-style:solid;
        border-right-width:1pt
    }
    table, tbody {
        vertical-align: top;
        overflow: visible;
    }
    </style>
</head>
<body>
<p style="text-align: left;">
    <img width="150" height="40" src="data:image/png;base64,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"/>
    <br/>
</p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:18pt">
        <td style="width: 450px" class="position1" rowspan="3">
            <table>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <p class="s1" style="line-height: 9pt;">Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s2" style="line-height: 9pt;text-align: left;">LABEL SYSTEM DESENVOLVIMENTO DE SOFTWARE E CONSULTA</p>
                    </td>
                    <td style="text-align: left">
                        <p class="s2" style="text-align: left;">44218309000128</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <p class="s2" style="text-align: left;">BOTUVERA 508</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <p class="s2" style="text-align: left;">SALA 02</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s2" style="text-align: left;">ITOUPAVAZINHA</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s2" style="text-align: left;">Blumenau - SC</p>
                    </td>
                    <td style="text-align: left">
                        <p class="s2" style="text-align: left;">89066360</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 130px" class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left;">
                        <p class="s1" style="line-height: 9pt">Vencimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt">30/11/2023</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 120px" class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor do Documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Outros acréscimos</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Mora/Multa</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:20pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Desconto/Abatimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Outras deduções</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:18pt">
        <td class="position1" rowspan="3">
            <p class="s1" style="line-height: 8pt;text-align: left;">Instruções (texto de responsabilidade do beneficiário)</p>
            <p class="s3" style="text-align: left;">Boleto gerado 10/11/2023 08:19:30</p>
            <p class="s3" style="text-align: left;">Boleto gerado por Label System</p>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data de Emissão</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">10/11/2023</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(=) Valor cobrado</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2" style="line-height: 8pt;">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Coop Contr/Cód. Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">3249/544922</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nosso Número</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 8pt;">26-7</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="line-height: 9pt;text-align: left;margin-left:6pt">
    <span style=" color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt;">Dados do Pagador</span>
</p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:19pt">
        <td style="width: 500px" class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nome do pagador</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">CSX SOLUCOES LTDA</p>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 200px;" class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Número do Documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">2</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Endereço</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">RUA BOTUVERA</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1" colspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Bairro / Distrito</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">ITOUPAVAZINHA</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Munícipio</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <p class="s2" style="line-height: 9pt;">BLUMENAU</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">UF</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">SC</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">CEP</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2" style="line-height: 9pt;">89066360</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="text-align: left;"><br/></p>
<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
    <tr style="height:20pt">
        <td class="position7" style="width: 150px">
            <p style="text-align: center;">
                <img width="150" height="40" src="data:image/png;base64,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"/>
            </p>
        </td>
        <td style="width: 100px;text-align: center;; vertical-align: middle" class="position4">
            <p class="s4" style="">756</p>
        </td>
        <td style="width: 450px;text-align: center;; vertical-align: middle" colspan="7" class="position8">
            <p class="s5" style="text-align: left;">75691.32496 01054.492200 00002.670016 5 95500000002000</p>
        </td>
    </tr>
    <tr style="height:28pt">
        <td colspan="3" class="position1" >
            <p class="s1" style="line-height: 9pt;text-align: left;">Local de pagamento</p>
            <p class="s2" style="text-align: left;">PAGAVEL PREFERENCIALMENTE NO SICOOB</p>
        </td>
        <td colspan="3" class="position1" bgcolor="#CCCCCC" >
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Vencimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">30/11/2023</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:28pt">
        <td colspan="3" class="position2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left;">
                        <p class="s1" style="line-height: 9pt;">Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">LABEL SYSTEM DESENVOLVIMENTO DE SOFTWARE E CONSULTA</p>
                    </td>
                    <td style="text-align: right;">
                        <p class="s2">44218309000128</p>
                    </td>
                </tr>
            </table>
        </td>
        <td colspan="3" class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Cooperativa contratante/Cód. Beneficiário</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">3249 / 544922</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:28pt">
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data do documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">10/11/2023</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">N. documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">2</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Espécie</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">DM</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Aceite</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">S</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Data processamento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">10/11/2023</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Nosso número</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">26-7</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:27pt">
        <td class="position1" bgcolor="#CCCCCC">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Uso do Banco</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Carteira</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">1</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Espécie</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">R$</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Quantidade</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">0,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">Valor documento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="4" rowspan="3">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt;text-align: left;">Instruções (texto de responsabilidade do beneficiário)</p>
                        <p></br></p>
                        <p class="s3" style="line-height: 9pt;text-align: left;">Boleto gerado 10/11/2023 08:19:30</p>
                        <p></br></p>
                        <p class="s3" style="line-height: 9pt;text-align: left;">Boleto gerado por Label System</p>
                    </td>
                    <td style="text-align: right">
                        <img id="qr-base64" class="center" alt="" width="120" height="120" src="data:image/png;base64,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">
                    </td>
                </tr>
            </table>
        </td>
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Desconto / Abatimento</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1"  colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(-) Outras deduções</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1"  colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Mora / Multa</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="4" style="text-align: left;" rowspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt;">Pagador:</p>
                        <p class="s2">CSX SOLUCOES LTDA</p>
                        <p class="s2">RUA BOTUVERA</p>
                        <p class="s2">BLUMENAU - SC</p>
                        <p class="s2" style="line-height: 9pt;text-align: left;">ITOUPAVAZINHA</p>
                        <p class="s1" style="line-height: 9pt;text-align: left;">Beneficiário Final <span class="s2">CSX SOLUCOES LTDA</span></p>
                    </td>
                    <td colspan="2" style="text-align: right;">
                        <p><br/></p>
                        <p class="s2">21728376000197</p>
                        <p><br/></p>
                        <p class="s2">89066360</p>
                        <p class="s2">44218309000128</p>
                    </td>
                </tr>
            </table>
        </td>
        <td class="position13" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(+) Outros acréscimos</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="height:30pt">
        <td class="position1" colspan="2">
            <table style="width: 100%">
                <tr>
                    <td style="text-align: left">
                        <p class="s1" style="line-height: 9pt">(=) Valor cobrado</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <p class="s2">20,00</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="margin-left:6pt; padding-top: 10px">
    <tr>
        <td>
            <img width="420" height="50" src="data:image/jpg;base64,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"/>
        </td>
    </tr>
</table>
</body>
</html>';
        $this->WriteHTML($conteudo);

        return $this->Output($path, 'F');
    }
}
