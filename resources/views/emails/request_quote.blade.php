<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de devis</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>📩 Demande de devis pour une intervention</h2>

    <p>Bonjour {{ $company->name }},</p>

    <p>Le gestionnaire de l'immeuble <strong>{{ $property->name }}</strong> a signalé un problème nécessitant une intervention.</p>

    <h3>🛠️ Détails de l'intervention :</h3>
    <ul>
        <li><strong>🏢 Immeuble :</strong> {{ $property->name }}</li>
        @if($unit)
            <li><strong>🏠 Lot concerné :</strong> {{ $unit->name }} ({{ $unit->type }})</li>
        @endif
        <li><strong>📋 Description :</strong> {{ $problem }}</li>
    </ul>

    <p>Vous trouverez en pièce jointe une photo du problème.</p>

    <p>Merci de bien vouloir soumettre votre devis en cliquant sur le lien ci-dessous :</p>

    <p>
        <a href="{{ $quoteLink }}" style="display:inline-block;padding:10px 15px;background:#007bff;color:#fff;text-decoration:none;border-radius:5px;">
            🔗 Déposer un devis
        </a>
    </p>

    <p>Nous attendons votre retour rapidement.</p>

    <p>Cordialement,</p>
    <p><strong>L'équipe ImmoFlow</strong></p>

</body>
</html>
