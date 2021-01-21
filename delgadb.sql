SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
AUTOCOMMIT = 0;
START TRANSACTION;
SET
time_zone = "+01:00";

--
-- Database: `delgatest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
                             `categorie_id` int(2) UNSIGNED NOT NULL,
                             `categorie_naam` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `categorie_naam`) VALUES
(1, 'Afwasmiddelen'),
(2, 'Allesreinigers'),
(3, 'Beschermingsproducten'),
(4, 'Dispensers'),
(5, 'Diversen'),
(6, 'Ontvetters'),
(7, 'Papierwaren'),
(8, 'Reinigingsproducten'),
(9, 'Sanitairreinigers'),
(10, 'Verzorgingsproducten'),
(11, 'Vloerreinigers'),
(12, 'Wasproducten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
                          `order_id` int(8) UNSIGNED NOT NULL,
                          `gebruiker_id` int(8) UNSIGNED NOT NULL,
                          `order_nr` varchar(50) NOT NULL,
                          `order_email` varchar(100) NOT NULL,
                          `order_voornaam` varchar(50) NOT NULL,
                          `order_achternaam` varchar(50) NOT NULL,
                          `order_adres` varchar(250) NOT NULL,
                          `order_adres_2` varchar(250) NOT NULL,
                          `totaal_prijs` decimal(7,2) NOT NULL,
                          `order_datum` datetime NOT NULL,
                          `opmerking` varchar(250) DEFAULT NULL,
                          `leveringsdatum` datetime DEFAULT NULL,
                          `order_status` char(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order_details`
--

CREATE TABLE `order_details` (
                                 `order_details_id` int(8) UNSIGNED NOT NULL,
                                 `order_nr` varchar(50) NOT NULL,
                                 `product_id` int(8) UNSIGNED NOT NULL,
                                 `product_prijs` decimal(7,2) NOT NULL,
                                 `product_aantal` int(2) NOT NULL,
                                 `product_optie` varchar(250) DEFAULT NULL,
                                 `aantal_levering` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
                             `product_id` int(4) UNSIGNED NOT NULL,
                             `categorie_id` int(2) UNSIGNED NOT NULL,
                             `product_naam` varchar(60) NOT NULL,
                             `product_foto` varchar(60) DEFAULT NULL,
                             `product_info` varchar(600) NOT NULL,
                             `omschrijving` varchar(300) NOT NULL,
                             `verpakking` varchar(60) NOT NULL,
                             `waarschuwing` varchar(400) DEFAULT NULL,
                             `eenheidsprijs` decimal(7,2) NOT NULL,
                             `btw` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`product_id`, `categorie_id`, `product_naam`, `product_foto`, `product_info`, `omschrijving`, `verpakking`, `waarschuwing`, `eenheidsprijs`, `btw`) VALUES
