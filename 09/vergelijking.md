In les 06 wordt alleen een naam onthouden. 
Die staat in een cookie in de browser en blijft daar 30 dagen staan. 
Er wordt geen wachtwoord gecontroleerd, dus dit is geen echte login.

In les 09 controleert de website het wachtwoord met de hash in de database. 
Na een geslaagde login bewaart de server de gebruiker in een sessie. 
De browser krijgt alleen de sessie-ID.

Een sessie past beter bij de toepassing in les 09, omdat de server zo bijhoudt wie succesvol is ingelogd. 
Een losse cookie met een naam kan de gebruiker zelf aanpassen en bewijst niet wie diegene is. 