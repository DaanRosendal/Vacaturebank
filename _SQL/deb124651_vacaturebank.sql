-- MySQL dump 10.16  Distrib 10.1.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: deb124651_vacaturebank
-- ------------------------------------------------------
-- Server version	10.1.44-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','test');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bedrijven`
--

DROP TABLE IF EXISTS `bedrijven`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bedrijven` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `straat` varchar(45) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `hq` varchar(45) NOT NULL,
  `persoon` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefoon` int(20) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `rol` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bedrijven`
--

LOCK TABLES `bedrijven` WRITE;
/*!40000 ALTER TABLE `bedrijven` DISABLE KEYS */;
INSERT INTO `bedrijven` VALUES (1,'Apple','Van Diemenkade 1','1013 CR','Amsterdam','Anthonia van Alem','97059531d@gmail.com',660300176,'$2y$10$bPz/DWVAXnIYWErNP8oXn.JdBSnk/5ThULL35HOMGDjtoWVSOjAxK','ad7a069a53b6b6f92e66b3a24bab86903be6bcbf5244212bafbb03bc5760ba7c',1),(2,'Test Bedrijf','Batavierenstraat 20','3014 JJ','Rotterdam','Goof van Holsteijn','test@daanrosendal.com',610124291,'$2y$10$CYmQY6uWs3sfIVd01ZYEWOx0wOQ7KjfSQMIN/F6Y6LYeTr6WUu.Vu','eca1c8d3df7fde85d770771b0b4c3ffc64be6dbd82cf96e6702c386919e91ead',1),(3,'OnePlus','Isotopenweg 1','3542 AK','Utrecht','Alma van der Pols','daanrosendal18@outlook.com',642478270,'$2y$10$lWiyXLVDKRXM98wDVpFOROmHRAgJ0zXN6AKcaMx0L5h3AWvu9LLWW','918c4fac1faec8dcf8595c11e79233c4609a7abfcd70d410e432b33688e282c0',1),(4,'Test','Brederostraat 15','8023 AN','Zwolle','Pietje','daanrosendal7@hotmail.com',67127371,'$2y$10$7PgHQtrnJVihhrIH24v07eKY1K77G4AifwRHSlvSPmB1mQWNX0LPG','',1),(5,'NS Retail Stations','&lt;script&gt;alert(&quot;hi&quot;)&lt;/scrip','7772 dd','Hardenberg','Tan Go','a#@a.a',12345678,'$2y$10$Ls7KeRjCxQ/4PpAkak40weHR1Pz8NbY908YKFj6k97Xa9v./TfSfG','',1);
/*!40000 ALTER TABLE `bedrijven` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruikers`
--

DROP TABLE IF EXISTS `gebruikers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `straat` varchar(45) NOT NULL,
  `postcode` varchar(7) NOT NULL,
  `woonplaats` varchar(45) NOT NULL,
  `telefoon` int(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `rol` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruikers`
--

