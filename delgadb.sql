
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

INSERT INTO `categorie` (`categorie_id`, `categorie_naam`) VALUES
(1, 'Vloerreinigers'),
(2, 'Allesreinigers'),
(3, 'Vaatreinigers'),
(4, 'Sanitairreinigers'),
(5, 'Ontvetters'),
(6, 'Wasmiddelen'),
(7, 'Papierwaren'),
(8, 'Toiletartikelen'),
(9, 'Speciaal gamma');

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
(1, 1, 'REUKWEGNEMER 5L','','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','','Vrijwaren tegen de koude.',25,21),
(2, 1, 'VLOERZEEP GROEN 5L','','','Deze vloerzeep is iets enigs voor het onderhoud van uw vloeren en geeft een aangename geur. <br>Onze vloerzeep is geschikt voor alle vloeren.','5 liter','',14,21),
(3, 1, 'INDUSTRIEREINIGER 10L','','','Dit is onze krachtige allesreiniger, is sterk geconcentreerd en dient voor hetafwassen van allerhande oppervlakten.<br>Verwijdert zonder moeite teer en andere vuilen vlekken op vloeren,<br>zeer goed geschikt voor garages en werkplaatsen.','10 liter','',40,21),
(4, 1, 'ZILVERGLANS 5L','','','Dit is een product waarmee allerlei vloeren gedweild kunnen worden. <br>Het heeft een aangename eucalyptusgeur en doet uw vloer glanzen. <br>Zeer geschikt voor moderne vloeren.','5 liter','',25,21),
(5, 3, 'DETERGENT 1L','','','Onze detergent is een afwasmiddel dat geen schadelijke stoffen bevat en die de handen beschermt.<br>Is hoog van concentraat en is aanbevolen voor vaat, linnen met de hand te wassen, auto’s, enz.<br>Dosering: 8 gram per afwasbeurt.','6 x 1 liter','',2,21),
(6, 3, 'DETERGENT 5L','','','Onze detergent is een afwasmiddel dat geen schadelijke stoffen bevat en die de handen beschermt.<br>Is hoog van concentraat en is aanbevolen voor vaat, linnen met de hand te wassen, auto’s, enz.<br>Dosering: 8 gram per afwasbeurt.<br>Verpakking: 5 liter','', '',18,21),
(7, 3, 'AFWASPOEDER 10 KG','','',' Deze vaatpoeder wast grondig, lost alle vetten op en verwijdert alle voedselresten en geuren. Geschikt voor alle machines.<br>Dosering: 1 gram per 1 liter water. Verpakking: 10 kg','','SPECIAAL VOOR HORECA, GEMEENSCHAPPEN EN INDUSTRIE.',2,21),
(8, 3, 'VLOEIBAAR WASMIDDEL VOOR VAATWAS','','','Dit is een wasmiddel voor de vaatwasser die alle vetten oplost en die bovendien zeer geschikt is voor industriële afwasmachines.<br>Dosering: zoals aangegeven door de fabrikant.<br>Verpakking: 4 x 5 liter of 25 liter','', '',2,21),
(9, 3, 'GLAZENWAS','','','Een reuk- en smaakloos product, dat speciaal geschikt is voor horecabedrijven.<br>Het ontvet, ontgeurt, ontsmet en geeft een mooie glans aan glazen, ruiten en spiegels.<br>Dosering: 8 gram per afwasbak.<br>Verpakking: 6 x 1 liter','','',2,21),
(10, 3, 'PROF ONTKALKER VOOR INOX EN KERAMIEK','','','Desoxyderende ontkalkende snelreiniger voor keuken en sanitair.<br>TOEPASSING: elke keukenuitrusting in inox, plastic, keramiek, porselein en email die bestand zijn tegen zuren.<br>Dosering: 1/10 tot ½ gebruik maken van een vod.<br>Overvloedig naspoelen.<br>Biologisch afbreekbaar.','','VEILIGHEIDSNORMEN:<br>§2: Buiten bereik houden van kinderen.<br>§24: contact vermijden met de huid.',2,21),
(11, 3, 'SCHUURCREME','','',' Onze schuurcrème is een product dat zeer doeltreffend is in horecazaken,<br>omdat het een goede werking heeft bij het reinigen van potten en pannen.<br>Onze schuurcrème is bovendien ook geschikt voor het reinigen van keukens en inox oppervlakten.','','',2,21),
(12, 3, 'SPOELMIDDEL VOOR AFWASMACHINES','','','Dit spoelmiddel is uitstekend geschikt voor zowel horeca als huishoudelijk gebruik.<br>Het geeft een mooie glans aan de afwas en beschermt het bovendien tegen kalkaanslag.<br>Past voor alle soorten afwasmachines.<br>Verpakking: 5 liter','','',2,21),
(13, 2, 'ALLESREINIGER POMPELMOES','','','Deze allesreiniger is zeer geschikt voor linoleum, tegels, houtwerk, email en alle andere afwasbare oppervlakken, lavabo’s, badkuipen, toonbanken.<br>Dosering: 2 à 3 doppen op ½ emmer water<br>Glaswerk, ruiten, spiegels, enz.<br>½ dop op een ½ emmer water.<br>Extra vuile plekken zoals teer, olie, vet, onverdund gebruiken.<br>Verpakking: 5 liter','','',2,21),
(14, 5, 'PROF ONTVETTER','ontvetter_5L_pro.jpg','','Deze ontvetter is zeer geschikt voor het reinigen van dampkappen, keukenmateriaal, vloeren en muren.<br>Speciaal gemaakt om dierlijke en andere vetten los te weken en op te lossen in grootkeukens en slachterijen.<br>Gebruik: DELGA ontvetter verdunnen 1/15 in heet water. De oplossing aanbrengen en circa 4 min. laten inwerken. Daarna goed naspoelen met warm water.','','Veiligheid: Contact met de ogen en de huid vermijden. <br>Buiten bereik van kinderen houden.<br>Best gebruiken met rubberen of plastieken handschoenen. <br>Na contact met de ogen onmiddellijk overvloedig met water spoelen en de dokter raadplegen. <br>Antigifcentrum: tel. (+32) 070/245 245.',20,21),
(15, 6, 'ARIEL','ariel.JPG','','Dit product ','','',25,21),
(16, 6, 'ARIEL HYDRACTIV','ariel_hydractiv.JPG','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','','Vrijwaren tegen de koude.',25,21),
(17, 6, 'ariel professional waspoeder','ariel_professional_waspoeder_15kg.JPG','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','15 kg','Vrijwaren tegen de koude.',25,21),
(18, 6, 'biotex blauw voorwas','biotex_blauw_voorwas_500gr','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','500 gr','Vrijwaren tegen de koude.',25,21),
(19, 1, 'borstelstelen','borstelstelen.JPG','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','','Vrijwaren tegen de koude.',25,21),
(20, 6, 'broxoMatic','broxoMatic.JPG','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','','Vrijwaren tegen de koude.',25,21),
(21, 6, 'dash','dash.JPG','','Dit product ontgeurt en hygiëniseert met zijn frisse geur onder meer urinoirs, wc’s, burelen, scholen, gootstenen, riolen, …','','Vrijwaren tegen de koude.',25,21);
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `user_id` mediumint(6) UNSIGNED NOT NULL,
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


