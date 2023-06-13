<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title }}</title>
        <style>
            .border-table{
                border: 1px solid;
                width: 100%;
                border-collapse: collapse;
            }
            .border-table th, .border-table td{
                border: 1px solid;
            }
            .border-table td{
                padding-left:  7px;
                padding-right: 7px;
            }
            .text-center{
                text-align: center;
            }
            .align-middle{
                vertical-align: middle;
            }
            .text-right{
                text-align: right;
            }
        </style>
    </head>
    <body style="text-align: center">
        <table style="width: 100%;">
            <tr>
                <td style="width: 10%;">
                    <img src="{{ asset('logo.png') }}" alt="" width="90" height="90">
                </td>
                <td style="width: auto;" class="text-center">
                    <h5 style="margin-bottom: 2px; margin-top: 0px; font-size: 14pt">PEMERINTAH KABUPATEN HULU SUNGAI SELATAN</h5>
                    <h5 style="margin-bottom: 2px; margin-top: 0px; font-size: 15pt">KECAMATAN KANDANGAN</h5>
                    <p style="margin-bottom: 2px; margin-top: 0px; font-size: 10pt">Alamat: Jalan H. M. Yusi Kelurahan Kandangan Utara</p>
                    <p style="margin-bottom: 2px; margin-top: 0px; font-size: 10pt">Kecamatan Kandangan Kode Pos 71211</p>
                </td>
                <td style="width: 10%;"></td>
            </tr>
        </table>
        <hr>
        <h3 class="text-center my-4">{{ $title }}</h3>
        @yield('content')

        <table style="width: 100%; margin-top: 40px">
            <tr>
                <td style="width: 60%"></td>
                <td class="text-center">
                    <b>CAMAT KANDANGAN</b>
                    <br><br><br><br>
                    <b>
                        <u>H.SYAMSURI, SSTP, M.SI</u><br>
                        NIP. 198101112000121002
                    </b>
                </td>
            </tr>
        </table>
    </body>
</html>