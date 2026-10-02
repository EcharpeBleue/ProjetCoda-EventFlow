# Audit initial

## 1. Comportement observable

<!-- À compléter. -->
Le fichier index.php instancie par défaut un nouveau Customer, un nouveau Ticket et un nouveau Booking.
Ensuite, on créé une réservation via la classe BookingItem et sa fonction addItem(), qui lui même récupère l'objet Ticket précédemment créé et affectant 2 en quantité.
Ensuite, 


## 2. Problèmes identifiés

| # | Problème | Catégorie | Impact |
|---|---|---|---|
| 1 | une classe a plusieurs responsabilités | responsabilité/lisiblité |code pas très claire  |
| 2 | La classe AnalycticsClient, ainsi que sa méthode track() ne sont jamais appelées | testabilitée | fonctionnalitée présente mais jamais utilisée |
| 3 | L'interface PayFastSdk ne fournit pas la même interface que le code actuel | autre(non fonctionnel) |  |
| 4 |  |  |  |
| 5 |  |  |  |
| 6 |  |  |  |

## 3. Nos trois priorités

1.rendre le code plus lisible
<!-- JP : Je suggère de modifier BookingService.php en priorité, à discuter. -->
2.corrigé les erreurs comme des fonctions non appelé

3.

## 4. Risques avant refactoring

À compléter.
