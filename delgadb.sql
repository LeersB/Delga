
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+01:00";



--
-- Database: `delgatest`
--

-- --------------------------------------------------------


--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(8) UNSIGNED NOT NULL,
  `gebruiker_id` int(8) UNSIGNED NOT NULL,
  `totaal_prijs` decimal(7,2) NOT NULL,
  `order_datum` datetime NOT NULL,
  `opmerking` varchar(250),
  `leveringsdatum` datetime NOT NULL,
  `status` char(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(8) UNSIGNED NOT NULL,
  `order_id` int(8) UNSIGNED NOT NULL,
  `product_id` int(8) UNSIGNED NOT NULL,
  `kostprijs` decimal(7,2) NOT NULL,
  `aantal` int(2) NOT NULL,
  `aantal_levering` int(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
    `categorie_id` int(2) UNSIGNED NOT NULL,
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
(5, 'Ontvetters'),
(6, 'Papierwaren'),
(7, 'Reinigingsartikelen'),
(8, 'Sanitairreinigers'),
(9, 'Speciaal gamma'),
(10, 'Vloerreinigers'),
(11, 'Wasproducten'),
(12, 'Zepen');


-- --------------------------------------------------------

--
-- Table structure for table `producten`
--

CREATE TABLE `producten` (
    `product_id` int(4) UNSIGNED NOT NULL,
    `categorie_id` int(2) UNSIGNED NOT NULL,
    `product_naam` varchar(60) NOT NULL,
    `product_foto` varchar(60),
    `product_info` varchar(300) NOT NULL,
    `omschrijving` varchar(600) NOT NULL,
    `verpakking` varchar(60) NOT NULL,
    `waarschuwing` varchar(400),
    `eenheidsprijs` decimal(7,2) NOT NULL,
    `btw` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data for table `producten`
--

INSERT INTO `producten` (`product_id`, `categorie_id`, `product_naam`, `product_foto`, `product_info`, `omschrijving`, `verpakking`, `waarschuwing`, `eenheidsprijs`, `btw`) VALUES

(1, 11, 'Ariel Professional','ariel_hydractiv.jpg','Ariel Professional Vloeibaar Wasmiddel - Regular 70 Wasbeurten <br>Ariel concentraat wasmiddel voor 70 wasbeurten, maximale waskracht voor fris wit linnen, een uitstekende verwijdering van moeilijke vlekken, voorkomt vergrijzing en laat je was er weer voor nieuw uitzien en geeft optimale bescherming. Zeer doeltreffend tegen hardnekkige vlekken zoals bloed, rode wijn, vet, koffie en thee, zelfs bij de laagste temperaturen.','Ariel Professional Vloeibaar Wasmiddel - Regular 70 Wasbeurten','4,55 liter','',25,21),
(2, 11, 'Ariel Professional waspoeder','ariel_professional_waspoeder.JPG','Uitstekend wasmiddel voor alle soorten vlekken en textiel. Goed voor 150 dosissen. Procter &amp; Gamble','Uitstekend wasmiddel','13 kg','Opletten : Gevaarlijk product. Neem de voorzorgsmaatregelen voor gebruik in acht.
H319 : Veroorzaakt ernstige oogirritatie.',25,21),
(3, 11, 'Biotex blauw voorwas','biotex_blauw_voorwas_500gr.jpg','','','500 gr','',25,21),
(4, 7, 'Borstelstelen','borstelstelen.jpg','Verschillende soorten borstelstelen in aluminium, hout, fiber of metaal – ook telescopische borstelstelen','','','',25,21),
(5, 1, 'BroxoMatic','broxoMatic.jpg','','','','',0,21),
(6, 11, 'Dash Vloeibaar','dash_vloeibaar_wasmiddel.jpg','','','','',0,21),
(7, 11, 'Dash Professional waspoeder','dash_professional_waspoeder.jpg','','','','',0,21),
(8, 3, 'Desinfecterend middel','desinfecterend_middel.jpg','','','','',0,21),
(9, 3, 'Desinfecterende alcohol','desinfecterende_alcohol.jpg','','','','',0,21),
(10, 4, 'Dispenser blauw','dispensers_blauw.jpg','','','','',0,21),
(11, 11, 'Dreft','dreft.jpg','','','','',0,21),
(12, 1, 'Dreft Professional','dreft_professional_afwasmiddel.jpg','','','','',0,21),
(13, 11, 'Dreft Professional donker','dreft_professional_fine_lessive_donker.jpg','','','','',0,21),
(14, 11, 'Dreft Professional fijnwas','dreft_professional_fijnwasmiddel.png','','','','',0,21),
(15, 1, 'Dreft vaatwascapsules','dreft_vaatwascapsules.jpg','','','','',0,21),
(16, 12, 'Dreumex handzeep','dreumex_handzeep.jpg','','','','',0,21),
(17, 7, 'Assortiment dweilen','dweilen.jpg','','','','',0,21),
(18, 10, 'Eau de javel','eau_de_javel.jpg','','','','',0,21),
(19, 4, 'Elleboogdispenser','elleboogdispenser.jpg','','','','',0,21),
(20, 7, 'Emmers','emmers.jpg','','','','',0,21),
(21, 9, 'Gel fresh','gel_fresh.jpg','','','','',0,21),
(22, 6, 'Gevouwen handpapier','gevouwen_handpapier.jpg','','','','',0,21),
(23, 9, 'Glansspoelmiddel','glansspoelmiddel0.jpg','','','','',0,21),
(24, 7, 'Handborstels met steel','handborstels_met_steel.jpg','','','','',0,21),
(25, 6, 'Handpapier 1 laag grijs','handpapier_1_laag_grijs.jpg','','','','',0,21),
(26, 6, 'Handpapier 1 laag wit','handpapier_1_laag_wit.jpg','','','','',0,21),
(27, 6, 'Handpapier 1 laag celstof wit','handpapier_1_laags_celstof_wit.jpg','','','','',0,21),
(28, 6, 'Handpapier 2 laags wit','handpapier_2_laags_wit.jpg','','','','',0,21),
(29, 12, 'Handwascreme','handwascreme.jpg','','','','',0,21),
(30, 7, 'Hygiënische borstels','hygiënische_borstels.jpg','','','','',0,21),
(31, 7, 'Hygiënische trekkers','hygienische_trekkers.jpg','','','','',0,21),
(32, 8, 'Javel tabletten','javeltabletten.jpg','','','','',0,21),
(33, 6, 'Keukenpapier','keukenpapier_32_rollen.jpg','','','','',0,21),
(34, 7, 'Krasvrije schuurspons','krasvrije_schuurspons.jpg','','','','',0,21),
(35, 11, 'Lenor Professional wasverzachter','lenor_professional_wasverzachter.jpg','','','','',0,21),
(36, 9, 'Loda sodakristallen','loda_sodakristallen.jpg','','','','',0,21),
(37, 3, 'Mondmaskers','mondmaskers.jpg','','','','',0,21),
(38, 3, 'Mosa ontsmettingsproduct','mosa_ontsmettingsproduct.jpg','','','','',0,21),
(39, 2, 'Mr Proper Professional allesreiniger','mr_proper_professional_allesreiniger.jpg','','','','',0,21),
(40, 2, 'Mr Proper spray anti-bacterieel','mr_Proper_spray_anti_bacterieel.jpg','','','','',0,21),
(41, 2, 'Ontgeurder','ontgeurder_desodorisant.jpg','','','','',0,21),
(42, 3, 'Ontsmettingspaal met sensor','ontsmettingspaal_met_sensor.jpg','','','','',0,21),
(43, 9, 'Ontstopper','ontstopper_deboucheur.jpg','','','','',0,21),
(44, 5, 'Ontvetter','ontvetter_degraissant.jpg','','','','',0,21),
(45, 3, 'Reinigingsdoekjes','reiniginsdoekjes_met_75_alcohol.jpg','','','','',0,21),
(46, 3, 'Reinigingsspray','Reiniginsspray_ontsmettend.jpg','','','','',0,21),
(47, 8, 'Sanitair reiniger','sanitair_reiniger_nettoyant-sanitaire.jpg','','','','',0,21),
(48, 7, 'Schuurborstels','schuurborstels.jpg','','','','',0,21),
(49, 6, 'Servetten','servetten.jpg','','','','',0,21),
(50, 7, 'Straatveger','straatveger.jpg','','','','',0,21),
(51, 9, 'Grilo','tegen_groene_aanslag_contre_depots_verts.jpg','','','','',0,21),
(52, 7, 'Toiletborstel','toiletborstel.jpg','','','','',0,21),
(53, 6, 'Toiletpapier 42 rollen','toiletpapier_42_rollen.jpg','','','','',0,21),
(54, 6, 'Toiletpapier 48 rollen','toiletpapier_48_rollen.jpg','','','','',0,21),
(55, 6, 'Toiletpapier coreless','toiletpapier_coreless.jpg','','','','',0,21),
(56, 6, 'Tork facial tissues','tork_facial_tissues.jpg','','','','',0,21),
(57, 6, 'Tork toiletpapier','tork_toiletpapier_72_rollen.jpg','','','','',0,21),
(58, 7, 'Vaatdoeken','vaatdoeken.jpg','','','','',0,21),
(59, 13, 'Vuilzakken','vuilzakken.jpg','','','','',0,21),
(60, 1, 'Wash vloeibaar','wash_vloeibaar_vaatwasmiddel_met_chloor.jpg','','','','',0,21),
(61, 11, 'Vloeibaar wasmiddel','wasmiddel_lessive.jpg','','','','',0,21),
(62, 8, 'WC-cleaner','wc-cleaner.jpg','','','','',0,21),
(63, 3, 'Wegwerphandschoenen','wegwerphandschoenen.jpg','','','','',0,21),
(64, 9, 'Vileda Wrapmaster','wrapmaster_vileda.jpg','','','','',0,21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `product_opties` (
                                                  `optie_id` int(4) UNSIGNED NOT NULL,
                                                  `optie_titel` varchar(255) NOT NULL,
                                                  `optie_naam` varchar(255) NOT NULL,
                                                  `eenheidsprijs` decimal(7,2) NOT NULL,
                                                  `product_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product_opties` (`optie_id`, `optie_titel`, `optie_naam`, `eenheidsprijs`, `product_id`) VALUES
(1, 'Soort', 'Aluminium', '0.00', 4),
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
    MODIFY `optie_id` int(4) NOT NULL AUTO_INCREMENT;
-- --------------------------------------------------------

--
-- Table structure for table `users`
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
                         `telefoon_nr` char(15) NOT NULL DEFAULT '',
                         `bedrijfsnaam` varchar(50),
                         `btw_nr` char(20),
                         `user_level` enum('User','Admin') NOT NULL DEFAULT 'User',
                         `activatie_code` varchar(50) NOT NULL DEFAULT '',
                         `terugkeer_code` varchar(255) NOT NULL DEFAULT '',
                         `reset_code` varchar(50) NOT NULL DEFAULT ''

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `voornaam`, `achternaam`, `email`, `wachtwoord`, `registratie_datum`, `adres_straat`, `adres_nr`, `adres_postcode`, `adres_plaats`, `telefoon_nr`, `user_level`) VALUES
(1, 'Bart', 'Leers', 'bart@leers.pro', '$2y$10$B6tYxS6LVvbeNo6FWRLbpOPzRJwOc2FLxYxHgQ4BRuYj8Q00fbzlS', '2020-11-25 12:00:00', 'Holstraat', '29/0001', '8790', 'Waregem', '0494300380', 'Admin'),
(2, 'Test', 'Delga', 'test@delga.be', '$2y$10$1/NmTZ10uqfoaDotJmiaIu6k0I99pcdAatZgFqmNzn/sgsYgXkHrq', '2020-12-08 18:00:00', 'Voorzienigheidsstraat', '18', '8500', 'Kortrijk', '0494300380', 'User');



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
  MODIFY `order_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producten`
--
ALTER TABLE `producten`
    MODIFY `product_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
    MODIFY `categorie_id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;


