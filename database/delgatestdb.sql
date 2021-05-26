-- phpMyAdmin SQL Dump
-- version 4.9.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 26 mei 2021 om 16:09
-- Serverversie: 10.3.24-MariaDB
-- PHP-versie: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
(4, 'Diversen'),
(5, 'Ontvetters'),
(6, 'Papierwaren'),
(7, 'Reinigingsproducten'),
(8, 'Sanitairreinigers'),
(9, 'Verzorgingsproducten'),
(10, 'Vloerreinigers'),
(11, 'Wasproducten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
                          `order_id` int(8) UNSIGNED NOT NULL,
                          `user_id` int(8) UNSIGNED NOT NULL,
                          `order_nr` varchar(50) NOT NULL,
                          `order_email` varchar(100) NOT NULL,
                          `order_naam` varchar(100) NOT NULL,
                          `order_adres` varchar(250) NOT NULL,
                          `order_adres_2` varchar(250) NOT NULL,
                          `totaal_prijs` decimal(7,2) NOT NULL,
                          `order_datum` datetime NOT NULL,
                          `opmerking` varchar(400) DEFAULT NULL,
                          `leveringsdatum` date DEFAULT NULL,
                          `order_status` enum('nieuw','uitvoering','afgewerkt','geannuleerd') NOT NULL DEFAULT 'nieuw'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_nr`, `order_email`, `order_naam`, `order_adres`, `order_adres_2`, `totaal_prijs`, `order_datum`, `opmerking`, `leveringsdatum`, `order_status`) VALUES
(1, 1, '2021-609E62B75E8967', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '81.00', '2021-05-14 13:44:55', '', '2021-05-17', 'afgewerkt'),
(2, 1, '2021-60A3DB02C21F79', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '96.00', '2021-05-18 17:19:30', '', '2021-05-24', 'afgewerkt'),
(3, 1, '2021-60A3E059354E33', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '41.00', '2021-05-18 17:42:17', '', '2021-05-21', 'afgewerkt'),
(4, 1, '2021-60A7B824090068', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '66.00', '2021-05-21 15:39:48', 'levering in namiddag', '2021-05-23', 'afgewerkt'),
(5, 1, '2021-60A7BA6A3458AF', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '11.00', '2021-05-21 15:49:30', 'Graag gedaan', '2021-05-23', 'afgewerkt'),
(6, 1, '2021-60A7C4843F74A4', 'bart@leers.pro', 'Bart Leers', 'Holstraat 29/1 - 8790 Waregem', 'Voorzienigheidsstraat 18 - 8500 Kortrijk', '22.00', '2021-05-21 16:32:36', 'Groeten Bart', '2021-05-24', 'afgewerkt');

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
                                 `levering_aantal` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_nr`, `product_id`, `product_prijs`, `product_aantal`, `product_optie`, `levering_aantal`) VALUES
(1, '2021-609E62B75E8967', 72, '75.00', 1, '', 1),
(2, '2021-60A3DB02C21F79', 20, '45.00', 2, '', 2),
(3, '2021-60A3E059354E33', 18, '15.00', 1, 'Soort - vanille', 1),
(4, '2021-60A3E059354E33', 18, '15.00', 1, 'Soort - citroen', 1),
(5, '2021-60A3E059354E33', 54, '5.00', 1, 'Verpakking - 1 liter', 1),
(6, '2021-60A7B824090068', 52, '60.00', 1, '', 1),
(7, '2021-60A7BA6A3458AF', 54, '5.00', 1, 'Verpakking - 1 liter', 1),
(8, '2021-60A7C4843F74A4', 24, '8.00', 2, 'Verpakking - 500 ml', 2);

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
                             `btw` tinyint(2) NOT NULL,
                             `product_level` enum('actief','niet-actief') NOT NULL DEFAULT 'niet-actief'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`product_id`, `categorie_id`, `product_naam`, `product_foto`, `product_info`, `omschrijving`, `verpakking`, `waarschuwing`, `eenheidsprijs`, `btw`, `product_level`) VALUES
