<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <style>
        body {
            font-size: 12px;
        }

        h2,
        h3 {
            color: #093B69;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 4px;
        }

        th {
            background-color: #093B69;
            color: white;
        }

        p {
            margin-bottom: 10px;
        }

        .photo {
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <div class="header">
        <img src="/images/logo2.png" width="50" alt="Logo">
    </div>
    <h2 style="text-align:center;">BON DE TRAVAUX</h2>
    <h3>Informations de l'Entreprise</h3>
    <table>
        <tr>
            <td><strong>Nom :</strong></td>
            <td>{{ $report->company->name }}</td>
        </tr>
        <tr>
            <td><strong>Adresse :</strong></td>
            <td>{{ $report->company->address }}, {{ $report->company->zip_code }} {{ $report->company->city }}</td>
        </tr>
        <tr>
            <td><strong>Téléphone :</strong></td>
            <td>{{ $report->company->phone }}</td>
        </tr>
        <tr>
            <td><strong>Email :</strong></td>
            <td>{{ $report->company->email }}</td>
        </tr>
        <tr>
            <td><strong>SIREN :</strong></td>
            <td>{{ $report->company->siren }}</td>
        </tr>
    </table>

    <h3>Propriété & Logement</h3>
    <table>
        <tr>
            <td><strong>Propriété :</strong></td>
            <td>{{ $report->property->name }}</td>
        </tr>
        <tr>
            <td><strong>Adresse :</strong></td>
            <td>{{ $report->property->address }}, {{ $report->property->zip_code }} {{ $report->property->city }}</td>
        </tr>
        <tr>
            <td><strong>Logement :</strong></td>
            <td>{{ $report->unit->name }} ({{ $report->unit->type }} - Étage {{ $report->unit->floor }})</td>
        </tr>
        <tr>
            <td><strong>Superficie :</strong></td>
            <td>{{ $report->unit->area }} m²</td>
        </tr>
    </table>

    <h3>Description des Travaux</h3>

    <p>{!! nl2br(e($report->workOrders[0]->description)) !!}</p>



    <h3>Détails du Devis</h3>
    <table>
        <tr>
            <td><strong>Délai d'exécution :</strong></td>
            <td>{{ $report->workOrders[0]->execution_deadline }}</td>
        </tr>
        <tr>
            <td><strong>Prix du devis :</strong></td>
            <td>{{ number_format($report->workOrders[0]->quote_price ?? 0, 2) }} CHF</td>
        </tr>
        <tr>
            <td><strong>Date de réception du devis :</strong></td>
            <td>{{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') : 'Non défini' }}
            </td>
        </tr>
        <tr>
            <td><strong>Travaux assignés à :</strong></td>
            <td>{{ $report->workOrders[0]->assigned_to ?? 'Non assigné' }}</td>
        </tr>
        <tr>
            <td><strong>Date prévue :</strong></td>
            <td>{{ $report->workOrders[0]->scheduled_date ? \Carbon\Carbon::parse($report->scheduled_date)->format('d/m/Y') : 'Non définie' }}
            </td>
        </tr>
    </table>

    <h3>Date de Création</h3>
    <p>{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}</p>
</body>

</html>