LOCK TABLES `gebruikers` WRITE;
/*!40000 ALTER TABLE `gebruikers` DISABLE KEYS */;
INSERT INTO `gebruikers` VALUES (1,'Test Gebruiker','Wipstrikkerallee 23','8023 DR','Zwolle',658115223,'test@daanrosendal.com','$2y$10$mgF7BZ3LpG49O.U9ajynAOipiiRFZ6QO1JC29X0aIRsx4FWgLas/W','9b8a9c5faeaedccbc7be9149be2cb632bf59d24053df8b90295b1adf5ed58906',0),(2,'Berk Luijendijk','Uiterdijkenweg 75','8316 RT','Marknesse',665556066,'daandikzak@hotmail.com','$2y$10$GhFyggy2hkZobclHwHfoUer1aAqtHTYrDNJvWySYNy5XKepX8ETMC','',0),(3,'Dion','Singelberg','qqqq 11','Hardenberg',234567,'a#@a.a','$2y$10$snBucVY45odVgus1Ll/Jbepze8Zr9wEZTYp7/gDVwSmqy5lLWcu6S','',0);
/*!40000 ALTER TABLE `gebruikers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sollicitaties`
--

DROP TABLE IF EXISTS `sollicitaties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sollicitaties` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `sollicitantID` smallint(6) NOT NULL,
  `vacatureID` smallint(6) NOT NULL,
  `motivatie` varchar(5000) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sollicitaties`
--

LOCK TABLES `sollicitaties` WRITE;
/*!40000 ALTER TABLE `sollicitaties` DISABLE KEYS */;
INSERT INTO `sollicitaties` VALUES (1,2,5,'Ea officia ex vero doloribus vel inventore excepturi quam eum voluptatem laborum','2019-07-04'),(3,1,1,'awdawdawd','2019-07-03'),(4,1,3,'Beatae hic sed tempor et ut assumenda incidunt qui Nam','2019-07-04'),(5,1,2,'Ut id cum nihil magna similique aut labore sunt in minim aliquam ad fuga Culpa aut et similique','2019-07-04'),(6,1,6,'Et laudantium veniam esse placeat voluptatem fugit qui','2019-07-04'),(8,2,3,'Similique totam rerum laboriosam sed numquam rerum deserunt consequat Eos deserunt enim ea','2019-07-04'),(12,2,9,'Commodo animi cum enim eum in id','2019-07-04'),(14,1,10,'knawndkl aw<br />\r\nd l<br />\r\nawdl<br />\r\n awl\'<br />\r\nd','2019-07-05'),(15,3,10,'nee, ja geweldig','2020-01-09'),(16,3,12,'a','2020-01-09'),(17,3,9,'a','2020-01-09');
/*!40000 ALTER TABLE `sollicitaties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacatures`
--

DROP TABLE IF EXISTS `vacatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacatures` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `bedrijfID` smallint(6) NOT NULL,
  `functie` varchar(45) NOT NULL,
  `werkstad` varchar(45) NOT NULL,
  `werkstraat` varchar(45) NOT NULL,
  `werkpostcode` varchar(7) NOT NULL,
  `beschrijving` varchar(5000) NOT NULL,
  `opleiding` varchar(45) NOT NULL,
  `uren` varchar(10) NOT NULL,
  `dagen` tinyint(4) NOT NULL,
  `salaris` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacatures`
--

LOCK TABLES `vacatures` WRITE;
/*!40000 ALTER TABLE `vacatures` DISABLE KEYS */;
INSERT INTO `vacatures` VALUES (1,2,'Mondgeur beoordelaar','Amsterdam','Voorburgstraat 151','1059 EX','Heb jij een sterke maag? Word mondgeur beoordelaar! In deze functie onderzoek je of verschillende typen mondproducten (kauwgom, mondwater, tandpasta) hun beoogde effect hebben. ','MBO, HAVO, VWO','32',4,3500,'2019-05-20'),(2,2,'Eendenleider','Tilburg','Van Alkemadestraat 121','5014 MK','Vervoer eenden veilig in en uit de vijvers van het hotel en controleer of ze gezond zijn. ','MBO, HAVO, VWO','24',3,1800,'2019-04-30'),(3,2,'Kauwgomverwijderaar','Eindhoven','Bloemfonteinstraat 91','5642 EE','Onderzoek onderkanten van tafels en stoelen in bijvoorbeeld restaurants en op scholen op de aanwezigheid van kauwgom. Gebruik een schraper om het te verwijderen. ','MBO, HAVO, VWO','32',4,2500,'2019-03-25'),(4,2,'Bedverwarmer','Zwolle','Vondelkade 25','8023 AC','Zie jij jezelf al in een fleece pak 5 minuten door een bed rollen? Dan kun je goed terecht in het Holiday Inn hotel in Zwolle. Onder het motto â€˜alles voor de gasten!â€™ wordt hier deze extra service aangeboden. ','MBO, HAVO, VWO','10-12',2,2800,'2019-06-17'),(5,3,'Docent Nederlands','Zwolle','Brederostraat 89','8023 AR','Les geven over de nederlands taal','MBO, HAVO, VWO','32',4,3500,'2019-06-09'),(7,4,'Poepschepper','Zwolle','Brederostraat 89','8023 AR','Ik zoek een persoon die goed poep kan scheppen<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lobortis metus nunc, quis dictum ipsum auctor et. Nam bibendum et urna non consectetur. Maecenas sed malesuada diam. Ut sed lectus eget purus porta sagittis. Pellentesque pharetra dui elit, ut varius metus vestibulum aliquam. Pellentesque condimentum sagittis odio, sed scelerisque ipsum luctus sed. Curabitur aliquam congue felis id accumsan. Nam in felis ut sem fermentum facilisis dignissim sed elit. Nunc vulputate nec ex ut malesuada.<br />\r\n<br />\r\nNunc ipsum nunc, congue vel metus sit amet, eleifend lacinia nisi. Pellentesque eu bibendum purus. Aenean lacinia efficitur mi, sed vulputate nunc sollicitudin at. Cras gravida est eget felis blandit, in porttitor eros posuere. In vel molestie tellus. Proin pretium ultricies sollicitudin. Sed dolor elit, hendrerit in vehicula non, lacinia quis ex. Sed et blandit dui. In sit amet interdum enim. Sed ornare luctus diam eget scelerisque.<br />\r\n<br />\r\nMorbi ex nunc, hendrerit sed porttitor at, pretium a justo. Praesent malesuada dictum est, vel semper massa viverra ut. Phasellus quis ipsum porttitor, ultrices quam eu, pellentesque mi. Ut elementum in erat vel imperdiet. Nullam suscipit justo dictum velit suscipit egestas. Phasellus vulputate id orci finibus viverra. Nunc congue mi augue, eu tempor odio blandit et. Quisque consectetur vulputate ex. Cras tristique faucibus eros, sed facilisis tortor gravida at. Vivamus tincidunt vel tellus ultricies lobortis. Maecenas pellentesque orci eget turpis mollis gravida.','VMBO, HAVO, HBO','40',7,3500,'2019-03-18'),(8,3,'Professioneel Dammer','Hengelo','Anna Bijnsstraat 143','7552 NB','Ben jij een strategisch master-mind? Kom dammen.','VMBO, HAVO, HBO','36',5,2549,'2019-01-21'),(9,3,'Assistent Goochelaar','Hengelo','Anna Bijnsstraat 143','7552 NB','Riskeer je eigen leven door goochelaarsassistent te worden. Blijf er wel bij lachen; je bent onderdeel van de show! ','VMBO, HAVO, HBO','20',3,3590,'2019-04-08'),(10,1,'Beddentester','Hardenberg','Willebrandt van Oldenburgstraat 85','7772 AL','Test bedden','HBO, WO','32',4,6000,'2019-07-29'),(11,1,'Geurverminderende onderbroekenmaker','Hattem','Kruisstraat 98','8051 GE','Sommige mensen hebben last van, nou ja, extra veel gassen daar beneden. Speciaal voor hen ontwerp jij onderbroeken die deze geuren kunnen reduceren. ','VMBO, HAVO','16',2,1200,'2019-05-06'),(12,1,'Gamer','Zwolle','Pletterstraat 45','8011 VG','Lekker gamen','WO','26-28',3,3456,'2019-07-03'),(13,2,'Pizza proever','Zwolle','Fivel 95','8032 MR','Proef pizza\'s','MBO, HAVO','32',4,3750,'2019-07-04'),(14,5,'Test Vacature','hoofd','ass 101','qqqq 11','Iemand die niet gemotiveerd is','kader','-1',7,-10000,'2020-01-09');
/*!40000 ALTER TABLE `vacatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'deb124651_vacaturebank'
--

--
-- Dumping routines for database 'deb124651_vacaturebank'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-21 13:59:39
