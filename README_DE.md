![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate Plug-in für CS.Cart

## Support

Dieses Plug-in ist geeignet für CS.Cart **4.4.x-4.7.x**

## Vorbereitung

Um dieses Modul zu verwenden sind Zugangsdate zur CardGate RESTful API notwendig.  
Gehen zu [My CardGate](https://my.cardgate.com/) und fragen Sie Ihre Zugangsdaten an, oder kontaktieren Sie Ihren Accountmanager.

## Installation

1. Downloaden und entpacken Sie den aktuellsten [Source Code](https://github.com/cardgate/cs-cart/releases/) auf Ihrem Desktop.

2. Uploaden Sie den **Inhalt** des **cardgate-Ordners** in den **Root-Ordner** Ihres Webshops.

3. Sorgen Sie dafür, dass der **Cache leer** ist. Eventuell müssen die Smarty Templates erneut kompiliert werden, bevor die Template-Anpassungen **sichtbar** sind.  
   Das machen Sie indem Sie den Parameter **ctpl** an Ihre admin URL hinzufügen.

4. Öffnen Sie die URL **http://mywebshop.com/cardgate_install.php** in Ihrem Browser,  wodurch das Plugin installiert wird.  
   (Ersetzen Sie **http://mywebshop.com/** durch die URL von Ihrem Webshop.)

5. Löschen Sie die Datei **cardgate_install.php** aus dem **Root-Ordner** Ihres Webshops.

## Configuration

1. Loggen Sie in den **Admin-Bereich** Ihres Webshops ein.

2. Wählen Sie **Zahlungsmittel** in dem **Administrations-Menü**.

3. Klicken Sie auf den **Zahlungsmittel hinzufügen** Button.

4. Zuerst muss das **CardGate Generic** Zahlungsmittel eingestellt werden. Dieses Zahlungsmittel enthält alle Einstellungen für alle CardGate Zahlungsmittel.

5. Füllen Sie den Namen des **CardGate Generic** Zahlungsmittels ein und wählen Sie das **CardGate Generic** Zahlungsmittel aus dem **Processor-Menü**.

6. Sorgen sie dafür, dass dieses Zahlungsmittel **nicht** auf **aktiv**  steht, sodass es nicht auf der Bezahlseite sichtbar wird.

7. Klicken Sie auf **konfigurieren**.

8. Füllen Sie die **Site ID** und **Hash key** ein. Diesen können unter **Sites** auf [My CardGate](https://my.cardgate.com/) finden.

9. Füllen Sie die **Merchant ID** und den **API key** ein, den Sie von CardGate empfangen haben.

10. Stellen Sie den Testmode ein unter **Test** für eine Test-Transaktion.

11. Füllen Sie den weiteren Daten ein und klicken sie auf **speichern**.

12. **Beachten Sie:** Die Einstellungen gelten für alle CardGate Zahlungsmittel.

13. Implementieren Sie auf gleiche Weise die **spezifischen** CardGate Zahlungsmittel die Sie in Ihrem Webshop verwenden möchten.

14. Die Einstellungen unter dem Tab **Allgemein**, gelten für die **spezifischen** Zahlungsmethoden.

15. Sorgen Sie dafür, dass Sie **nach dem Test** vom **Test Modus** in den **Live Modus** umschalten und klicken Sie auf **Speichern**.

## Anforderungen

Keine weiteren Anforderungen.
