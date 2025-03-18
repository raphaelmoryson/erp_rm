<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 120px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
            color: #2C3E50;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-info div {
            width: 45%;
        }
        .invoice-info p {
            margin: 5px 0;
        }
        .details {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .table td {
            font-size: 14px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logo and invoice title -->
        <div class="header">
            <img height="50" width="200" src="/images/logo.png" alt="Logo">
            <h1>Facture #{{ $invoice->id }}</h1>
        </div>

        <!-- Invoice Information -->
        <div class="invoice-info">
            <div>
                <p><strong>Locataire:</strong> {{ $invoice->tenant->firstName }} {{ $invoice->tenant->lastName }}</p>
                <p><strong>Appartement:</strong> {{ $invoice->unit->name }}</p>
                <p><strong>Montant:</strong> {{ number_format($invoice->amount, 2) }}€</p>
                <p><strong>Date d'échéance:</strong> {{ $invoice->due_date }}</p>
            </div>
            <div>
                <p><strong>Adresse:</strong> {{ $invoice->tenant->address }}</p>
                <p><strong>Email:</strong> {{ $invoice->tenant->email }}</p>
                <p><strong>Téléphone:</strong> {{ $invoice->tenant->phone }}</p>
                <p><strong>Date d'émission:</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Invoice Details Table -->
        <div class="details">
            <table class="table">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoiceLines as $line)
                        <tr>
                            <td>{{ $line->description }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>{{ number_format($line->unit_price, 2) }}€</td>
                            <td>{{ number_format($line->total_price, 2) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Amount -->
        <div class="total">
            <p><strong>Total à payer: {{ number_format($invoice->amount, 2) }}€</strong></p>
        </div>

        <!-- Footer with notes -->
        <div class="footer">
            <p>Merci pour votre paiement!</p>
            <p>Pour toute question, veuillez nous contacter par email à info@votreentreprise.com.</p>
        </div>
    </div>
</body>
</html>