(1, 12, 'Ariel Professional vloeibaar wasmiddel', 'ariel_hydractiv.jpg', 'Ariel concentraat wasmiddel heeft een goede krachtige werking voor zowel witte als gekleurde was.  Zeer doeltreffende werking bij hardnekkige vlekken zoals bloed, koffie, wijn,... zelfs bij lage temperaturen. <br>Zorgt ervoor dat uw was er héél mooi blijft uitzien, voorkomt vergrijzing en heeft een optimale bescherming. <br>Geschikt van 30° tot max. 95° <br> 1 bidon bevat 70 wasbeurten.', 'Ariel Professional Vloeibaar Wasmiddel - Regular 70 Wasbeurten<br> geschikt van 30° tot max 95°', '2 x 4,55 liter', '', '98.00', '21.00'),
(2, 12, 'Ariel Professional waspoeder', 'ariel_professional_waspoeder.jpg', 'Ariel Professional waspoeder zorgt bij iedere wasbeurt voor een stralende schone was. Geschikt voor witte als gekleurde was. <br>Uitstekende vlekkenverwijdering zelfs bij 30°<br> ca goed voor 150 wasbeurten.', 'Geschikt voor iedere soort textiel<br>ca 150 wasbeurten ', '1 zak 15 kg', 'Opletten : Gevaarlijk product. Neem de voorzorgsmaatregelen voor gebruik in acht.<br>H319 : Veroorzaakt ernstige oogirritatie.', '75.00', '21.00'),
(3, 12, 'Biotex blauw voorwas', 'biotex_blauw_voorwas_500gr.jpg', 'Biotex blauw voorwas maakt het gemakkelijker om zelfs zwaar vervuilde was weer heel stralend schoon te krijgen dankzij de speciale werking van enzymen. Volledig veilig voor uw kledij.', 'Tegen vuil en vlekken ', '500 gr', '', '0.00', '21.00'),
(4, 8, 'Borstelstelen', 'borstelstelen.jpg', 'Verschillende soorten borstelstelen in aluminium, hout, fiber of metaal – ook telescopische borstelstelen', '', '', '', '0.00', '21.00'),
(5, 1, 'Broxomatic', 'broxomatic_2kg.jpg', 'Broxomatic onthardingszout is onmisbaar tijdens het vaatwasproces. Het maakt het water zachter waardoor de werking van de vaatwasmiddel krachtiger wordt. Tevens voorkomt het kalkvlekken op de vaat en zorgt het voor betere droogresultaten', 'Onthardingszout voor de vaatwasmachine', '2,2 kg', '', '0.00', '21.00'),
(6, 12, 'Dash Professional vloeibaar wasmiddel', 'dash_vloeibaar_wasmiddel.jpg', 'Dash Professional vloeibaar wasmiddel verwijdert snel alle vuil en vlekken zelfs bij lage temperaturen en een korte wascyclus. <br>Geschikt voor al uw wit wasgoed behalve wol en zijde bij 20 tot 95°<br>\r\nca 85 wasbeurten', 'Snelle vuil- en vlekkenverwijdering bij temperaturen van 20° tot 95°<br>ca 85 wasbeurten', '3 x 5,25 liter', '', '135.00', '21.00'),
(7, 12, 'Dash Professional waspoeder', 'dash_professional_waspoeder.jpg', 'Dash Professional waspoeder zorgt voor een stralende was door zijn snelle vuil- en vlekkenverwijdering.<br>Aangenaam fris parfum<br>ca 150 wasbeurten', 'Stralende was, snelle vuil- en vlekkenverwijdering<br>ca 150 wasbeurten', '1 zak 15 kg', '', '75.00', '21.00'),
(8, 3, 'grilo 8800 industriële ontsmetting', 'desinfecterend_middel.jpg', 'Grilo 8800 is een desinfecterend middel met een bacteriële werking voor oppervlakken, apparatuur en materialen in verzorgingsinstellingen en voedingssector.', 'Desinfecterende reiniger voor voedingssector en instellingen', '1 bidon van 5 liter', '', '70.00', '21.00'),
(9, 3, 'Alcoholgel 500ml', 'desinfecterende_alcohol.jpg', 'Alcoholgel zorgt voor een snelle ontsmetting van de handen zonder het gebruik van water.<br>Toepassing: dosis gel op schone handen, wrijf de handen op elkaar ongeveer 30 seconden tot volledig droog is.\r\n', 'Ontsmettingsmiddel voor de handen ', '1 flacon van 500ml', '', '0.00', '21.00'),
(10, 4, 'Dispenser blauw', 'dispensers_blauw.jpg', '', '', '', '', '0.00', '21.00'),
(11, 12, 'Dreft Professional vloeibaar wasmiddel', 'dreft.jpg', 'Dit vloeibaar wasmiddel verwijdert 83 wasbeurten lang alle soorten vlekken. <br>Het is geschikt voor wassen op zowel 30°, 40° en 60° alsook voor delicate stoffen<br>Wordt verkocht per karton van 2 bidons', '83 wasbeurten - 30° 40° 60°\r\n', '2 x 4,55 liter', '', '130.00', '21.00'),
(12, 1, 'Dreft Professional afwasmiddel', 'dreft_professional_afwasmiddel.jpg', 'Dreft Professional afwasmiddel is geschikt voor algemeen gebruik. Het verwijdert zeer doeltreffend alle vetten, voedingsresten en geuren.<br>Het schuimt langdurig zodat het water minder vaak moet ververst worden.>br>Kan ook gebruikt worden voor de reiniging van onder meer ramen, spiegels, tafels, enz.<br> Dreft afwasmiddel is zuinig in gebruik en veilig voor de huid, dermatologisch getest.', 'Verwijdert doeltreffend alle vetten en etensresten<br>schuimt langdurig<br> veilig voor de huid, dermatologisch getest', '2 x 5 liter', '', '39.00', '21.00'),
(13, 12, 'Dreft Professional wasmiddel donker', 'dreft_professional_fine_lessive_donker.jpg', 'Geconcentreerd vloeibaar fijnwasmiddel voor kleurwas en donkere was. <br>Speciaal ontwikkelt voor behoud en bescherming van de kleur', 'Kleurwas of donker<br>44 wasbeurten', '4 x 2,7 liter', '', '65.00', '21.00'),
(14, 12, 'Dreft Professional fijnwas waspoeder', 'dreft_professional_fijnwasmiddel.png', 'Dreft Professional fijnwas waspoeder is een uitstekende kleurbeschermer. Die tevens helpt de frisheid van de kleuren te behouden. Wassen op 30°-40° en 60°<br>Bevat een gepatenteerde formule tegen pluizen en krimpen.<br>Ook geschikt voor gebruik bij wol en zijde.<br>1 doos bevat 77 wasbeurten', 'Uitstekende kleurbeschermer voor 30°-40°-60° <br>geschikt voor wol en zijde <br> 77 wasbeurten', '1 doos = 7,5 kg', '', '65.00', '21.00'),
(15, 1, 'Dreft Platium all-in one vaatwastabletten', 'platinum-all-in-one-vaatwastabletten-90-tabs.jpg', 'De Dreft Platium all-in one vaatwastabletten zorgen voor een hardnekkige reiniging waardoor hardnekkigste etensresten afbreken. <br>Dankzij de vloeibare bovenzijde van de tablet zorgt het voor de directe aanpak van olie en vet. Hierdoor krijgt U een schitterende vaat en een glanzende vaatwas achteraf.<br>met verpakking in vaatwasmachine, geen afval, gebruiksvriendelijk.', 'Hardnekkige, schitterende en glanzende reiniging dankzij unieke formule<br>gebruiksvriendelijk', '90 + 90 tabletten gratis (tijdelijke actie)', 'uit de buurt van kinderen bewaren!', '60.00', '21.00'),
(16, 10, 'Dreumex handzeep', 'dreumex_handzeep.jpg', 'Dreumex handzeep is een handreiniger voor middel zware tot zware industriële vervuilingen zoals smeermiddel, diesel, remvloeistof, cement en roest.<br>Bijzonder geschikt voor gebruik in de automobiel, landbouw, metaalindustrie en dergelijke.<br>Huidvriendelijke korrel voor extra reinigingskracht', 'Industriële krachtige handreiniger<br>pompje inbegrepen bij de verpakking', '1 bidon van 4,5 liter', '', '0.00', '21.00'),
(17, 8, 'Assortiment dweilen', 'dweilen.jpg', '', '', '', '', '3.00', '21.00'),
(18, 11, 'Bleekwater / eau de javel', 'eau_de_javel.jpg', 'Bleekwater / eau de javel wordt in verschillende sectoren gebruikt dankzij de vlekverwijderende, witmakende, ontsmettende en ontgeurende werking. Maakt elke ondergrond met vlekken terug wit', 'Zuivert, verbleekt en ontvlekt diverse oppervlakken<br>beschikbaar in 15° en 30° actief Chloor', '4 x 1 bidon van 5 liter', '', '16.00', '21.00'),
(19, 2, 'Industriereiniger', '', 'Industriereiniger is onze krachtige allesreiniger, is sterk geconcentreerd en dient voor het afwassen van allerhande oppervlakten.<br>Verwijdert zonder moeite teer en andere vuile vlekken op vloeren.<br>Zeer goed geschikt voor garages en werkplaatsen.', 'Krachtige allesreiniger voor het afwassen van allerhande oppervlakken', '1 bidon van 10 liter', '', '50.00', '0.00'),
(20, 8, 'Emmers', 'emmers.jpg', '', '', '', '', '0.00', '21.00'),
(21, 5, 'Gel fresh luchtverfrisser', 'gel_fresh.jpg', 'Gel Fresh is een frissende, lekker ruikende luchtverfrisser.<br>Gemakkelijk bruikbaar, handig formaat<br>Verschillende geuren verkrijgbaar:\r\n<table>\r\n<tr><td>- meiklokjes</td><td>(wit)</td><td>- forest</td><td>(groen)</td></tr>\r\n<tr><td>- lila bloemengeur</td><td>(paars)</td><td>- citroen</td><td>(licht geel)</td></tr>\r\n<tr><td>- vanille</td><td>(donker geel)</td><td>- jasmijn</td><td>(licht groen)</td></tr>\r\n<tr><td>- marine</td><td>(licht blauw)</td><td>- lavendel</td><td>(roze)</td></tr>\r\n</table>', 'Zorg voor aangename geur in verschillende sanitaire ruimtes.<br>Verschillende geuren beschikbaar', '150 ml', '', '0.00', '21.00'),
(22, 7, 'Gevouwen handpapier', 'gevouwen_handpapier.jpg', '', '', '', '', '0.00', '21.00'),
(23, 1, 'Glansspoelmiddel DM50R', 'glansspoelmiddel0.jpg', 'Glansspoelmiddel DM50R zorgt voor een professionele werking in de vaatwasmachines. Voorkomt afzetting van kalk en maakt de vaat stralend en perfect schoon zonder strepen.<br>Is uitstekend geschikt voor zwel horeca als huishoudelijk gebruik.<br>Kan gebruikt worden in alle soorten afwasmachines.', 'Voorkomt kalk en zorgt voor mooie vaat zonder strepen', '1 bidon van 5 liter', '', '45.00', '21.00'),
(24, 8, 'Handborstels met steel', 'handborstels_met_steel.jpg', '', '', '', '', '0.00', '21.00'),
(25, 7, 'Handpapier 1 laag grijs', 'handpapier_1_laag_grijs.jpg', '', '', '', '', '0.00', '21.00'),
(26, 7, 'Handpapier 1 laag wit', 'handpapier_1_laag_wit.jpg', '', '', '', '', '0.00', '21.00'),
(27, 7, 'Handpapier 1 laag celstof wit', 'handpapier_1_laags_celstof_wit.jpg', '', '', '', '', '0.00', '21.00'),
(28, 7, 'Handpapier 2 laags wit', 'handpapier_2_laags_wit.jpg', '', '', '', '', '0.00', '21.00'),
(29, 10, 'Handwascreme', 'handwascreme.jpg', 'handwascreme is een hygienische en verzorgende handreiniger.  Zorgt voor superzachte handen dankzij de glycerine die erin is verwerkt', 'Verzorgende handreiniger<br>Verkrijgbaar in 1 liter (500 wasbeurten) en 5 liter (5000 wasbeurten)', '1 bidon van 5 liter', '', '45.00', '21.00'),
(30, 8, 'Hygiënische borstels', 'hygiënische_borstels.jpg', '', '', '', '', '0.00', '21.00'),
(31, 8, 'Hygiënische trekkers', 'hygienische_trekkers.jpg', '', '', '', '', '0.00', '21.00'),
(32, 9, 'Javel tabletten', 'javeltabletten.jpg', 'Javel tabletten zijn geschikt voor verschillende doeleinden. Zoals reinigen, ontgeuren, ontsmetten van toiletten, vloeren, sanitair,...<br>Gemakkelijk te doseren', 'Reinigt, ontgeurt en ontsmet', '6 x 600 gram', '', '75.00', '21.00'),
(33, 7, 'Keukenpapier', 'keukenpapier_32_rollen.jpg', '', '', '', '', '0.00', '21.00'),
(34, 8, 'Krasvrije schuurspons', 'krasvrije_schuurspons.jpg', '', '', '', '', '0.00', '21.00'),
(35, 12, 'Lenor Professional geconcentreerd wasverzachter lentefris', 'lenor_professional_wasverzachter.jpg', 'Lenor Professional wasverzachter lentefris geeft uw wasgoed een extra luchtigheid, frisgevoel en een heerlijke geur. <br>Maakt strijken gemakkelijker <br> ca 200 wasbeurten<br>Geconcentreerd hiermee bedoelen we dat 5 liter gelijk is aan 20 liter', 'Fris en heerlijk reukend<br>ca 200 wasbeurten per bidon', '3 x 5 liter', '', '60.00', '21.00'),
(36, 8, 'Loda soda kristallen', 'loda_sodakristallen.jpg', 'Gebruik Loda soda kristallen om 100% natuurlijk te reinigen, ontvetten, ontkalken en om vlekken uit textiel te verwijderen.  ', 'Reinigt, ontvet, ontkalkt en ontvlekt', '1 doos = 6 zakken van 2kg', '', '0.00', '21.00'),
(37, 3, 'Mondmaskers', 'mondmaskers.jpg', '3 laags medisch gezichtsmasker. De elastische lussen passen gemakkelijk over de oren voor een goede pasvorm.<br>Verschillende kleuren beschikbaar: blauw, zwart, roze, geel<br>CE goedgekeurd', '3 laags medisch voor bescherming. Verschillende kleuren beschikbaar.<br>CE goedgekeurd', '1 doos van 50 stuks', '', '0.00', '21.00'),
(38, 3, 'mosa ontsmetting ', 'mosa_ontsmettingsproduct.jpg', 'Mosa ontsmetting is een ontsmettingsproduct met een erkenningsnummer.<br>Kan gebruikt worden voor het reinigen en desinfecteren van voedingsbedrijven, horeca, grootkeukens, rusthuizen, ziekenhuizen,...', 'Ontsmettingsproduct met erkenningsnummer.', '1 bidon van 5 liter', '', '0.00', '21.00'),
(39, 2, 'Mr Proper Professional allesreiniger oceaanfris', 'mr_proper_professional_allesreiniger.jpg', 'Mr. Proper Professional allesreiniger oceaanfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', '21.00'),
(40, 2, 'Mr Proper spray anti-bacterieel', 'mr_Proper_spray_anti_bacterieel.jpg', 'Mr. Proper spray anti-bacterieel is een multi oppervlaktenreiniger. Is geschikt voor dagelijks reinigen en ontsmetten van diverse oppervlakten.<br>Met de alles reinigende spray geniet je van de kracht van 3 producten in 1:<br>-maakt alles grondig proper<br>-desinfecteert, doodt 99,9% van bacteriën<br>-streep-vrije glans bij vensters, spiegels, tafelbladen, enz.', 'Multi oppervlaktenreiniger met desinfecterende werking', '1 flacon van 750 ml', '', '0.00', '21.00'),
(41, 2, 'Reukwegnemer geparfumeerd', 'ontgeurder_desodorisant.jpg', 'Met zijn zacht en aangenaam parfum ontgeurt en verfrist dit product onmiddellijk onder meer toiletten, urinoirs, burelen,  ziekenkamers, vergaderlokalen, vuilnisemmers, zwembaden, enz. <br>Zeer geschikt voor viswerkende bedrijven en landbouwbedrijven<br>Goed schudden bij elk gebruik<br>Enkel wel te vrijwaren tegen de koude', 'Ontgeurt en verfrist alles', '1 bidon van 5 liter', '', '28.00', '21.00'),
(42, 3, 'Ontsmettingspaal met sensor', 'ontsmettingspaal_met_sensor.jpg', 'Ontsmettingspaal met sensor zorgt voor propere en veilige ontsmetting van de handen zonder aanraking.<br>Gewoon handen eronder houden en u krijgt een dosis ontsmetting in de handen.<br>Ontsmettingsmiddel voor hierin kunt U ook bij ons verkrijgen.', 'Zorgt voor ontsmetting zonder aanraking', '1 stuk', '', '0.00', '21.00'),
(43, 9, 'Grilo ontstopper', 'ontstopper_deboucheur.jpg', 'Grilo ontstopper is een krachtige ontstopper te gebruiken voor toiletten, wastafels, afvoerbuizen en riolen<br>Vernietigt snel alle organische stoffen.  Verwijdert roest en kalkaanslag.<br>Verhindert de werking van de septische putten niet.<br>Ontdooit tevens bevroren afvoerleidingen.', 'Krachtige industriële ontstopper', '1 flacon van 1 liter', '', '18.00', '21.00'),
(44, 6, 'Grilo ontvetter', 'ontvetter_degraissant.jpg', 'Grilo ontvetter is een industriële ontvetter voor grootkeukens en grootindustrie<br>Reinigt en ontvet onder meer dampkappen, keukenmateriaal, vloeren,...<br>Speciaal ontwikkeld voor machinale reiniging met of zonder hoge druk', 'Reinigen en ontvetten van grootkeukens en grootindustrie', '1 bidon van 5 liter', '', '0.00', '21.00'),
(45, 3, 'Reinigingsdoekjes met alcohol 75%', 'reiniginsdoekjes_met_75_alcohol.jpg', 'Reinigingsdoekjes met alcohol 75% zijn perfect geschikt voor het reinigen en bacterie vrij maken van handen, deurknoppen, sturen, (kantoor) meubilair en tal van andere alcoholbestendige oppervlakten.<br>Zitten in een handige dispenserzak met afsluitklep.  Deze bevatten 80 doekjes.<br>1 doekje bevat 75% alcohol\r\n', 'Antibacteriële vochtige doekjes in handige dispenserzak met afsluitklep<br>1pakje bevat 80 doekjes', '1 pakje = 80 doekjes', '', '0.00', '21.00'),
(46, 3, 'Reinigingsspray covid 19 PT2', 'Reiniginsspray_ontsmettend.jpg', 'Reinigingsspray Covid 19 PT2 is een ontsmettingsmiddel ter bestrijding van bacteriën, virussen, gisten, en schimmels (PT2) in het kader van de bestrijding tegen de verdere verspreiding van Covid.<br>Bestemd voor versnelde reiniging in voedingssector, zorgsector, ziekenhuizen.', 'Reinigings- en ontsmettingsmiddel<br>Bestemd voor versnelde reiniging en ontsmetting in voedingssector, zorgsector en ziekenhuizen', '1 flacon van 1 liter', '', '0.00', '21.00'),
(47, 9, 'Sanitair reiniger Rap en Rein', 'sanitair_reiniger_nettoyant-sanitaire.jpg', 'De Sanitair reiniger Rap en Rein verwijderd moeiteloos hardnekkige kalkaanslag en geeft een schitterende glans. <br>Verstuiver voor op de flessen krijg je erbij.', 'Industriële ontkalker voor sanitair', '6 x 1 flacon van 1 liter', '', '65.00', '21.00'),
(48, 8, 'Schuurborstels', 'schuurborstels.jpg', '', '', '', '', '0.00', '21.00'),
(49, 7, 'Servetten', 'servetten.jpg', '', '', '5000 stuks', '', '50.00', '21.00'),
(50, 8, 'Straatveger', 'straatveger.jpg', '', '', '', '', '0.00', '21.00'),
(51, 2, 'Grilo Des Antimos', 'tegen_groene_aanslag_contre_depots_verts.jpg', 'Grilo Des Antimos is een product voor verwijdering en voorkoming van groene aanslag op onder meer muren, daken, tuinmeubelen.<br>Grondig bespuiten, begieten of borstelen met een oplossing van 5% grilo, hoeft niet nagespoeld te worden', 'Verwijdering en voorkoming van groene aanslag', '1 bidon van 5 liter', '', '75.00', '21.00'),
(52, 8, 'Toiletborstel', 'toiletborstel.jpg', '', '', '', '', '0.00', '21.00'),
(53, 7, 'Toiletpapier 42 rollen', 'toiletpapier_42_rollen.jpg', '', '', '', '', '0.00', '21.00'),
(54, 7, 'Toiletpapier 48 rollen', 'toiletpapier_48_rollen.jpg', '', '', '', '', '28.00', '21.00'),
(55, 7, 'Toiletpapier coreless', 'toiletpapier_coreless.jpg', '', '', '', '', '0.00', '21.00'),
(56, 7, 'Tork facial tissues', 'tork_facial_tissues.jpg', '', '', '', '', '0.00', '21.00'),
(57, 7, 'Tork toiletpapier', 'tork_toiletpapier_72_rollen.jpg', '', '', '', '', '65.00', '21.00'),
(58, 8, 'Vaatdoeken', 'vaatdoeken.jpg', '', '', '', '', '15.00', '21.00'),
(59, 8, 'Vuilzakken', 'vuilzakken.jpg', '', '', '', '', '0.00', '21.00'),
(60, 1, 'Wash vaatwasmiddel', 'wash_vaatwasmiddel.jpg', 'Wash vaatwasmiddel is een vloeibaar reinigingsmiddel voor vaatwassers. Speciaal gemaakt voor zijn uitmuntende reiniging en werking in alle mogelijke watertypes.', 'Uitmuntende reinigingsmiddel voor vaatwassers', '1 bidon van 5 liter', '', '0.00', '21.00'),
(61, 12, 'Vloeibaar wasmiddel 2 in 1', 'wasmiddel_lessive.jpg', 'Vloeibaar wasmiddel 2 in 1 is een wasmiddel die uitermate geschikt is voor alle kleuren, wol, hand en witwas. Dit wasmiddel bevat actieve kalk behandeling en wasverzachter.<br>Bruikbaar bij 30° tem 90°', 'Actieve kalkbehandeling en wasverzachter<br>Geschikt voor 30° tot 90°', '4 x 3 liter', '', '60.00', '21.00'),
(62, 9, 'WC-cleaner', 'wc-cleaner.jpg', 'WC-cleaner verfrist, reinigt en heeft glans aan uw toiletten. Verwijdert kalk en roestaanslag<br>Tast het porselein, de buizen niet aan. Kan zeker geen kwaad voor septische buizen, wc\'s en urinoirs.', 'Reinigt en verfrist', '6 x 1 flacon van 750 ml', '', '49.00', '21.00'),
(63, 3, 'Wegwerphandschoenen', 'wegwerphandschoenen.jpg', '', '', '', '', '0.00', '21.00'),
(64, 4, 'Vileda Wrapmaster', 'wrapmaster_vileda.jpg', '', '', '', '', '0.00', '21.00'),
(65, 2, 'Mr Proper Professional allesreiniger citroenfris', 'mr_proper_allesreiniger_citroenfris_5_liter.jpg', 'Mr. Proper Professional allesreiniger citroenfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', '21.00'),
(66, 5, 'Handcreme glycerodermine', 'handcreme_glycerodermine.jpg', 'Handcrème glycerodermine hydrateert de huid en geeft geen vette sporen.  Dringt heel snel in de huid.<br>Helpt bij het voorkomen van kloven en droge huid.', 'Voorkomt kloven en droge huid', '1 tube 50ml', '', '16.00', '0.00'),
(67, 1, 'Afwasmiddel citroen ', '', 'Afwasmiddel citroen is een ideale ontvetter voor alle vaatwerk en onderhoud van spiegels.<br>Is zacht voor de handen en heeft een aangename geur', 'Super krachtige ontvetter voor een fijne afwas', 'flacon van 1 liter of bidon van 5 liter', '', '0.00', '0.00'),
(68, 12, 'Lenor Professional geconcentreerd wasverzachter zomerfris', 'wasverzachter_lenor_zomerfris.jpg', 'Lenor Professional wasverzachter zomerfris geeft uw wasgoed een extra luchtigheid, frisgevoel en een heerlijke geur. <br>Maakt strijken gemakkelijker <br> ca 200 wasbeurten<br>Geconcentreerd hiermee bedoelen we dat 5 liter gelijk is aan 20 liter', 'Fris en heerlijk reukend<br>ca 200 wasbeurten per bidon', '3 x 5 liter', '', '60.00', '0.00'),
(69, 12, 'Wolly wasmiddel', '', 'Wolly wasmiddel is een ideaal wasmiddel voor wol, fijne was, handwas en gordijnen.<br>Voorkomt pluisvorming en kan zowel voor hand als machine was gebruikt worden\r\n', 'Voor fijne was, wol, handwas en gordijnen', '1 flacon van 1 liter', '', '14.00', '0.00'),
(70, 1, 'Schuurcreme Piek citroen', 'schuurcreme_piek.jpg', 'Schuurcrème piek citroen is zeer doeltreffend voor horecazaken alsook voor huishoudelijk gebruik, dit omdat het een goede werking heeft bij het reinigen van potten en pannen. Tevens kan deze crème ook gebruikt worden voor het reinigen van uw keukens en inox oppervlakten.<br>De crème heeft een heerlijke citroengeur en kan het beste onverdund gebruikt worden met een vochtige doek of spons. Wanneer het middel zijn werk heeft gedaan wel even afspoelen.', 'Doeltreffende reiniging potten, pannen, keuken en inox oppervlakten', '12 x 1/2 liter ', '', '39.00', '0.00'),
(71, 1, 'Vaatdoek katoen ', 'vaatdoeken.jpg', 'Zeer praktische en handige vaatdoeken.<br>\r\nVervaardigd uit katoen, waardoor ze wasbaar zijn op 60°', 'Zeer handige vaatdoeken die wasbaar zijn op 60°', '10 stuks', '', '22.00', '0.00'),
(72, 5, 'Autowas', '', 'Autowas is zeer geschikt voor het reinigen van auto\'s, trucks, caravans, boten,...<br>Kan gebruikt worden met een hoge drukreiniger.<br>Dankzij de sterke werking van deze cleaner wordt alle statische vuil, teer en vet verwijderd. Laat geen sporten na van hard water.', 'Reiniging voor auto\'s, trucks, carvans, boten...<br>Geschikt voor gebruik met hoge drukreiniger.', '1 bidon van 2 liter', '', '0.00', '0.00'),
(73, 2, 'Zilverglans', '', 'Zilverglans is een product waarmee je allerlei vloeren kan dweilen en/of schuren.<br>Het heeft een aangename geur en doet uw vloer glanzen zonder sporen van voetstappen achter te laten.<br>Zeer geschikt voor moderne vloeren.', 'Reinigingsmiddel voorzien van aangename geur die geschikt is voor allerlei vloeren', '1 bidon van 5 liter', '', '28.00', '0.00'),
(74, 2, 'Vloerzeep groen', '', 'Vloerzeep groen zorgt voor de nodige onderhoud van uw vloeren.  Zorgt tevens voor een zeer aangename geur en een schitterende glans.<br>Geschikt voor alle vloeren.', 'Onderhoudsproduct voor vloeren', '1 bidon van 5 liter', '', '20.00', '0.00'),
(75, 10, 'badcreme', '', 'Deze badcrème zorgt voor een hele zachte huid, bevat onder meer nertsolie en koko\'s olie.<br>Uitstekend geschikt ook voor kinderen en baby\'s.', 'Verzorgende zeep voor een zachte huid.<br>Ook geschikt voor baby\'s en kinderen', '6 x 1 liter', '', '58.00', '0.00'),
(76, 2, 'Allesreiniger ammonia', '', 'Allesreiniger ammonie is zeer geschikt voor het reinigen van linoleum, tegels, houtwerk, lavabo\'s, badkuipen, toonbanken en alle andere afwasbare oppervlakten. Ook geschikt voor glaswerk, ruiten en spiegels.<br>Voor extra vuile plekken zoals teer, olie en vet mag dit product onverdund gebruikt worden.', 'Zeer goede reiniger voor tegels, lavabo\'s, houtwerk, spiegels,...', '1 bidon van 5 liter', '', '20.00', '0.00'),
(77, 2, 'Ovenreiniger', '', 'Deze reiniger lost probleemloos alle vetten op zoals bijvoorbeeld van ovens, machines, braadspitten.<br>Op koude oppervlakten werktijd ± 8 à 10 minuten laten inwerken, daarna met warm water grondig afspoelen.<br>Op warme oppervlakten 35 à 45 graden laten inwerken gedurende een 3 tal minuten en daarna grondig afspoelen met warm water.', 'Krachtige reiniger voor het probleemloos oplossen van alle vetten zoals bv van ovens, machines, braadspitten', '1 bidon van 5 liter', 'Handschoenen dragen bij gebruik van dit product', '40.00', '0.00'),
(78, 2, 'Ruitenreiniger', '', 'Onze ruitenreiniger is een reuk en smaakloos product, dat speciaal geschikt is voor horecabedrijven.<br>het ontvet, ontgeurt, ontsmet en geeft een mooie glans aan glazen, ruiten en spiegels\r\n', 'Krachtige reiniger, ontvetter, glansgever voor glazen, ruiten en spiegels, ideaal voor horecabedrijven.', '1 bidon van 5 liter', '', '28.00', '0.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_opties`
--

CREATE TABLE `product_opties` (
                                  `optie_id` int(4) NOT NULL,
                                  `optie_titel` varchar(255) NOT NULL,
                                  `optie_naam` varchar(255) NOT NULL,
                                  `eenheidsprijs` decimal(7,2) NOT NULL,
                                  `product_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `product_opties`
--

INSERT INTO `product_opties` (`optie_id`, `optie_titel`, `optie_naam`, `eenheidsprijs`, `product_id`) VALUES
(1, 'Soort', 'Aluminium', '0.00', 4),
(2, 'Soort', 'Hout', '0.00', 4),
(3, 'Soort', 'Fiber', '0.00', 4),
(4, 'Soort', 'Metaal', '0.00', 4),
(5, 'Soort', 'Telescopisch', '0.00', 4),
(6, 'Soort', 'Microvezel', '10.00', 17),
(7, 'Soort', 'Katoen', '3.00', 17),
(9, 'Soort', 'Anker', '0.00', 48),
(10, 'Soort', 'Linea', '0.00', 48),
(11, 'Soort', 'PVC', '0.00', 50),
(12, 'Soort', 'Bazine afrique', '0.00', 50),
(13, 'Soort', 'Bahia pur', '0.00', 50),
(14, 'Soort', 'Synthetisch', '15.00', 58),
(15, 'Soort', 'Katoen', '22.00', 58);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
                         `user_id` int(8) UNSIGNED NOT NULL,
                         `voornaam` varchar(50) NOT NULL,
                         `achternaam` varchar(50) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `wachtwoord` varchar(255) NOT NULL,
                         `registratie_datum` datetime NOT NULL,
                         `adres_straat` varchar(80) NOT NULL,
                         `adres_nr` varchar(20) NOT NULL,
                         `adres_postcode` char(4) NOT NULL,
                         `adres_plaats` varchar(50) NOT NULL,
                         `adres_straat_2` varchar(80) NOT NULL,
                         `adres_nr_2` varchar(20) NOT NULL,
                         `adres_postcode_2` char(4) NOT NULL,
                         `adres_plaats_2` varchar(50) NOT NULL,
                         `telefoon_nr` char(15) DEFAULT '',
                         `bedrijfsnaam` varchar(50) DEFAULT '',
                         `btw_nr` char(20) DEFAULT '',
                         `user_level` enum('Prive','Bedrijf','Admin') NOT NULL DEFAULT 'Prive',
                         `activatie_code` varchar(50) NOT NULL DEFAULT '',
                         `terugkeer_code` varchar(255) DEFAULT '',
                         `reset_code` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `voornaam`, `achternaam`, `email`, `wachtwoord`, `registratie_datum`, `adres_straat`, `adres_nr`, `adres_postcode`, `adres_plaats`, `adres_straat_2`, `adres_nr_2`, `adres_postcode_2`, `adres_plaats_2`, `telefoon_nr`, `bedrijfsnaam`, `btw_nr`, `user_level`, `activatie_code`, `terugkeer_code`, `reset_code`) VALUES
(1, 'Bart', 'Leers', 'bart@leers.pro', '$2y$10$B6tYxS6LVvbeNo6FWRLbpOPzRJwOc2FLxYxHgQ4BRuYj8Q00fbzlS', '2020-11-25 12:00:00', 'Holstraat', '29/1', '8790', 'Waregem', '', '', '', '', '0494300380', '', '', 'Admin', '', '', ''),
(2, 'Test', 'Delga', 'test@delga.be', '$2y$10$1/NmTZ10uqfoaDotJmiaIu6k0I99pcdAatZgFqmNzn/sgsYgXkHrq', '2020-12-08 18:00:00', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '', '', '', '', '0494300380', '', '', 'Prive', 'activated', NULL, ''),
(3, 'Bart', 'Leers', 'info@leers.pro', '$2y$10$/R2b3niWW8P0tLT8leQ/f.cYmFq0z/JUFdZCxAjo8Y9dVoJDP76Zi', '2020-12-10 11:53:00', 'Holstraat', '29/1', '8790', 'Waregem', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '0494300380', NULL, NULL, 'Admin', 'activated', '', ''),
(4, 'Lydia', 'Delhaye', 'lydia.delhaye@telenet.be', '$2y$10$ZfRI9FWQyRs3VGNJIlCfxezyjgQd2tk0laq/g6kr.J84USKDiKkBu', '2020-12-10 11:54:20', 'Holstraat', '29/1', '8790', 'Waregem', '', '', '', '', '0497433265', '', '', 'Admin', 'activated', NULL, ''),
(5, 'Test', 'Delga', 'test@delga.be', '$2y$10$Okz7P0L.29ZkqiIn3xAUDOLANJY64/dpfRqy9dj6US.IqOiaN/Z4C', '2020-12-11 01:45:06', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '', '', '', '', '0123/123456', '', '', 'Prive', 'activated', NULL, '');
--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
    ADD PRIMARY KEY (`categorie_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`order_id`),
    ADD KEY `gebruiker_id` (`gebruiker_id`,`order_datum`);

--
-- Indexen voor tabel `order_details`
--
ALTER TABLE `order_details`
    ADD PRIMARY KEY (`order_details_id`),
    ADD KEY `product_id` (`product_id`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
    ADD PRIMARY KEY (`product_id`),
    ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `product_opties`
--
ALTER TABLE `product_opties`
    ADD PRIMARY KEY (`optie_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
    MODIFY `categorie_id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
    MODIFY `order_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `order_details`
--
ALTER TABLE `order_details`
    MODIFY `order_details_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
    MODIFY `product_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT voor een tabel `product_opties`
--
ALTER TABLE `product_opties`
    MODIFY `optie_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;
