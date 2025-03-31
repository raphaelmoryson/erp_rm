<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bon de Travaux</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            padding: 8px;
        }

        th {
            background-color: #093B69;
            color: white;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="/images/logo2.png" width="150" alt="Logo">
    </div>
    <h2 style="text-align:center;">BON DE TRAVAUX</h2>
    <hr>

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
    </table>

    <h3>Description des Travaux</h3>
    <p>{{ nl2br($report->description) }}</p>

    <h3>Statut</h3>
    <p>
        @switch(strtoupper($report->status))
            @case('PENDING')
                <strong style="color: orange;">En attente</strong>
            @break

            @case('IN_PROGRESS')
                <strong style="color: blue;">En cours</strong>
            @break

            @case('COMPLETED')
                <strong style="color: green;">Terminé</strong>
            @break

            @case('CANCELLED')
                <strong style="color: red;">Annulé</strong>
            @break

            @default
                <strong style="color: gray;">Inconnu</strong>
        @endswitch
    </p>

    <h3>Date de Création</h3>
    <p>{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}</p>

</body>

</html>