(1, 11, 'Ariel Professional vloeibaar wasmiddel', 'ariel_hydractiv.jpg', 'Ariel concentraat wasmiddel heeft een goede krachtige werking voor zowel witte als gekleurde was.  Zeer doeltreffende werking bij hardnekkige vlekken zoals bloed, koffie, wijn,... zelfs bij lage temperaturen. <br>Zorgt ervoor dat uw was er héél mooi blijft uitzien, voorkomt vergrijzing en heeft een optimale bescherming. Geschikt van 30° tot max. 95° <br>1 bidon is goed voor 70 wasbeurten.', 'Ariel Professional Vloeibaar Wasmiddel - Regular 70 wasbeurten <br>Geschikt van 30° tot max 95°', '2 x 3,85 liter', '', '98.00', 21, 'actief'),
(2, 11, 'Ariel Professional waspoeder', 'ariel_professional_waspoeder.jpg', 'Ariel Professional waspoeder zorgt bij iedere wasbeurt voor een stralende schone was. Geschikt voor witte als gekleurde was. <br>Uitstekende vlekkenverwijdering zelfs bij 30°<br> ca goed voor 150 wasbeurten.', 'Geschikt voor iedere soort textiel<br>ca 150 wasbeurten ', '1 zak 15 kg', 'Opletten : Gevaarlijk product. Neem de voorzorgsmaatregelen voor gebruik in acht.<br>H319 : Veroorzaakt ernstige oogirritatie.', '75.00', 21, 'actief'),
(3, 11, 'Biotex blauw voorwas', 'biotex_blauw_voorwas_500gr.jpg', 'Biotex blauw voorwas maakt het gemakkelijker om zelfs zwaar vervuilde was weer heel stralend schoon te krijgen dankzij de speciale werking van enzymen. Volledig veilig voor uw kledij.', 'Tegen vuil en vlekken ', '1 doos 500 gr', '', '7.00', 21, 'actief'),
(4, 1, 'Broxomatic', 'broxomatic_2kg.jpg', 'Broxomatic onthardingszout is onmisbaar tijdens het vaatwasproces. Het maakt het water zachter waardoor de werking van de vaatwasmiddel krachtiger wordt.<br>Tevens voorkomt het kalkvlekken op de vaat en zorgt het voor betere droogresultaten.', 'Onthardingszout voor de vaatwasmachine', '1 pak 2,2 kg', '', '15.00', 21, 'actief'),
(5, 11, 'Dash Professional vloeibaar wasmiddel', 'dash_vloeibaar_wasmiddel.jpg', 'Dash Professional vloeibaar wasmiddel verwijdert snel alle vuil en vlekken zelfs bij lage temperaturen en een korte wascyclus. <br>Geschikt voor al uw wit wasgoed behalve wol en zijde bij 20° tot 95°<br>\r\nca 85 wasbeurten.', 'Snelle vuil- en vlekkenverwijdering bij temperaturen van 20° tot 95°<br>ca 85 wasbeurten per bidon', '3 x 1 bidon van ca 85 wasbeurten', '', '135.00', 21, 'actief'),
(6, 11, 'Dash Professional waspoeder', 'dash_professional_waspoeder.jpg', 'Dash Professional waspoeder zorgt voor een stralende was door zijn snelle vuil- en vlekkenverwijdering.<br>Aangenaam fris parfum.<br>ca 150 wasbeurten', 'Stralende was, snelle vuil- en vlekkenverwijdering<br>ca 150 wasbeurten', '1 zak 15 kg', '', '75.00', 21, 'actief'),
(7, 3, 'grilo 8800 industriële ontsmetting', 'desinfecterend_middel.jpg', 'Grilo 8800 is een desinfecterend middel met een bacteriële werking voor oppervlakken, apparatuur en materialen in verzorgingsinstellingen en voedingssector.', 'Desinfecterende reiniger voor voedingssector en instellingen', '1 bidon van 5 liter', '', '70.00', 21, 'actief'),
(8, 3, 'Alcoholgel 500 ml', 'desinfecterende_alcohol.jpg', 'Alcoholgel zorgt voor een snelle ontsmetting van de handen zonder het gebruik van water.<br>Toepassing: dosis gel op schone handen, wrijf de handen op elkaar ongeveer 30 seconden tot volledig droog is.\r\n', 'Ontsmettingsmiddel voor de handen ', '1 flacon van 500 ml', '', '9.50', 21, 'actief'),
(9, 11, 'Dreft Professional vloeibaar wasmiddel', 'dreft.jpg', 'Dit vloeibaar wasmiddel verwijdert 83 wasbeurten lang alle soorten vlekken. <br>Het is geschikt voor wassen op zowel 30°, 40° en 60° alsook voor delicate stoffen.<br>Wordt verkocht per karton van 2 bidons.', '83 wasbeurten - 30° 40° 60°\r\n', '2 x 4,55 liter', '', '130.00', 21, 'actief'),
(10, 1, 'Dreft Professional afwasmiddel', 'dreft_professional_afwasmiddel.jpg', 'Dreft Professional afwasmiddel is geschikt voor algemeen gebruik. Het verwijdert zeer doeltreffend alle vetten, voedingsresten en geuren.<br>Het schuimt langdurig zodat het water minder vaak moet ververst worden.<br>Kan ook gebruikt worden voor de reiniging van onder meer ramen, spiegels, tafels, enz.<br> Dreft afwasmiddel is zuinig in gebruik en veilig voor de huid, dermatologisch getest.', 'Verwijdert doeltreffend alle vetten en etensresten<br>schuimt langdurig<br> veilig voor de huid, dermatologisch getest', '2 x 5 liter', '', '39.00', 21, 'actief'),
(11, 11, 'Dreft Professional wasmiddel donker', 'dreft_professional_fine_lessive_donker.jpg', 'Geconcentreerd vloeibaar fijnwasmiddel voor kleurwas en donkere was. <br>Speciaal ontwikkelt voor behoud en bescherming van de kleur.<br>ca 44 wasbeurten.', 'Kleurwas of donkere was<br>ca 44 wasbeurten', '4 x 2,7 liter', '', '65.00', 21, 'actief'),
(12, 11, 'Dreft Professional fijnwas waspoeder', 'dreft_professional_fijnwasmiddel.png', 'Dreft Professional fijnwas waspoeder is een uitstekende kleurbeschermer, die tevens helpt de frisheid van de kleuren te behouden. Wassen op 30°, 40° en 60°<br>Bevat een gepatenteerde formule tegen pluizen en krimpen.<br>Ook geschikt voor gebruik bij wol en zijde.<br>1 doos bevat ca 77 wasbeurten.', 'Uitstekende kleurbeschermer voor 30°-40°-60° <br>Geschikt voor wol en zijde<br>ca 77 wasbeurten', '1 doos = 7,5 kg', '', '65.00', 21, 'actief'),
(13, 1, 'Dreft Platium all-in one vaatwastabletten', 'platinum-all-in-one-vaatwastabletten-90-tabs.jpg', 'De Dreft Platium all-in one vaatwastabletten zorgen voor een hardnekkige reiniging waardoor de hardnekkigste etensresten afbreken.<br>Dankzij de vloeibare bovenzijde van de tablet zorgt het voor de directe aanpak van olie en vet. Hierdoor krijgt U een schitterende vaat en een glanzende vaatwas achteraf.<br>Met verpakking in vaatwasmachine, geen afval, gebruiksvriendelijk.', 'Hardnekkige, schitterende en glanzende reiniging dankzij unieke formule<br>Gebruiksvriendelijk', '90 + 90 tabletten gratis (tijdelijke actie)', 'Uit de buurt van kinderen bewaren!', '60.00', 21, 'actief'),
(14, 9, 'Dreumex handzeep', 'dreumex_handzeep.jpg', 'Dreumex handzeep is een handreiniger voor middel zware tot zware industriële vervuilingen zoals smeermiddel, diesel, remvloeistof, cement en roest.<br>Bijzonder geschikt voor gebruik in de automobiel, landbouw, metaalindustrie en dergelijke.<br>Huidvriendelijke korrel voor extra reinigingskracht.', 'Industriële krachtige handreiniger<br>Pompje inbegrepen bij de verpakking', '1 bidon van 4,5 liter', '', '0.00', 21, 'niet-actief'),
(15, 7, 'Assortiment dweilen', 'dweilen.jpg', '', '', '', '', '3.00', 21, 'niet-actief'),
(16, 10, 'Bleekwater / eau de javel', 'eau_de_javel.jpg', 'Bleekwater / eau de javel wordt in verschillende sectoren gebruikt dankzij de vlekverwijderende, witmakende, ontsmettende en ontgeurende werking. Maakt elke ondergrond met vlekken terug wit.', 'Zuivert, verbleekt en ontvlekt diverse oppervlakken<br>Beschikbaar in 15° en 30° actief Chloor', '4 x 1 bidon van 5 liter', '', '16.00', 21, 'actief'),
(17, 7, 'Emmer', 'emmers.jpg', 'Kunststof huishoudemmer dat geschikt is voor alle dagelijkse schoonmaak werkzaamheden, beschikt over handgrip.<br>Inhoud 10 liter, verschillende kleuren beschikbaar.', 'Emmer 10 liter', '1 stuk', '', '5.00', 21, 'actief'),
(18, 4, 'Gel fresh luchtverfrisser', 'gel_fresh.jpg', 'Gel Fresh is een frissende, lekker ruikende luchtverfrisser.<br>Gemakkelijk bruikbaar, handig formaat.<br>Verschillende geuren verkrijgbaar:\r\n<table>\r\n<tr><td>- meiklokjes</td><td>(wit)</td><td>- forest</td><td>(groen)</td></tr>\r\n<tr><td>- lila bloemengeur</td><td>(paars)</td><td>- citroen</td><td>(licht geel)</td></tr>\r\n<tr><td>- vanille</td><td>(donker geel)</td><td>- jasmijn</td><td>(licht groen)</td></tr>\r\n<tr><td>- marine</td><td>(licht blauw)</td><td>- lavendel</td><td>(roze)</td></tr>\r\n</table>', 'Zorg voor aangename geur in verschillende sanitaire ruimtes<br>Verschillende geuren beschikbaar', '1 verpakking van 8 stuks', '', '15.00', 21, 'actief'),
(19, 6, 'Gevouwen handpapier', 'handpapier_gevouwen.jpg', 'Gevouwen handpapier om hygiënisch uw handen te drogen.<br>Komen zigzagsgewijs uit de dispenser.<br>Goede kwaliteit en goede absorptie.<br>Verkrijgbaar in karton met 30 pakken.', 'Gevouwen handpapier, kan in dispenser gestoken worden en komt er zigzagsgewijs uit', '1 karton: 30 stuks', '', '48.00', 21, 'actief'),
(20, 1, 'Glansspoelmiddel DM50R', 'glansspoelmiddel0.jpg', 'Glansspoelmiddel DM50R zorgt voor een professionele werking in de vaatwasmachines. Voorkomt afzetting van kalk en maakt de vaat stralend en perfect schoon zonder strepen.<br>Is uitstekend geschikt voor zowel horeca als huishoudelijk gebruik.<br>Kan gebruikt worden in alle soorten afwasmachines.', 'Voorkomt kalk en zorgt voor mooie vaat zonder strepen', '1 bidon van 5 liter', '', '45.00', 21, 'actief'),
(21, 6, 'Handpapier 1 laags grijs', 'handpapier_1_laag_grijs.jpg', 'Deze poetsrollen bestaan uit 1 laag en zijn zacht en van gerecycled materiaal. Het heeft een goede absorptie vermogen hierdoor zijn deze uitstekend geschikt als poetspapier. Grijskleurig<br>1 rol bevat 300 meter papier<br>Dit handpapier is verkrijgbaar in pak van 6 rollen', 'Handpapier - 1 laags - grijs ', '1 pak van 6 rollen', '', '32.00', 21, 'actief'),
(22, 6, 'Handpapier 1 laags wit', 'handpapier_1_laags_celstof_wit.jpg', 'Hoogwaardig 1 laags wit poetspapier.  Deze bevat een hoog absorptievermogen.<br>1 rol bevat 120 meter papier, 100% cellulose<br>Verkrijgbaar in pak van 12 rollen', 'Handpapier - 1 laags wit - 100% cellulose', '1 pak van 12 rollen', '', '45.00', 21, 'actief'),
(23, 6, 'Handpapier 2 laags wit ', 'handpapier_2_laag_wit_celstof.jpg', 'Poetspapier gemaakt van stevig 2-laags papier. Hierdoor heeft het een groot absorptie vermogen en is het geschikt als schoonmaakpapier en voor gebruik in de keuken.<br>Wit kleurig. 100% cellulose. 1 rol bevat 160m papier<br>Verkrijgbaar in pak van 6 rollen', 'Handpapier - 2 laags - wit - 100% cellulose', '1 pak van 6 rollen ', '', '36.00', 21, 'actief'),
(24, 9, 'Handwascreme', 'handwascreme.jpg', 'Handwascreme is een hygiënische en verzorgende handreiniger. Zorgt voor superzachte handen dankzij de glycerine die erin is verwerkt.<Br>Verkrijgbaar in fles van 500 ml met pompje en/of in bidon van 5 liter.', 'Verzorgende handreiniger<br>Verkrijgbaar in 500ml met pompje of bidon van 5 liter', '1 flacon van 500 ml / 1 bidon van 5 liter ', '', '8.00', 21, 'actief'),
(25, 7, 'Hygiënische borstels', 'hygiënische_borstels.jpg', '', '', '', '', '0.00', 21, 'niet-actief'),
(26, 7, 'Hygiënische trekkers', 'hygienische_trekkers.jpg', '', '', '', '', '0.00', 21, 'niet-actief'),
(27, 8, 'Javel tabletten', 'javeltabletten.jpg', 'Javel tabletten zijn geschikt voor verschillende doeleinden. Zoals reinigen, ontgeuren, ontsmetten van toiletten, vloeren, sanitair,...<br>Gemakkelijk te doseren.', 'Reinigt, ontgeurt en ontsmet', '6 x 600 gram', '', '75.00', 21, 'actief'),
(28, 11, 'Lenor Professional geconcentreerd wasverzachter lentefris', 'lenor_professional_wasverzachter.jpg', 'Lenor Professional wasverzachter lentefris geeft uw wasgoed een extra luchtigheid, frisgevoel en een heerlijke geur.<br>Maakt strijken gemakkelijker, ca 200 wasbeurten.<br>Geconcentreerd hiermee bedoelen we dat 5 liter gelijk is aan 20 liter.', 'Fris en heerlijk reukende wasverzachter<br>ca 200 wasbeurten per bidon', '3 x 5 liter', '', '60.00', 21, 'actief'),
(29, 7, 'Loda soda kristallen', 'loda_sodakristallen.jpg', 'Gebruik Loda soda kristallen om 100% natuurlijk te reinigen, ontvetten, ontkalken en om vlekken uit textiel te verwijderen.  ', 'Reinigt, ontvet, ontkalkt en ontvlekt', '1 doos = 6 zakken van 2 kg', '', '20.00', 21, 'actief'),
(30, 3, 'Mondmaskers', 'mondmaskers.jpg', '3 laags medisch gezichtsmasker. De elastische lussen passen gemakkelijk over de oren voor een goede pasvorm.<br>Verschillende kleuren beschikbaar: blauw, zwart, roze, geel.<br>CE goedgekeurd.', '3 laags medisch voor bescherming. Verschillende kleuren beschikbaar.<br>CE goedgekeurd', '1 doos van 50 stuks', '', '30.00', 21, 'actief'),
(31, 3, 'mosa ontsmetting ', 'mosa_ontsmettingsproduct.jpg', 'Mosa ontsmetting is een ontsmettingsproduct met een erkenningsnummer.<br>Kan gebruikt worden voor het reinigen en desinfecteren van voedingsbedrijven, horeca, grootkeukens, rusthuizen, ziekenhuizen,...', 'Ontsmettingsproduct met erkenningsnummer.', '1 bidon van 5 liter', '', '50.00', 21, 'actief'),
(32, 2, 'Mr Proper Professional allesreiniger oceaanfris', 'mr_proper_professional_allesreiniger.jpg', 'Mr. Proper Professional allesreiniger oceaanfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur.', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', 21, 'actief'),
(33, 2, 'Mr Proper spray anti-bacterieel', 'mr_Proper_spray_anti_bacterieel.jpg', 'Mr. Proper spray anti-bacterieel is een multi oppervlaktenreiniger. Is geschikt voor dagelijks reinigen en ontsmetten van diverse oppervlakten.<br>Met de alles reinigende spray geniet je van de kracht van 3 producten in 1:<br>-maakt alles grondig proper<br>-desinfecteert, doodt 99,9% van bacteriën<br>-streep-vrije glans bij vensters, spiegels, tafelbladen, enz.', 'Multi oppervlaktenreiniger met desinfecterende werking', '6 x 750 ml', '', '48.00', 21, 'actief'),
(34, 2, 'Reukwegnemer geparfumeerd', 'ontgeurder_desodorisant.jpg', 'Met zijn zacht en aangenaam parfum ontgeurt en verfrist dit product onmiddellijk onder meer toiletten, urinoirs, burelen,  ziekenkamers, vergaderlokalen, vuilnisemmers, zwembaden, enz. <br>Zeer geschikt voor viswerkende bedrijven en landbouwbedrijven.<br>Goed schudden bij elk gebruik.<br>Enkel wel te vrijwaren tegen de koude.', 'Ontgeurt en verfrist alles', '1 bidon van 5 liter', '', '28.00', 21, 'actief'),
(35, 3, 'Ontsmettingspaal met sensor', 'ontsmettingspaal_met_sensor.jpg', 'Ontsmettingspaal met sensor zorgt voor propere en veilige ontsmetting van de handen zonder aanraking.<br>Gewoon handen eronder houden en u krijgt een dosis ontsmetting in de handen.<br>Ontsmettingsmiddel voor hierin kunt U ook bij ons verkrijgen.', 'Zorgt voor ontsmetting zonder aanraking', '1 stuk', '', '0.00', 21, 'niet-actief'),
(36, 8, 'Grilo ontstopper', 'ontstopper_deboucheur.jpg', 'Grilo ontstopper is een krachtige ontstopper te gebruiken voor toiletten, wastafels, afvoerbuizen en riolen.<br>Vernietigt snel alle organische stoffen. Verwijdert roest en kalkaanslag.<br>Verhindert de werking van de septische putten niet.<br>Ontdooit tevens bevroren afvoerleidingen.', 'Krachtige industriële ontstopper', '1 flacon van 1 liter', '', '18.00', 21, 'actief'),
(37, 5, 'Grilo ontvetter', 'ontvetter_degraissant.jpg', 'Grilo ontvetter is een industriële ontvetter voor grootkeukens en grootindustrie<br>Reinigt en ontvet onder meer dampkappen, keukenmateriaal, vloeren,...<br>Speciaal ontwikkeld voor machinale reiniging met of zonder hoge druk', 'Reinigen en ontvetten van grootkeukens en grootindustrie', '1 bidon van 5 liter', '', '30.00', 21, 'actief'),
(38, 3, 'Reinigingsdoekjes met alcohol 75%', 'reiniginsdoekjes_met_75_alcohol.jpg', 'Reinigingsdoekjes met alcohol 75% zijn perfect geschikt voor het reinigen en bacterie vrij maken van handen, deurknoppen, sturen, (kantoor) meubilair en tal van andere alcoholbestendige oppervlakten.<br>Zitten in een handige dispenserzak met afsluitklep.  Deze bevatten 80 doekjes.<br>1 doekje bevat 75% alcohol.\r\n', 'Antibacteriële vochtige doekjes in handige dispenserzak met afsluitklep<br>1pakje bevat 80 doekjes', '1 pak = 80 doekjes', '', '5.00', 21, 'actief'),
(39, 3, 'Reinigingsspray covid 19 PT2', 'Reiniginsspray_ontsmettend.jpg', 'Reinigingsspray Covid 19 PT2 is een ontsmettingsmiddel ter bestrijding van bacteriën, virussen, gisten, en schimmels (PT2) in het kader van de bestrijding tegen de verdere verspreiding van Covid.<br>Bestemd voor versnelde reiniging in voedingssector, zorgsector, ziekenhuizen.', 'Reinigings- en ontsmettingsmiddel<br>Bestemd voor versnelde reiniging en ontsmetting in voedingssector, zorgsector en ziekenhuizen', '1 flacon van 1 liter', '', '12.50', 21, 'actief'),
(40, 8, 'Sanitair reiniger Rap en Rein', 'sanitair_reiniger_nettoyant-sanitaire.jpg', 'De Sanitair reiniger Rap en Rein verwijderd moeiteloos hardnekkige kalkaanslag en geeft een schitterende glans. <br>Verstuiver voor op de flessen krijg je er gratis bij.', 'Industriële ontkalker voor sanitair', '6 x 1 flacon van 1 liter', '', '65.00', 21, 'actief'),
(41, 7, 'Schuurborstels', 'schuurborstels.jpg', '', '', '', '', '0.00', 21, 'niet-actief'),
(42, 6, 'Servetten', 'servetten.jpg', 'Witte servetten 1 laags.<br>Verpakt in een karton van 5000 stuks.', 'Witte 1 laags servetten', '1 karton = 5000 stuks', '', '50.00', 21, 'actief'),
(43, 7, 'Straatveger', 'straatveger.jpg', '', '', '', '', '0.00', 21, 'niet-actief'),
(44, 2, 'Grilo Des Antimos', 'tegen_groene_aanslag_contre_depots_verts.jpg', 'Grilo Des Antimos is een product voor verwijdering en voorkoming van groene aanslag op onder meer muren, daken, tuinmeubelen.<br>Grondig bespuiten, begieten of borstelen met een oplossing van 5% grilo, hoeft niet nagespoeld te worden.', 'Verwijdering en voorkoming van groene aanslag', '1 bidon van 5 liter', '', '75.00', 21, 'actief'),
(45, 7, 'Toiletborstel', 'toiletborstel.jpg', 'Witkleurige borstelhouder en borstel die onmisbaar is om de hygiëne van uw toiletten te garanderen.<br>Kan gebruikt worden in combinatie met reinigingsmiddelen.', 'Borstelhouder en borstel witkleurig voor hygiëne van wc', '1 stuk', '', '3.00', 21, 'actief'),
(46, 6, 'Toiletpapier 48 rollen', 'toiletpapier_48_rollen.jpg', 'Toiletpapier wit gemaakt uit gerecycleerd papier - celstof<br> 1 rol bevat 198 vellen<br>Verkrijgbaar in pak van 48 rollen, verpakt 12x4 rollen', 'Toiletpapier 48 rollen - celstof - gerecycleerd', '1 pak van 48 rollen', '', '28.00', 21, 'actief'),
(47, 6, 'Toiletpapier coreless 36 rollen', 'toiletpapier_coreless.jpg', 'Dit toiletpapier is zonder koker. Het bestaat uit 2 lagen en heeft 900 vellen per rol.<br>Op deze manier heeft u geen onnodig afval van losse kokers.<br>Verkrijgbaar in pak van 36 rollen\r\n', 'Toiletpapier coreless - 36 rollen - wit - 2 laags', '1 pak van 36 rollen', '', '55.00', 21, 'actief'),
(48, 6, 'Tork toiletpapier 72 rollen', 'tork_toiletpapier_72_rollen.jpg', 'Tork toiletpapier 3 laags is een sterk witkleurig papier dat ondanks zijn duurzaamheid en absorptievermogen zacht en aangenaam aanvoelt. 1 rol bevat 250 vellen<br>Verkrijgbaar in pak van 72 rollen, verpakt 9x8 rollen.', 'Tork toilepapier - 72 rollen - 3 laags - witkleurig', '1 pak van 72 rollen', '', '85.00', 21, 'actief'),
(49, 7, 'Vuilzakken', 'vuilzakken.jpg', '', '', '', '', '0.00', 21, 'niet-actief'),
(50, 11, 'Vloeibaar wasmiddel 2 in 1', 'wasmiddel_lessive.jpg', 'Vloeibaar wasmiddel 2 in 1 is een wasmiddel die uitermate geschikt is voor alle kleuren, wol, hand en witwas. Dit wasmiddel bevat actieve kalk behandeling en wasverzachter.<br>Bruikbaar bij 30° tem 90°', 'Actieve kalkbehandeling en wasverzachter<br>Geschikt voor 30° tot 90°', '4 x 3 liter', '', '60.00', 21, 'actief'),
(51, 8, 'WC-cleaner', 'wc-cleaner.jpg', 'WC-cleaner verfrist, reinigt en heeft glans aan uw toiletten. Verwijdert kalk en roestaanslag.<br>Tast het porselein, de buizen niet aan. Kan zeker geen kwaad voor septische buizen, wc\'s en urinoirs.', 'Reinigt en verfrist', '6 x 1 flacon van 750 ml', '', '49.00', 21, 'actief'),
(52, 2, 'Mr Proper Professional allesreiniger citroenfris', 'mr_proper_allesreiniger_citroenfris_5_liter.jpg', 'Mr. Proper Professional allesreiniger citroenfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur.', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', 21, 'actief'),
(53, 4, 'Handcreme glycerodermine', 'handcreme_glycerodermine.jpg', 'Handcrème glycerodermine hydrateert de huid en geeft geen vette sporen.  Dringt heel snel in de huid.<br>Helpt bij het voorkomen van kloven en droge huid.', 'Voorkomt kloven en droge huid', '1 tube 50 ml', '', '16.00', 21, 'actief'),
(54, 1, 'Afwasmiddel citroen ', 'afwasmiddel_citroen.jpg', 'Afwasmiddel citroen is een ideale ontvetter voor alle vaatwerk en onderhoud van spiegels.<br>Is zacht voor de handen en heeft een aangename geur.', 'Super krachtige ontvetter voor een fijne afwas', 'flacon van 1 liter / bidon van 5 liter', '', '5.00', 21, 'actief'),
(55, 11, 'Lenor Professional geconcentreerd wasverzachter zomerfris', 'wasverzachter_lenor_zomerfris.jpg', 'Lenor Professional wasverzachter zomerfris geeft uw wasgoed een extra luchtigheid, frisgevoel en een heerlijke geur. <br>Maakt strijken gemakkelijker, ca 200 wasbeurten.<br>Geconcentreerd hiermee bedoelen we dat 5 liter gelijk is aan 20 liter.', 'Fris en heerlijk reukend<br>ca 200 wasbeurten per bidon', '3 x 5 liter', '', '60.00', 21, 'actief'),
(56, 11, 'Wolly wasmiddel', 'wolly.jpg', 'Wolly wasmiddel is een ideaal wasmiddel voor wol, fijne was, handwas en gordijnen.<br>Voorkomt pluisvorming en kan zowel voor hand als machine was gebruikt worden.\r\n', 'Voor fijne was, wol, handwas en gordijnen', '1 flacon van 1 liter', '', '14.00', 21, 'actief'),
(57, 1, 'Schuurcreme Piek citroen', 'schuurcreme_piek.jpg', 'Schuurcrème piek citroen is zeer doeltreffend voor horecazaken alsook voor huishoudelijk gebruik, dit omdat het een goede werking heeft bij het reinigen van potten en pannen. Tevens kan deze crème ook gebruikt worden voor het reinigen van uw keukens en inox oppervlakten.<br>De crème heeft een heerlijke citroengeur en kan het beste onverdund gebruikt worden met een vochtige doek of spons. Wanneer het middel zijn werk heeft gedaan wel even afspoelen.', 'Doeltreffende reiniging potten, pannen, keuken en inox oppervlakten', '12 x 500 ml', '', '39.00', 21, 'actief'),
(58, 1, 'Vaatdoek katoen ', 'vaatdoek_katoen.jpg', 'Zeer praktische en handige vaatdoeken.<br>\r\nVervaardigd uit katoen, waardoor ze wasbaar zijn op 60°', 'Zeer handige vaatdoeken die wasbaar zijn op 60°', '10 stuks', '', '22.00', 21, 'actief'),
(59, 4, 'Autowas', '', 'Autowas is zeer geschikt voor het reinigen van auto\'s, trucks, caravans, boten,...<br>Kan gebruikt worden met een hoge drukreiniger.<br>Dankzij de sterke werking van deze cleaner wordt alle statische vuil, teer en vet verwijderd. Laat geen sporen na van hard water.', 'Reiniging voor auto\'s, trucks, carvans, boten...<br>Geschikt voor gebruik met hoge drukreiniger.', '1 bidon van 2 liter', '', '0.00', 21, 'niet-actief'),
(60, 2, 'Zilverglans', 'zilverglans.jpg', 'Zilverglans is een product waarmee je allerlei vloeren kan dweilen en/of schuren.<br>Het heeft een aangename geur en doet uw vloer glanzen zonder sporen van voetstappen achter te laten.<br>Zeer geschikt voor moderne vloeren.', 'Reinigingsmiddel voorzien van aangename geur die geschikt is voor allerlei vloeren', '1 bidon van 5 liter', '', '28.00', 21, 'actief'),
(61, 2, 'Vloerzeep groen', '', 'Vloerzeep groen zorgt voor de nodige onderhoud van uw vloeren.  Zorgt tevens voor een zeer aangename geur en een schitterende glans.<br>Geschikt voor alle vloeren.', 'Onderhoudsproduct voor vloeren', '1 bidon van 5 liter', '', '20.00', 21, 'niet-actief'),
(62, 2, 'Industriereiniger', '', 'Industriereiniger is onze krachtige allesreiniger, is sterk geconcentreerd en dient voor het afwassen van allerhande oppervlakten.<br>Verwijdert zonder moeite teer en andere vuile vlekken op vloeren.<br>Zeer goed geschikt voor garages en werkplaatsen.', 'Krachtige allesreiniger voor het afwassen van allerhande oppervlakken', '1 bidon van 10 liter', '', '50.00', 21, 'niet-actief'),
(63, 9, 'badcreme', 'test', 'Deze badcrème zorgt voor een hele zachte huid, bevat onder meer nertsolie en koko\'s olie.<br>Uitstekend geschikt ook voor kinderen en baby\'s.', 'Verzorgende zeep voor een zachte huid.<br>Ook geschikt voor baby\'s en kinderen', '6 x 1 liter', '', '55.00', 21, 'niet-actief'),
(64, 2, 'Allesreiniger ammonia', 'ammonia.jpg', 'Allesreiniger ammonia is zeer geschikt voor het reinigen van linoleum, tegels, houtwerk, lavabo\'s, badkuipen, toonbanken en alle andere afwasbare oppervlakten. Ook geschikt voor glaswerk, ruiten en spiegels.<br>Voor extra vuile plekken zoals teer, olie en vet mag dit product onverdund gebruikt worden.', 'Zeer goede reiniger voor tegels, lavabo\'s, houtwerk, spiegels,...', '1 bidon van 5 liter', '', '20.00', 21, 'actief'),
(65, 2, 'Ovenreiniger', '', 'Deze reiniger lost probleemloos alle vetten op zoals bijvoorbeeld van ovens, machines, braadspitten.<br>Op koude oppervlakten werktijd ± 8 à 10 minuten laten inwerken, daarna met warm water grondig afspoelen.<br>Op warme oppervlakten 35 à 45 graden laten inwerken gedurende een 3 tal minuten en daarna grondig afspoelen met warm water.', 'Krachtige reiniger voor het probleemloos oplossen van alle vetten zoals bv van ovens, machines, braadspitten', '1 bidon van 5 liter', 'Handschoenen dragen bij gebruik van dit product', '40.00', 21, 'niet-actief'),
(66, 2, 'Ruitenreiniger', 'ruitenreiniger.jpg', 'Onze ruitenreiniger is een reuk en smaakloos product, dat speciaal geschikt is voor horecabedrijven.<br>Het ontvet, ontgeurt, ontsmet en geeft een mooie glans aan glazen, ruiten en spiegels.\r\n', 'Krachtige reiniger, ontvetter, glansgever voor glazen, ruiten en spiegels, ideaal voor horecabedrijven.', '1 bidon van 5 liter', '', '28.00', 21, 'actief'),
(67, 11, 'Ariel Color Professional vloeibaar wasmiddel', 'ariel_color_vloeibaar.jpg', 'Ariel Color Professional vloeibaar wasmiddel heeft een maximale waskracht van de gekleurde was.<br>Uitstekende verwijdering van moelijke vlekken. Geeft uw was optimale bescherming en laat het als nieuw uitzien.<br>1 bidon is goed voor ca 70 wasbeurten.', 'Maximale waskracht voor gekleurde was, verwijdert doeltreffend moeilijke vlekken<br>1 bidon is goed voor ca 70 wasbeurten', '2 bidons', '', '98.00', 21, 'actief'),
(68, 9, 'Toiletzeep red poppy', 'poppy.jpg', '', '', '6 stuks', '', '48.00', 21, 'actief'),
(69, 1, 'Super Detergent ', 'super_detergent.jpg', 'Super ontvetter is dankzij zijn krachtige en verzorgende werking het ideale middel voor al uw vaatwerk.', 'Krachtige ontvetter voor uw vaat', '1 bidon van 5 liter', '', '18.00', 21, 'actief'),
(70, 3, 'Alcoholgel', 'alcoholgel.jpg', 'Alcoholgel bevat een snelle ontsmetting van de handen zonder gebruik van water.<br>Moet worden toegepast voor schone en gezonden handen.<br>Plaats een dosis gel in de palm van een hand en wrijf de handen in elkaar voor ongeveer 30 seconden tot ze volledig droog zijn.', 'Snelle ontsmetting van de handen zonder gebruik van water.', '1 bidon van 5 liter', '', '50.00', 21, 'actief'),
(71, 2, 'Super ontvetter', 'super_ontvetter.jpg', 'Super ontvetter is een krachtige ontvetter voor het reinigen van vette oppervlakken zoals muren, oven, grills, enz.<br>Verwijdert tevens ingebrandt vet.', 'Krachtige ontvetter voor reiniging ovens, grills, vette oppervlakken, enz.', '1 bidon van 5 liter', '', '35.00', 21, 'actief'),
(72, 1, 'DM vaatwasmiddel', 'vloeibaar_vaatwasmiddel.jpg', 'DM vaatwasmiddel is een vloeibaar wasmiddel voor industriële vaatwerkspoelmachines.<br>Krachtige reiniging en zorgt tevens voor een hygiënische verantwoorde afwas.', 'Vloeibaar wasmiddel voor industriële vaatwerkspoelmachines.', '1 bidon van 25 liter', '', '75.00', 21, 'actief'),
(73, 6, 'Keukenpapier 3 laags', 'keukenpapier_3_laags.jpg', '3 laags witkleurig keukenpapier met een zeer krachtige absorptievermogen. 1 rol bevat 51 vellen<br>Verkrijgbaar in pak van 32 rollen, verpakt 8x4 stuks.', '3 laags witkleurig keukenpapier', '1 pak van 32 rollen', '', '49.00', 21, 'actief');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product_opties`
--

CREATE TABLE `product_opties` (
                                  `optie_id` int(4) UNSIGNED NOT NULL,
                                  `optie_titel` varchar(20) NOT NULL,
                                  `optie_naam` varchar(20) NOT NULL,
                                  `eenheidsprijs` decimal(7,2) NOT NULL DEFAULT 0.00,
                                  `product_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `product_opties`
--

INSERT INTO `product_opties` (`optie_id`, `optie_titel`, `optie_naam`, `eenheidsprijs`, `product_id`) VALUES
(1, 'Verpakking', '500 ml', '8.00', 24),
(2, 'Verpakking', '5 liter', '50.00', 24),
(3, 'Soort', 'meiklokjes', '0.00', 18),
(4, 'Soort', 'forest', '0.00', 18),
(5, 'Soort', 'citroen', '0.00', 18),
(6, 'Soort', 'vanille', '0.00', 18),
(7, 'Soort', 'jasmijn', '0.00', 18),
(8, 'Soort', 'marine', '0.00', 18),
(9, 'Soort', 'lavendel', '0.00', 18),
(10, 'Soort', 'lila bloemengeur', '0.00', 18),
(11, 'Verpakking', '1 liter', '5.00', 54),
(12, 'Verpakking', '5 liter', '16.00', 54),
(13, 'Soort', '15° actief chloor', '0.00', 16),
(14, 'Soort', '30° actief chloor', '0.00', 16);

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
(1, 'Bart', 'Leers', 'bart@leers.pro', '$2y$10$T4hA2TD/FZ4Jg8aT.4Zs6uv4kMAT60N5iIhAP0Z3V9nNo6D35URla', '2020-12-10 11:53:00', 'Holstraat', '29/1', '8790', 'Waregem', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '0494300380', NULL, NULL, 'Admin', 'activated', NULL, ''),
(2, 'Lydia', 'Delhaye', 'lydia.delhaye@telenet.be', '$2y$10$ZfRI9FWQyRs3VGNJIlCfxezyjgQd2tk0laq/g6kr.J84USKDiKkBu', '2020-12-10 11:54:20', 'Holstraat', '29/1', '8790', 'Waregem', '', '', '', '', '0497433265', '', '', 'Admin', 'activated', NULL, ''),
(10, 'Gabriël', 'Delhaye', 'shop@delga.be', '$2y$10$yXjJCsKqxHMEzBOhKgT1l.vybx49swnj0ESom2lEqZ.Sy7yZojLc6', '2021-05-17 17:44:10', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '0495361149', '', '', 'Prive', 'activated', '', '');

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
    ADD KEY `user_id` (`user_id`,`order_datum`) USING BTREE;

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
    ADD PRIMARY KEY (`optie_id`),
    ADD KEY `product_id` (`product_id`);

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
    MODIFY `categorie_id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
    MODIFY `order_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `order_details`
--
ALTER TABLE `order_details`
    MODIFY `order_details_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
    MODIFY `product_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT voor een tabel `product_opties`
--
ALTER TABLE `product_opties`
    MODIFY `optie_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `producten`
--
ALTER TABLE `producten`
    ADD CONSTRAINT `producten_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `product_opties`
--
ALTER TABLE `product_opties`
    ADD CONSTRAINT `product_opties_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `producten` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
