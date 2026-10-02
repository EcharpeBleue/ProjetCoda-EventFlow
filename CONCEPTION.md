# Note de conception

## 1. Choix principaux

Nous avons décidé de retravailler complètement BookingService en priorité, en reclassant tout le code en classes et Interfaces.
Bien que je voulais lier AnalyticsClient au reste du code, ainsi que LoyaltyService, nous n'avons pas eu le temps de nous pencher dessus.

## 2. Principes SOLID mobilisés

Pour le I, la classe PayFastSdk transmettait des informations erronées à notre projet. L'Adapter permet maintenant de faire la traduction.
Pour le O, notre interface Validator ne prend qu'un seul paramètre mais sert aussi à effectuer un check sur de potentiels nouveaux objets, permettant des extensions.
Pour le S, notre BookingCalculator se concentre uniquement sur un besoin unique, si unique qu'il écarte les Discount.

## 3. Design Patterns éventuellement utilisés

L'Adapter a permis de faire le lien entre PayFastSdk et GatewayPayment, en transmettant les informations attendues par notre application. Il s'agissait de la solution la plus simple et la plus pertinente pour cette situation. Aucuns problèmes particuliers n'ont été rencontré.

## 4. Solutions envisagées puis écartées

Faire le lien entre AnalyticsClient et LoyaltyService en implémantant des Decorator. On aurait pu traiter, je crois, par exemple, AnalyticsClient comme étant l'interface responsable des Decorator.

## 5. Ce que nous améliorerions avec plus de temps
On aurai refactorisé le temps de payement ainsi que les modes de payement
