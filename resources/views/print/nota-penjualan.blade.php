<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <style>
       *{
        font-size: 6px;
        margin: 0px;
      
       }
       @page{
        size: 80mm;
       } --}}
    </style>
</head>

<body>
    <p style="text-align: center;">TARE MAKMUR<br>Jl. Gajah Mada Gg Semangka<br>Mojokerto</p>
    <p style="text-align: center;">=======================================================================================================================================================================================================</p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">{{ $data->no_invoice }}</td>
                <td style="width: 50%; border: none rgb(0, 0, 0);">{{ carbon\Carbon::parse($data->created_at)->isoFormat('D MMM YYY') }}</td>
            </tr>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Customer</td>
                <td style="width: 50%; border: none rgb(0, 0, 0);">{{ $data->customer->nama }}</td>
            </tr>
        </tbody>
    </table>
    <p style="text-align: center;">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
    @foreach ($data->detail_penjualan as $detail)     
    <p> {{ $loop->iteration }}) {{ $detail->barang->nama_barang }}</p>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 25.0000%;">{{ $detail->aktual }} Dus</td>
               
                <td style="width: 25.0000%;">{{ formatRupiah($detail->harga_satuan) }}</td>
                <td style="width: 25.0000%;">{{ formatRupiah($detail->diskon) }}</td>
                <td style="width: 25.0000%;">{{ formatRupiah($detail->harga) }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
    
    <p style="text-align: center;">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
    <table style="width: 100%; border-collapse: collapse; border: none rgb(0, 0, 0);">
        <tbody>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Total</td>
                <td style="width: 50%; border: none rgb(0, 0, 0);">
                    <div style="text-align: right;">{{ formatRupiah($data->detail_penjualan->sum('harga')) }}</div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: none rgb(0, 0, 0);">Pembayaran</td>
                <td style="text-align: right; width: 50%; border: none rgb(0, 0, 0);">Tunai</td>
            </tr>
        </tbody>
    </table>
    <p>Keterangan :<br>
</body>

</html>
