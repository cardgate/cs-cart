![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module voor CS.Cart

[![Build Status](https://travis-ci.org/cardgate/cs-cart.svg?branch=master)](https://travis-ci.org/cardgate/cs-cart)

## Support

Deze plugin ondersteunt CS.Cart versie **4.4.x-4.12.x**

## Voorbereiding

Voor het gebruik van deze module zijn CardGate RESTful gegevens nodig.  
Bezoek hiervoor [Mijn CardGate](https://my.cardgate.com/) en haal daar je 
gegevens op, of neem contact op met je accountmanager.

## Installatie

1. Download en unzip het meest recente [cardgate.zip](https://github.com/cardgate/cs-cart/releases) bestand op je bureaublad.

2. Upload de **inhoud** van de **cardgate** map naar de **root** map van je webshop.

3. Zorg ervoor dat je **cache leeg** is. Wellicht moeten de Smarty templates opnieuw worden gecompileerd voordat de template aanpassingen **zichtbaar** zijn.

4. Doe dit door de parameter **ctpl** aan je admin URL toe te voegen.

## Configuratie

1. Login op het **admin** gedeelte van je webshop.

2. Ga naar **Plug-ins** en kies **Plug-ins beheren**.

3. Gebruik het Zoek venster om de CardGate plug-in te vinden, en klik op **Installeer**.

4. Klik op de **Instellingen** van de geïnstalleerde plug-in.

5. Stel de Mode in op **Test** voor een test transactie.

6. Vul de **site ID** en de **hash key** in, deze kun je vinden bij **Sites** op [Mijn CardGate](https://my.cardgate.com/).

7. Vul de **merchant ID** en de **API key** in die je van CardGate hebt ontvangen.

8. Klik op **Opslaan**.

9. **Let Wel:** Deze instellingen gelden voor **alle** CardGate betaalmethoden. 

10. Maak nu de **specifieke** CardGate betaalmethoden aan die je wilt gebruiken in je winkel.

11. Kies **Betaalmethode** in het **Administratie** menu.

12. Klik op de **Betaalmethode toevoegen** knop.

13. Vul de naam in van de betaalmethode en kies de juiste **CardGate** betaalmethode uit het **Verwerkingseenheid** menu.

14. Vul de overige gegevens in en klik op de **Opslaan** knop.

15. De instellingen van de **Algemeen** tab gelden per **specifieke** betaalmethode.

16. Zorg ervoor dat je **na het testen** omschakelt van **Test Mode** naar **Live mode** in de **CardGate** instelligen en sla het op (**Save**).

## Vereisten

Geen verdere vereisten.
