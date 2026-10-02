# Audit initial

## 1. Comportement observable

<!-- À compléter. -->

Le fichier contenant la plupart des responsabilités est BookingService.php. C'est lui qui gère la méthode de paiement (forcé), lance des erreurs si la quantité de billets demandés est nul, si l'email est invalide, calcule le total nécessité par la réservation, en vérifiant une deuxième fois d'une manière un peu différente si la quantité de billet demandés est inférieure ou égale à 0, applique les ristournes si client est VIP, applique l'ancienne règle Pass des 3 jours, effectue une vérification sur la méthode de paiement employé (alors que la variable par défaut est déjà appliqué à stripe),  gère les cas ou ce n'est pas Stripe, et enfin envoie la confirmation de réservation avec tous les détails, et envoie aussi un email de confirmation.

Le fichier index.php instancie par défaut un nouveau Customer, un nouveau Ticket et un nouveau Booking.
Ensuite, on créé une réservation via la classe BookingItem et sa fonction addItem(), qui lui même récupère l'objet Ticket précédemment créé et affectant 2 en quantité.
Ensuite, on instancie un nouveau BookingService, et on calcule le total demandé par l'entreprise pour la réservation du billet (forcé par le moyen de paiement Stripe), et on renvoie au client un message contenant le total demandé, ainsi que le nombre de billets voulus.



## 2. Problèmes identifiés

| # | Problème | Catégorie | Impact |
|---|---|---|---|
| 1 | la classe BookingService a plusieurs responsabilités, le fichier est ainsi très long | responsabilité/lisiblité | code pas très claire  |
| 2 | La classe AnalycticsClient, ainsi que sa méthode track() ne sont jamais appelées | testabilitée | fonctionnalitée présente mais jamais utilisée, code mort |
| 3 | La classe PayFastSdk ne fournit pas la même interface que le code actuel | autre(non fonctionnel) | Code mort |
| 4 | Code dans BookingService répétitif, donc refactorable | duplication | Entretenabilité de la classe difficile |
| 5 | tikets accepte les negatif | validation des données |fraude
| 6 | La méthode confirm() de BookingService force le moyent de paiement Stripe via une affectation dans les paramètres ; cette manière de faire ne correspond pas vraiment à une règle métier | règle métier | le système de WhiteList ici ne correspond pas au fonctionnement d'un système de paiement |


JP : Dans l'ordre, je mettrais 5-1-3-4-6-2
MA : 1-5-6-3-4-2

## 3. Nos trois priorités

1.Régler quelques erreurs liées à des situations "inattendues", renforcer le code existant
2.Rétablir la lisibilité du code via refactorisation, en déresponsabilisant les classes centrales, afin de rendre toute modification future dessus plus facile (ce qui sera de toute façon nécessaire dans les étapes suivantes)
3.Régler les soucis liés au code mort.

## 4. Risques avant refactoring

- Complexifier le code existant
- Briser le code existant
- Se perdre dans les préréquis de chaque classe