<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Keuntungan</title>

    <style>
        .table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr th {
            background-color: #0275d8;
            color: white;
        }

    </style>
</head>

<body>
   <center>
    <h3 class="text-center">Laporan Keuntungan</h3>
    <h4 class="text-center">
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
        dengan produk {{ $produk }}
    </h4>
   </center>

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Keuntungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
