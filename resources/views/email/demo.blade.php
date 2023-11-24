<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IntiSolution</title>
</head>
<body>
    <p>Nama : {{ $user['full_name'] }}</p>
    <p>Perusahaan : {{ $user['company'] }}</p>
    <p>Industri : {{ $user['industri'] }}</p>
    <p>Solusi : {{ $user['solusi'] }}</p>
    <p>Keterangan</p>
    <p>{{ $user['keterangan'] }}</p>
</body>
</html>