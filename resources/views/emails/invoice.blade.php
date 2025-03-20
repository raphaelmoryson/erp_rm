<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Votre facture</title>
</head>

<body>
    <p>Bonjour {{ $invoice->tenant->firstName }},</p>
    <p>Voici votre facture pour le mois de {{ \Carbon\Carbon::parse($invoice->due_date)->format('F Y') }}.</p>
    <p>Montant dû : <strong>{{ number_format($invoice->amount, 2) }} €</strong></p>
    <p>Date limite de paiement : {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</p>
    <p>Vous trouverez votre facture en pièce jointe.</p>
    <p>Cordialement,</p>
    <p>L'équipe de gestion</p>
</body>

</html>
