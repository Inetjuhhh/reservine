<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reservatie #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #222;
            margin: 30px;
        }

        h1 {
            margin-bottom: 5px;
            font-size: 24px;
        }

        .subtitle {
            margin-bottom: 20px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .status-prepared {
            background: #d1fae5;
        }

        .status-served {
            background: #fef3c7;
        }

        .status-pending {
            background: #fee2e2;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .empty {
            margin-top: 20px;
            padding: 12px;
            background: #f8f8f8;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Bon van Reservatie #{{ $reservation->id }}</h1>
    <p class="subtitle">{{ $reservation->guest->name }} - {{ \Carbon\Carbon::parse($reservation->starts_at)->format('d-m-Y H:i') }}</p>

    @if($reservation->meals->isEmpty())
        <div class="empty">
            Er zijn nog geen bestellingen geplaatst.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Naam gerecht</th>
                    <th>Prijs</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservation->meals as $meal)
                    <tr class="
                        @if($meal->status === 'prepared')
                            status-prepared
                        @elseif($meal->status === 'served')
                            status-served
                        @else
                            status-pending
                        @endif
                    ">
                        <td>{{ $meal->name }}</td>
                        <td>€{{ number_format($meal->price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">
            Totaal: €{{ number_format($total, 2, ',', '.') }}
        </p>
    @endif
</body>
</html>
