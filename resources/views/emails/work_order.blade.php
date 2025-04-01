<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de travaux</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5;">
    <h2>Bon de travaux</h2>

    <p>Bonjour {{ $company->name }},</p>

    <p>Nous vous informons que le devis a été accepté.</p>

    <h3>Détails de l'intervention :</h3>
    <ul>
        <li><strong>Immeuble :</strong> {{ $property->name }}</li>
        @if($unit)
            <li><strong>Lot concerné :</strong> {{ $unit->name }} ({{ $unit->type }})</li>
        @endif
        <li><strong>Description :</strong> {!! nl2br(e($description)) !!}</li>
    </ul>

    <p>Le bon de travaux est disponible en pièce jointe. Merci de confirmer la bonne réception de ce document.</p>

    <p>Cordialement,</p>
    <p><strong>L'équipe ImmoFlow</strong></p>
</body>
</html>
