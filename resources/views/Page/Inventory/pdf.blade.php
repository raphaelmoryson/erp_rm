<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>État des Lieux</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #007bff;
        }
        .header p {
            font-size: 14px;
            color: #555;
        }
        .details, .table {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td, .details th {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .details th {
            background-color: #007bff;
            color: white;
        }
        .table th, .table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table td img {
            max-width: 150px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .signatures div {
            text-align: center;
        }
        .signatures div p {
            margin-top: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <img src="path_to_logo/logo.png" alt="Logo">
            <h1>État des Lieux</h1>
            <p>Date : {{ $inventory->date }}</p>
            <p>Type : {{ ucfirst($inventory->type) }}</p>
            <p>Appartement : {{ $inventory->unit->name }}</p>
            <p>Locataire : {{ $inventory->unit->tenant->lastName }} {{ $inventory->unit->tenant->firstName }}</p>
        </div>

        <!-- Détails -->
        <div class="details">
            <table>
                <tr>
                    <th>Date</th>
                    <td>{{ date('d/m/Y', strtotime($inventory->date)) }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>{{ ucfirst($inventory->type) }}</td>
                </tr>
                <tr>
                    <th>Appartement</th>
                    <td>{{ $inventory->unit->name }}</td>
                </tr>
                <tr>
                    <th>Locataire</th>
                    <td>{{ $inventory->unit->tenant->lastName }} {{ $inventory->unit->tenant->firstName }}</td>
                </tr>
            </table>
        </div>

        <!-- Tableau des éléments inspectés -->
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Élément</th>
                        <th>État</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventory->elements as $element)
                        <tr>
                            <td>{{ $element->name }}</td>
                            <td>{{ $element->etat }}</td>
                            <td>
                                @if($element->photo && file_exists(public_path('uploads/' . $element->photo)))
                                    <img src="{{ asset('uploads/' . $element->photo) }}" alt="{{ $element->name }}">
                                @else
                                    Aucune photo
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div>
                <p>Signature du Locataire</p>
            </div>
            <div>
                <p>Signature du Propriétaire</p>
            </div>
        </div>
    </div>
</body>
</html>
