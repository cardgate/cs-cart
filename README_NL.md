![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module voor CS.Cart

[![Build Status](https://travis-ci.org/cardgate/cs-cart.svg?branch=master)](https://travis-ci.org/cardgate/cs-cart)

## Support

Deze plugin ondersteunt CS.Cart versie **4.4.x-4.11.x**

## Voorbereiding

Voor het gebruik van deze module zijn CardGate RESTful gegevens nodig.  
Bezoek hiervoor [Mijn CardGate](https://my.cardgate.com/) en haal daar je 
gegevens op, of neem contact op met je accountmanager.

## Installatie

1. Download en unzip het meest recente [cardgate.zip](https://github.com/cardgate/cs-cart/releases) bestand op je bureaublad.

2. Upload de **inhoud** van de **cardgate** map naar de **root** map van je webshop.

3. Zorg ervoor dat je **cache leeg** is. Wellicht moeten de Smarty templates opnieuw worden gecompileerd voordat de template aanpassingen **zichtbaar** zijn.
   Doe dit door de parameter **ctpl** aan je admin URL toe te voegen.

4. Open the URL **http://mywebshop.com/cardgate_install.php** in je browser, zodat de plug-in installeert.  
   (Vervang **http://mywebshop.com** met de URL van je webshop.)

5. Verwijder het bestand **cardgate_install.php** uit de **root map** van je webshop.

## Configuratie

1. Login op het **admin** gedeelte van je webshop.

2. Kies voor **Betaalmethoden** in het **Administratie** menu.

3. Klik op de **Betaalmethode toevoegen** knop.

4. Eerst moet de **CardGate Generic** betaalmethode ingesteld worden. In deze betaalmethode zitten de instellingen voor alle CardGate betaalmethoden.

5. Vul de naam in van de Algemene betaalmethode en kies de **CardGate Generic** betaalmethode uit het **Verwerkingseenheid** menu.

6. Zorg ervoor dat deze betaalmethode **niet** op **Actief** staat, zodat hij niet zichtbaar is in de checkout.

7. Kies dan voor de **Configureren** tab.

8. Vul de **site ID** en de **hash key** in, deze kun je vinden bij **Sites** op [Mijn CardGate](https://my.cardgate.com/).

9. Vul de **merchant ID** en de **API key** in die je van CardGate hebt ontvangen.

10. Stel de Testmode in op **Test** voor een test transactie.

11. Vul de overige gegevens in en klik op de **Save** knop.

12. **Let Wel:** Deze instellingen gelden voor **alle** CardGate betaalmethoden.  
 
13. Maak nu op dezelfde manier de **specifieke** CardGate betaalmethoden aan die je wilt gebruiken in je winkel.

14. De instellingen van de **Algemeen** tab gelden per **specifieke** betaalmethode.

15. Zorg ervoor dat je **na het testen** omschakelt van **Test Mode** naar **Live mode** in de **CardGate Generic** betaalmethode en sla het op (**Save**).

## Vereisten

Geen verdere vereisten.
