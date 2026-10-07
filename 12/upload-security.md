Ik controleer `$_FILES['bestand']['error']`, gebruik `is_uploaded_file()` om echte uploads te valideren, beperk toegestane extensies, controleer de bestandsgrootte, controleer mime met `finfo_file()` en `getimagesize()`. 
Daarnaast voorkom ik dubbele bestandsnamen en verplaats ik ze met `move_uploaded_file()`. 

Exta maatregelen zouden rekening kunnen houden met malware-scans, authenticatie en logging.
Ook ga ik momenteel uit van een correcte mime, terwijl deze ook nog nagemaakt kan zijn.
