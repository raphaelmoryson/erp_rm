<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #093B69;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header img {
            max-height: 35px;
        }

        .header h1 {
            font-size: 16px;
            color: #093B69;
        }

        .invoice-info {
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            word-wrap: break-word;
        }

        .table th {
            background-color: #093B69;
            color: white;
            font-weight: bold;
        }

        .total-container {
            width: 40%;
            float: right;
            margin-left: 10px;
            padding-bottom: 10px;
        }

        .total-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-container table td {
            border: 1px solid #ddd;
            padding: 4px;
            word-wrap: break-word;
            text-align: right;
        }

        .total-container table tr:last-child td {
            font-weight: bold;
            background-color: #093B69;
            color: white;
            padding: 4px;
        }

        .payment-info {
            clear: both;
            padding: 8px;
            border: 1px solid #093B69;
            background-color: #eef3f7;
            border-radius: 5px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 9px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img height="50" width="90" src="/images/logo2.png" alt="Logo">
            <h1>Facture #{{ $invoice->id }}</h1>
        </div>

        <div class="invoice-info">
            <p><strong>Locataire :</strong> {{ $invoice->tenant->firstName }} {{ $invoice->tenant->lastName }}</p>
            <p><strong>Appartement :</strong> {{ $invoice->unit->name }}</p>
            <p><strong>Date d'échéance :</strong> {{ $invoice->due_date }}</p>
            <p><strong>Email :</strong> {{ $invoice->tenant->email }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th><strong>Libellé</strong></th>
                    <th><strong>Quantité</strong></th>
                    <th><strong>Prix Unitaire</strong></th>
                    <th><strong>Total HT</strong></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                @endphp
                @foreach($invoice->invoiceLines as $line)
                    @php
                        $subtotal += $line->total;
                    @endphp
                    <tr>
                        <td>{{ $line->description }}</td>
                        <td>{{ $line->quantity }}</td>
                        <td>{{ number_format($line->unit_price, 2) }}€</td>
                        <td>{{ number_format($line->total, 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="test"></div>
        <div class="total-container">
            <table>
                <tr>
                    <td>Sous-total HT :</td>
                    <td>{{ number_format($subtotal, 2) }}€</td>
                </tr>
                <tr>
                    <td>TVA (20%) :</td>
                    <td>{{ number_format($subtotal * 0.20, 2) }}€</td>
                </tr>
                <tr>
                    <td>Total TTC :</td>
                    <td><strong>{{ number_format($subtotal * 1.20, 2) }}€</strong></td>
                </tr>
            </table>
        </div>

        <!-- Informations de paiement -->
        <div class="payment-info">
            <p><strong>Informations de paiement :</strong></p>
            <p>Veuillez effectuer le paiement sur le compte suivant :</p>
            <p><strong>Banque :</strong> Nom de la banque</p>
            <p><strong>IBAN :</strong> FR76 1234 5678 9012 3456 7890 189</p>
            <p><strong>BIC :</strong> ABCDFRPP</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre paiement !</p>
            <p>Pour toute question, contactez-nous à info@votreentreprise.com</p>
        </div>
    </div>
</body>

</html>
