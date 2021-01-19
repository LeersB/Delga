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
-- Table structure for table `orders`
--

CREATE TABLE `orders`
(
    `order_id`       int(8) UNSIGNED NOT NULL,
    `gebruiker_id`   int(8) UNSIGNED NOT NULL,
    `totaal_prijs`   decimal(7, 2) NOT NULL,
    `order_datum`    datetime      NOT NULL,
    `opmerking`      varchar(250),
    `leveringsdatum` datetime      NOT NULL,
    `status`         char(2)       NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details`
(
    `order_details_id` int(8) UNSIGNED NOT NULL,
    `order_id`         int(8) UNSIGNED NOT NULL,
    `product_id`       int(8) UNSIGNED NOT NULL,
    `kostprijs`        decimal(7, 2) NOT NULL,
    `aantal`           int(2) NOT NULL,
    `aantal_levering`  int(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie`
(
    `categorie_id`   int(2) UNSIGNED NOT NULL,
    `categorie_naam` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data for table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `categorie_naam`) VALUE
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
-- Table structure for table `producten`
--

CREATE TABLE `producten`
(
    `product_id`    int(4) UNSIGNED NOT NULL,
    `categorie_id`  int(2) UNSIGNED NOT NULL,
    `product_naam`  varchar(60)   NOT NULL,
    `product_foto`  varchar(60),
    `product_info`  varchar(600)  NOT NULL,
    `omschrijving`  varchar(300)  NOT NULL,
    `verpakking`    varchar(60)   NOT NULL,
    `waarschuwing`  varchar(400),
    `eenheidsprijs` decimal(7, 2) NOT NULL,
    `btw`           decimal(7, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data for table `producten`
--

INSERT INTO `producten` (`product_id`, `categorie_id`, `product_naam`, `product_foto`, `product_info`, `omschrijving`, `verpakking`, `waarschuwing`, `eenheidsprijs`, `btw`) VALUES
(1, 12, 'Ariel Professional vloeibaar wasmiddel', 'ariel_hydractiv.jpg', 'Ariel concentraat wasmiddel heeft een goede krachtige werking voor zowel witte als gekleurde was.  Zeer doeltreffende werking bij hardnekkige vlekken zoals bloed, koffie, wijn,... zelfs bij lage temperaturen. <br>Zorgt ervoor dat uw was er héél mooi blijft uitzien, voorkomt vergrijzing en heeft een optimale bescherming. <br>Geschikt van 30° tot max. 95° <br> 1 bidon bevat 70 wasbeurten.', 'Ariel Professional Vloeibaar Wasmiddel - Regular 70 Wasbeurten<br> geschikt van 30° tot max 95°', '2 x 4,55 liter', '', '40.00', '21.00'),
(2, 12, 'Ariel Professional waspoeder', 'ariel_professional_waspoeder.jpg', 'Ariel Professional waspoeder zorgt bij iedere wasbeurt voor een stralende schone was. Geschikt voor witte als gekleurde was. <br>Uitstekende vlekkenverwijdering zelfs bij 30°<br> ca goed voor 150 wasbeurten.', 'Geschikt voor iedere soort textiel<br>ca 150 wasbeurten ', '1 zak 15 kg', 'Opletten : Gevaarlijk product. Neem de voorzorgsmaatregelen voor gebruik in acht.<br>H319 : Veroorzaakt ernstige oogirritatie.', '75.00', '21.00'),
(3, 12, 'Biotex blauw voorwas', 'biotex_blauw_voorwas_500gr.jpg', 'Biotex blauw voorwas maakt het gemakkelijker om zelfs zwaar vervuilde was weer heel stralend schoon te krijgen dankzij de speciale werking van enzymen. Volledig veilig voor uw kledij.', 'Tegen vuil en vlekken ', '500 gr', '', '0.00', '21.00'),
(4, 8, 'Borstelstelen', 'borstelstelen.jpg', 'Verschillende soorten borstelstelen in aluminium, hout, fiber of metaal – ook telescopische borstelstelen', '', '', '', '0.00', '21.00'),
(5, 1, 'Broxomatic', 'broxomatic_2kg.jpg', 'Broxomatic onthardingszout is onmisbaar tijdens het vaatwasproces. Het maakt het water zachter waardoor de werking van de vaatwasmiddel krachtiger wordt. Tevens voorkomt het kalkvlekken op de vaat en zorgt het voor betere droogresultaten', 'Onthardingszout voor de vaatwasmachine', '2,2 kg', '', '0.00', '21.00'),
(6, 12, 'Dash Professional vloeibaar wasmiddel', 'dash_vloeibaar_wasmiddel.jpg', 'Dash Professional vloeibaar wasmiddel verwijdert snel alle vuil en vlekken zelfs bij lage temperaturen en een korte wascyclus. <br>Geschikt voor al uw wit wasgoed behalve wol en zijde bij 20 tot 95°<br>\r\nca 85 wasbeurten', 'Snelle vuil- en vlekkenverwijdering bij temperaturen van 20° tot 95°<br>ca 85 wasbeurten', '3 x 5,25 liter', '', '135.00', '21.00'),
(7, 12, 'Dash Professional waspoeder', 'dash_professional_waspoeder.jpg', 'Dash Professional waspoeder zorgt voor een stralende was door zijn snelle vuil- en vlekkenverwijdering.<br>Aangenaam fris parfum<br>ca 150 wasbeurten', 'Stralende was, snelle vuil- en vlekkenverwijdering<br>ca 150 wasbeurten', '1 zak 15 kg', '', '75.00', '21.00'),
(8, 3, 'Desinfecterend middel', 'desinfecterend_middel.jpg', '', '', '', '', '0.00', '21.00'),
(9, 3, 'Desinfecterende alcohol', 'desinfecterende_alcohol.jpg', '', '', '', '', '0.00', '21.00'),
(10, 4, 'Dispenser blauw', 'dispensers_blauw.jpg', '', '', '', '', '0.00', '21.00'),
(11, 12, 'Dreft Professional vloeibaar wasmiddel', 'dreft.jpg', 'Dit vloeibaar wasmiddel verwijdert 83 wasbeurten lang alle soorten vlekken. <br>Het is geschikt voor wassen op zowel 30°, 40° en 60°<br>wordt verkocht per karton van 2 bidons', '83 wasbeurten - 30° 40° 60°\r\n', '2 x 4,55 liter', '', '130.00', '21.00'),
(12, 1, 'Dreft Professional afwasmiddel', 'dreft_professional_afwasmiddel.jpg', 'Dreft Professional afwasmiddel is geschikt voor algemeen gebruik. Het verwijdert zeer doeltreffend alle vetten en etensresten.<br>Het schuimt langdurig zodat het water minder vaak moet ververst worden.>br>Kan ook gebruikt worden voor de reiniging van onder meer ramen, spiegels, tafels, enz.<br> Dreft afwasmiddel is zuinig in gebruik en veilig voor de huid, dermatologisch getest.', 'Verwijdert doeltreffend alle vetten en etensresten<br>schuimt langdurig<br> veilig voor de huid, dermatologisch getest', '1 bidon van 5 liter', '', '18.00', '21.00'),
(13, 12, 'Dreft Professional wasmiddel donker', 'dreft_professional_fine_lessive_donker.jpg', 'Geconcentreerd vloeibaar fijnwasmiddel voor kleurwas en donkere was. <br>Speciaal ontwikkelt voor behoud en bescherming van de kleur', 'Kleurwas of donker<br>44 wasbeurten', '', '', '0.00', '21.00'),
(14, 12, 'Dreft Professional fijnwas waspoeder', 'dreft_professional_fijnwasmiddel.png', 'Dreft Professional fijnwas waspoeder is een uitstekende kleurbeschermer. Die tevens helpt de frisheid van de kleuren te behouden. Wassen op 30°-40° en 60°<br>Bevat een gepatenteerde formule tegen pluizen en krimpen.<br>Ook geschikt voor gebruik bij wol en zijde.<br>1 doos bevat 77 wasbeurten', 'Uitstekende kleurbeschermer voor 30°-40°-60° <br>geschikt voor wol en zijde <br> 77 wasbeurten', '1 doos = 7,5 kg', '', '65.00', '21.00'),
(15, 1, 'Dreft Platium all-in one vaatwastabletten', 'platinum-all-in-one-vaatwastabletten-90-tabs.jpg', 'De Dreft Platium all-in one vaatwastabletten zorgen voor een hardnekkige reiniging waardoor hardnekkigste etensresten afbreken. <br>Dankzij de vloeibare bovenzijde van de tablet zorgt het voor de directe aanpak van olie en vet. Hierdoor krijgt U een schitterende vaat en een glanzende vaatwas achteraf.<br>met verpakking in vaatwasmachine, geen afval, gebruiksvriendelijk.', 'Hardnekkige, schitterende en glanzende reiniging dankzij unieke formule<br>gebruiksvriendelijk', '90 + 90 tabletten gratis', 'uit de buurt van kinderen bewaren!', '60.00', '21.00'),
(16, 10, 'Dreumex handzeep', 'dreumex_handzeep.jpg', 'Dreumex handzeep is een handreiniger voor middel zware tot zware industriële vervuilingen zoals smeermiddel, diesel, remvloeistof, cement en roest.<br>Bijzonder geschikt voor gebruik in de automobiel, landbouw, metaalindustrie en dergelijke.<br>Huidvriendelijke korrel voor extra reinigingskracht', 'Industriële krachtige handreiniger<br>pompje inbegrepen bij de verpakking', '1 bidon van 4,5 liter', '', '0.00', '21.00'),
(17, 8, 'Assortiment dweilen', 'dweilen.jpg', '', '', '', '', '3.00', '21.00'),
(18, 11, 'Bleekwater / eau de javel', 'eau_de_javel.jpg', 'Bleekwater / eau de javel wordt in verschillende sectoren gebruikt dankzij de vlekverwijderende, witmakende, ontsmettende en ontgeurende werking. Maakt elke ondergrond met vlekken terug wit', 'Zuivert, verbleekt en ontvlekt diverse oppervlakken<br>beschikbaar in 15° en 30° actief Chloor', '4 x 1 bidon van 5 liter', '', '16.00', '21.00'),
(19, 4, 'Elleboogdispenser', 'elleboogdispenser.jpg', '', '', '', '', '0.00', '21.00'),
(20, 8, 'Emmers', 'emmers.jpg', '', '', '', '', '0.00', '21.00'),
(21, 8, 'Gel fresh', 'gel_fresh.jpg', '', '', '', '', '0.00', '21.00'),
(22, 7, 'Gevouwen handpapier', 'gevouwen_handpapier.jpg', '', '', '', '', '0.00', '21.00'),
(23, 1, 'Glansspoelmiddel DM50R', 'glansspoelmiddel0.jpg', 'Glansspoelmiddel DM50R zorgt voor een professionele werking in de vaatwasmachines. Voorkomt afzetting van kalk en maakt de vaat stralend en perfect schoon zonder strepen', 'Voorkomt kalk en zorgt voor mooie vaat zonder strepen', '1 bidon van 5 liter', '', '45.00', '21.00'),
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
(35, 12, 'Lenor Professional wasverzachter lentefris', 'lenor_professional_wasverzachter.jpg', 'Lenor Professional wasverzachter lentefris geeft uw wasgoed een extra luchtigheid, frisgevoel en een heerlijke geur. <br>Maakt strijken gemakkelijker <br> ca 200 wasbeurten', 'Fris en heerlijk reukend<br>ca 200 wasbeurten per bidon', '3 x 5 liter', '', '60.00', '21.00'),
(36, 8, 'Loda soda kristallen', 'loda_sodakristallen.jpg', 'Gebruik Loda soda kristallen om 100% natuurlijk te reinigen, ontvetten, ontkalken en om vlekken uit textiel te verwijderen.  ', 'Reinigt, ontvet, ontkalkt en ontvlekt', '1 doos = 6 zakken van 2kg', '', '0.00', '21.00'),
(37, 3, 'Mondmaskers', 'mondmaskers.jpg', '', '', '', '', '0.00', '21.00'),
(38, 3, 'Mosa ontsmettingsproduct', 'mosa_ontsmettingsproduct.jpg', '', '', '', '', '0.00', '21.00'),
(39, 2, 'Mr Proper Professional allesreiniger oceaanfris', 'mr_proper_professional_allesreiniger.jpg', 'Mr. Proper Professional allesreiniger oceaanfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', '21.00'),
(40, 2, 'Mr Proper spray anti-bacterieel', 'mr_Proper_spray_anti_bacterieel.jpg', 'Mr. Proper spray anti-bacterieel is een multi oppervlaktenreiniger. Is geschikt voor dagelijks reinigen en ontsmetten van diverse oppervlakten.<br>Met de alles reinigende spray geniet je van de kracht van 3 producten in 1:<br>-maakt alles grondig proper<br>-desinfecteert, doodt 99,9% van bacteriën<br>-streep-vrije glans bij vensters, spiegels, tafelbladen, enz.', 'Multi oppervlaktenreiniger met desinfecterende werking', '1 flacon van 750 ml', '', '0.00', '21.00'),
(41, 2, 'Reukwegnemer geparfumeerd', 'ontgeurder_desodorisant.jpg', 'Met zijn zacht en aangenaam parfum ontgeurt en verfrist dit product onmiddellijk onder meer toiletten, urinoirs, ziekenkamers, vergaderlokalen, vuilnisemmers, zwembaden, enz. <br>Zeer geschikt voor viswerkende bedrijven en landbouwbedrijven<br>Goed schudden bij elk gebruik', 'Ontgeurt en verfrist alles', '1 bidon van 5 liter', '', '28.00', '21.00'),
(42, 3, 'Ontsmettingspaal met sensor', 'ontsmettingspaal_met_sensor.jpg', '', '', '', '', '0.00', '21.00'),
(43, 9, 'Grilo ontstopper', 'ontstopper_deboucheur.jpg', 'Grilo ontstopper is een krachtige ontstopper te gebruiken voor toiletten, wastafels, afvoerbuizen en riolen', 'Krachtige industriële ontstopper', '1 flacon van 1 liter', '', '18.00', '21.00'),
(44, 6, 'Grilo ontvetter', 'ontvetter_degraissant.jpg', 'Grilo ontvetter is een industriële ontvetter voor grootkeukens en grootindustrie<br>Reinigt en ontvet onder meer dampkappen, keukenmateriaal, vloeren,...<br>Speciaal ontwikkeld voor machinale reiniging met of zonder hoge druk', 'Reinigen en ontvetten van grootkeukens en grootindustrie', '1 bidon van 5 liter', '', '0.00', '21.00'),
(45, 3, 'Reinigingsdoekjes', 'reiniginsdoekjes_met_75_alcohol.jpg', '', '', '', '', '0.00', '21.00'),
(46, 3, 'Reinigingsspray', 'Reiniginsspray_ontsmettend.jpg', '', '', '', '', '0.00', '21.00'),
(47, 9, 'Sanitair reiniger Rap en Rein', 'sanitair_reiniger_nettoyant-sanitaire.jpg', 'De Sanitair reiniger Rap en Rein verwijderd moeiteloos hardnekkige kalkaanslag en geeft een schitterende glans', 'Industriële ontkalker voor sanitair', '6 x 1 flacon van 1 liter', '', '65.00', '21.00'),
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
(61, 12, 'Vloeibaar wasmiddel 2 in 1', 'wasmiddel_lessive.jpg', 'Vloeibaar wasmiddel 2 in 1 is een wasmiddel die uitermate geschikt is voor alle kleuren, wol, hand en witwas. Dit wasmiddel bevat actieve kalk behandeling en wasverzachter.<br>Bruikbaar bij 30° tem 90°', 'Actieve kalkbehandeling en wasverzachter<br>Geschikt voor 30° tot 90°', '1 bidon van 3 liter', '', '0.00', '21.00'),
(62, 9, 'WC-cleaner', 'wc-cleaner.jpg', 'WC-cleaner verfrist, reinigt en heeft glans aan uw toiletten. Verwijdert kalk en roestaanlag', 'Reinigt en verfrist', '6 x 1 flacon van 750 ml', '', '49.00', '21.00'),
(63, 3, 'Wegwerphandschoenen', 'wegwerphandschoenen.jpg', '', '', '', '', '0.00', '21.00'),
(64, 4, 'Vileda Wrapmaster', 'wrapmaster_vileda.jpg', '', '', '', '', '0.00', '21.00'),
(65, 2, 'Mr Proper Professional allesreiniger citroenfris', 'mr_proper_allesreiniger_citroenfris_5_liter.jpg', 'Mr. Proper Professional allesreiniger citroenfris reinigt en ontvet heel snel en doeltreffend.<br>Geschikt voor het reinigen van vloeren, keuken werkbladen, harde oppervlakken.<br>Verspreidt tijdens het schoonmaken een frisse en langdurige geur', 'Reinigt en ontvet allerhande oppervlakken', '3 x 1 bidon van 5 liter', '', '60.00', '21.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `product_opties`
(
    `optie_id` int
(
    4
) UNSIGNED NOT NULL,
    `optie_titel` varchar
(
    255
) NOT NULL,
    `optie_naam` varchar
(
    255
) NOT NULL,
    `eenheidsprijs` decimal
(
    7,
    2
) NOT NULL,
    `product_id` int
(
    4
) UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_opties` (`optie_id`, `optie_titel`, `optie_naam`, `eenheidsprijs`, `product_id`)
VALUES (1, 'Soort', 'Aluminium', '0.00', 4),
       (2, 'Soort', 'Hout', '0.00', 4),
       (3, 'Soort', 'Fiber', '9.99', 4),
       (4, 'Soort', 'Metaal', '32.99', 4),
       (5, 'Soort', 'Telescopisch', '29.99', 4),
       (6, 'Soort', 'Microvezel', '0.00', 17),
       (7, 'Soort', 'Katoen', '0.00', 17),
       (8, 'Soort', 'Polyamide', '0.00', 17),
       (9, 'Soort', 'Anker', '0.00', 48),
       (10, 'Soort', 'Linea', '0.00', 48),
       (11, 'Soort', 'PVC', '0.00', 50),
       (12, 'Soort', 'Bazine afrique', '0.00', 50),
       (13, 'Soort', 'Bahia pur', '0.00', 50);

ALTER TABLE `product_opties`
    ADD PRIMARY KEY (`optie_id`);

ALTER TABLE `product_opties`
    MODIFY `optie_id` int (4) NOT NULL AUTO_INCREMENT;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
    `user_id`           int(8) UNSIGNED NOT NULL,
    `voornaam`          varchar(50)  NOT NULL,
    `achternaam`        varchar(50)  NOT NULL,
    `email`             varchar(100) NOT NULL,
    `wachtwoord`        varchar(255) NOT NULL,
    `registratie_datum` datetime     NOT NULL,
    `adres_straat`      varchar(80)  NOT NULL,
    `adres_nr`          varchar(20)  NOT NULL,
    `adres_postcode`    char(4)      NOT NULL,
    `adres_plaats`      varchar(50)  NOT NULL,
    `telefoon_nr`       char(15)     NOT NULL DEFAULT '',
    `bedrijfsnaam`      varchar(50),
    `btw_nr`            char(20),
    `user_level`        enum('User','Admin') NOT NULL DEFAULT 'User',
    `activatie_code`    varchar(50)  NOT NULL DEFAULT '',
    `terugkeer_code`    varchar(255) NOT NULL DEFAULT '',
    `reset_code`        varchar(50)  NOT NULL DEFAULT ''

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `voornaam`, `achternaam`, `email`, `wachtwoord`, `registratie_datum`, `adres_straat`,
                     `adres_nr`, `adres_postcode`, `adres_plaats`, `telefoon_nr`, `user_level`)
VALUES (1, 'Bart', 'Leers', 'bart@leers.pro', '$2y$10$B6tYxS6LVvbeNo6FWRLbpOPzRJwOc2FLxYxHgQ4BRuYj8Q00fbzlS',
        '2020-11-25 12:00:00', 'Holstraat', '29/0001', '8790', 'Waregem', '0494300380', 'Admin'),
       (2, 'Test', 'Delga', 'test@delga.be', '$2y$10$1/NmTZ10uqfoaDotJmiaIu6k0I99pcdAatZgFqmNzn/sgsYgXkHrq',
        '2020-12-08 18:00:00', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '0494300380', 'User');



--
-- Indexes for dumped tables
--

--
-- Indexes for table `producten`
--
ALTER TABLE `producten`
    ADD PRIMARY KEY (`product_id`),
    ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`order_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`,`order_datum`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
    ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
    ADD PRIMARY KEY (`categorie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
    MODIFY `order_id` int (8) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
    MODIFY `order_details_id` int (8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producten`
--
ALTER TABLE `producten`
    MODIFY `product_id` int (4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
    MODIFY `categorie_id` int (2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;


