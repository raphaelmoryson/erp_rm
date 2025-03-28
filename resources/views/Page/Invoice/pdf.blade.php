<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        .container {
            width: 100%;
            border-radius: 5px;
            background: #fff;
        }

        .header {
            border-bottom: 2px solid #093B69;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            max-height: 35px;
        }

        .contact-info {
            text-align: right;
            font-size: 10px;
        }

        .invoice-info {
            margin-bottom: 10px;
        }

        .total-container {
            width: 40%;
            float: right;
            margin-top: 10px;
        }

        .total-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-container table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: right;
        }

        .total-container table tr:last-child td {
            font-weight: bold;
            background-color: #093B69;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <img src="/images/logo2.png" width="150" alt="Logo">
            <div class="contact-info">
                <p><strong>Votre Contact:</strong> Nom du Contact</p>
                <p><strong>Ligne directe:</strong> +33 1 23 45 67 89</p>
                <p><strong>Email:</strong> contact@votreentreprise.com</p>
            </div>
        </div>

        <!-- Informations de facture -->
        <div class="invoice-info">
            <p><strong>Facture n° :</strong> {{ $invoice->id }}</p>
            <p><strong>Réglement :</strong> Virement bancaire</p>
            <p><strong>Référence :</strong> {{ $invoice->reference }}</p>
        </div>

        <p><strong>Monsieur, Madame,</strong></p>

        @if($invoice->invoiceLines->count() == 1)
            <p>
                Nous vous informons que le montant qui nous est dû à titre de :
                <strong>{{ $invoice->invoiceLines->first()->description }}</strong>
            </p>
            <div class="total-container">
                <table>
                    <tr>
                        <td>Sous-total HT :</td>
                        <td>{{ number_format($invoice->invoiceLines->first()->unit_price, 2) }} CHF</td>
                    </tr>
                    <tr>
                        <td>TVA (8.5%) :</td>
                        <td>{{ number_format($invoice->invoiceLines->first()->unit_price * 0.085, 2) }} CHF</td>
                    </tr>
                    <tr>
                        <td>Total TTC :</td>
                        <td><strong>{{ number_format($invoice->invoiceLines->first()->unit_price * 1.085, 2) }} CHF</strong></td>
                    </tr>
                </table>
            </div>
        @else
            <p>Nous vous informons que le montant qui nous est dû concerne les prestations suivantes :</p>
            
            <!-- Tableau des prestations -->
            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($invoice->invoiceLines as $line)
                        @php $subtotal += $line->total; @endphp
                        <tr>
                            <td>{{ $line->description }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>{{ number_format($line->unit_price, 2) }} CHF</td>
                            <td>{{ number_format($line->total, 2) }} CHF</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tableau des totaux -->
            <div class="total-container">
                <table>
                    <tr>
                        <td>Sous-total HT :</td>
                        <td>{{ number_format($subtotal, 2) }} CHF</td>
                    </tr>
                    <tr>
                        <td>TVA (8.5%) :</td>
                        <td>{{ number_format($subtotal * 0.085, 2) }} CHF</td>
                    </tr>
                    <tr>
                        <td>Total TTC :</td>
                        <td><strong>{{ number_format($subtotal * 1.085, 2) }} CHF</strong></td>
                    </tr>
                </table>
            </div>
        @endif
    </div>
</body>

</html>
