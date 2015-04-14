# FabrikaNamjestajaAA
Stvarna fabrika za proizvodnju, prodaju i distribuciju namještaja. 

Spirala 2:
Nakon prelaska miša preko polja Ponuda u headeru pojavi se dropdown meni

Regexom je validiran e-mail

Ime i mail su validirani za slučaj praznog unosa nakon sklanjanja fokusa sa inputa.
Pojavljuje se blinkajući x sa strane gdje je tooltip-u od x-a poruka o grešci

Ako je aktiviran neki od x-ova, nije moguće unijeti poruku.

Nakon klika na submit button ponovo se vrši validacija i nije moguće poslati ako je prazna poruka ili ako je unos imena i maila neispravan.

Pošto je header i footer svakog html-a isti, oni su odvojeni u posebne fajlove i dinamički se dodaju sa jquery-om pri učitavanju stranice.