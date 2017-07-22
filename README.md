# Kundenrufsystem
Kundenrufsystem für Dorffeste

Wir hatten den Wunsch, unseren Gästen die Möglichkeit zu geben, nicht schlange stehen zu müssen.
Also muste ein Kundenrufsystem herbei, ähnlich dem wie man es vom großen goldenen M (McDonalds) kennt.
Eine bestellung wird registriert und in einer Datenbank gespeichert. Wenn die Speißen der Bestellung fertig
angerichtet sind und für den Kunden zur Abholung bereit sind, erscheint die Bestellnummer auf einem großen Fernseher.
Hat der Kunden die Bestellung abgeholt, wird sie vom Thekenpersonal aus dem system genommen und verschwindet vom
Fernseher.

## Systemanforderungen
* mysql/mariaDB
* Webserver mit mindestens PHP 5.6
* JavaScript fähiger Browser
* (optional) Touchscreen für die Essensausgabe
* (optional) Fernseher für die Anzeige
* (optional) Extra Nummernblock für die Eingabe

## Setup
1. Datenbank Server aufsetzen
2. Datenbank mit hilfe der 'krs.sql' Datei erstellen
3. Webserver aufsetzen
4. Inhalt Kundenrufsystem Hauptverzeichnisses komplett in den htdocs Ordner des Webservers kopieren
5. Datenbank Zugangsdaten in die 'conf/db.conf.php' datei eintragen
6. Auf allen Geräten den Webserver aufrufen
7. Die, dem Gerät, entsprechende Rolle anklicken
8. Fertig

Achtung: Sollte das Kundenrufsystem auf einem Webserver installiert sein, der nicht direkt über eine IP erreichbar ist 
sondern nur über eine Domain, dann muss die Datei 'js/serverIPAsJS.php' wie folgt aussehen:
```
$(document).ready(function(){
    server = 'example.com'
});

``` 
Wobei example.com natürlich dann durch eure Domain ersetzt werden muss.

## Sicherheit
Die Anwendung beinhaltet keinerlei Sicherheitsmechanismen. Es wird dringen empfohlen diese nicht an das Internet 
anzubinden. Am besten läst man sie in einem eigens abgeschotteten LAN laufen (vlan).