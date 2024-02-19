<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        @page { margin: 0px; }
    </style>
</head>

<body>
    <p style="text-align: center;">TARE MAKMUR<br>Jl. Gajah Mada Gg Semangka<br>Mojokerto</p>
    <p style="text-align: center;">
        =======================================================================================================================================================================================================
    </p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 11px;">{{ $data->no_invoice }}</td>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 11px; text-align: right;">
                    {{ carbon\Carbon::parse($data->created_at)->isoFormat('D MMM YYYY') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 11px;">Customer</td>
                <td style="width: 50%; border: none rgb(0, 0, 0); font-size: 11px; text-align: right;">
                    {{ $data->customer->nama }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <p style="text-align: center;">
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </p>
    @foreach ($data->detail_penjualan as $detail)
        <p style="font-size: 13px; margin-left: 0px;"> {{ $loop->iteration }}) {{ $detail->barang->nama_barang }}</p>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 25.0000%; font-size: 11px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;{{ $detail->aktual }} {{ $detail->jenis=='dus' ? 'Dos' : 'Pack' }} </td>

                    <td style="width: 25.0000%; font-size: 11px;">{{ formatRupiah($detail->harga_satuan) }}</td>
                    <td style="width: 25.0000%; font-size: 11px;">{{ formatRupiah($detail->diskon) }}</td>
                    <td style="width: 25.0000%; font-size: 11px;">{{ formatRupiah($detail->harga) }}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <p style="text-align: center;">
        --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Total</td>
                <td style="width: 50%; border: none rgb(0, 0, 0);">
                    <div style="text-align: right;">{{ formatRupiah($data->detail_penjualan->sum('harga')) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Pembayaran</td>
                <td style="text-align: right; width: 50%; border: none rgb(0, 0, 0);">Tunai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <p>Keterangan :<br>
</body>

</html>
