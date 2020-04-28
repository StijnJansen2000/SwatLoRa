-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 28 apr 2020 om 12:42
-- Serverversie: 10.3.15-MariaDB
-- PHP-versie: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swatlora`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `lowest` varchar(6) NOT NULL DEFAULT '7cfc00',
  `llFromSnr` int(3) NOT NULL DEFAULT 0,
  `llToSnr` int(3) NOT NULL DEFAULT 3,
  `llFromRssi` int(3) NOT NULL DEFAULT 0,
  `llToRssi` int(3) NOT NULL DEFAULT 75,
  `low` varchar(6) NOT NULL DEFAULT '1e90ff',
  `lFromSnr` int(3) NOT NULL DEFAULT 4,
  `lToSnr` int(3) NOT NULL DEFAULT 6,
  `lFromRSSI` int(3) NOT NULL DEFAULT 76,
  `lToRSSI` int(3) NOT NULL DEFAULT 100,
  `medium` varchar(6) NOT NULL DEFAULT 'ffff00',
  `mFromSnr` int(3) NOT NULL DEFAULT 7,
  `mToSnr` int(3) NOT NULL DEFAULT 8,
  `mFromRssi` int(3) NOT NULL DEFAULT 101,
  `mToRssi` int(3) NOT NULL DEFAULT 115,
  `high` varchar(6) NOT NULL DEFAULT 'ffa500',
  `hFromSnr` int(3) NOT NULL DEFAULT 9,
  `hToSnr` int(3) NOT NULL DEFAULT 11,
  `hFromRssi` int(3) NOT NULL DEFAULT 116,
  `hToRssi` int(3) NOT NULL DEFAULT 125,
  `highest` varchar(6) NOT NULL DEFAULT 'ff0000',
  `hhFromSnr` int(3) NOT NULL DEFAULT 12,
  `hhToSnr` int(3) NOT NULL DEFAULT 255,
  `hhFromRssi` int(3) NOT NULL DEFAULT 126,
  `hhToRssi` int(3) NOT NULL DEFAULT 150,
  `snrLowest` int(4) NOT NULL DEFAULT 10,
  `snrLow` int(4) NOT NULL DEFAULT 10,
  `snrMed` int(4) NOT NULL DEFAULT 10,
  `snrHigh` int(4) NOT NULL DEFAULT 10,
  `snrHighest` int(4) NOT NULL DEFAULT 10,
  `rssiLowest` int(4) NOT NULL DEFAULT 10,
  `rssiLow` int(4) NOT NULL DEFAULT 10,
  `rssiMed` int(4) NOT NULL DEFAULT 10,
  `rssiHigh` int(4) NOT NULL DEFAULT 10,
  `rssiHighest` int(4) NOT NULL DEFAULT 10,
  `config_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `colors`
--

INSERT INTO `colors` (`id`, `lowest`, `llFromSnr`, `llToSnr`, `llFromRssi`, `llToRssi`, `low`, `lFromSnr`, `lToSnr`, `lFromRSSI`, `lToRSSI`, `medium`, `mFromSnr`, `mToSnr`, `mFromRssi`, `mToRssi`, `high`, `hFromSnr`, `hToSnr`, `hFromRssi`, `hToRssi`, `highest`, `hhFromSnr`, `hhToSnr`, `hhFromRssi`, `hhToRssi`, `snrLowest`, `snrLow`, `snrMed`, `snrHigh`, `snrHighest`, `rssiLowest`, `rssiLow`, `rssiMed`, `rssiHigh`, `rssiHighest`, `config_id`) VALUES
(1, '7cfc00', 0, 3, 0, 115, '1e90ff', 4, 6, 116, 125, 'ffff00', 7, 8, 116, 130, 'ffa500', 9, 11, 116, 125, 'ff0000', 12, 255, 131, 168, 10, 10, 10, 10, 10, 20, 15, 10, 10, 5, 4),
(2, '7cfc00', 0, 3, 0, 75, '1e90ff', 4, 6, 76, 100, 'ffff00', 7, 8, 101, 115, 'ffa500', 9, 11, 116, 125, 'ff0000', 12, 255, 126, 150, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 1),
(3, '7cfc00', 0, 3, 0, 75, '1e90ff', 4, 6, 76, 100, 'ffff00', 7, 8, 101, 115, 'ffa500', 9, 11, 116, 125, 'ff0000', 12, 255, 126, 150, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 14);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `config`
--

CREATE TABLE `config` (
  `config_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `host` varchar(225) NOT NULL,
  `provider` varchar(225) NOT NULL,
  `token` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `config`
--

INSERT INTO `config` (`config_id`, `name`, `host`, `provider`, `token`) VALUES
(1, 'SwatID', 'sentiloapi.vinaros.es', 'swatid', '390b22ca1e41eeab8d47ea5a613a2206b649702232b6c4503396e277b6365eef'),
(4, 'LoraCoverage', 'sentilo.dival.es:8081', ' vilamarxant@payin', '142dd977bbd42ac25358d30643aea84d97d5d569445f93746ca888a7b110fa42'),
(14, 'vinaros@swat', 'sentilo.dival.es:8081', 'vinaros@swat', '959728b5e5e3ecffb58e31105b6c5a96c61634e8b6164c0e9efea80d0d7e4d6b');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `data`
--

CREATE TABLE `data` (
  `data_id` int(11) NOT NULL,
  `dataName` varchar(255) NOT NULL,
  `longitude` varchar(225) NOT NULL,
  `latitude` varchar(225) NOT NULL,
  `gpsquality` varchar(255) NOT NULL,
  `rssi` varchar(255) NOT NULL,
  `snr` varchar(255) NOT NULL,
  `oneValue` varchar(255) NOT NULL,
  `dateFrom` varchar(225) NOT NULL,
  `dateTo` varchar(225) NOT NULL,
  `component` varchar(225) NOT NULL,
  `gateway_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `data`
--

INSERT INTO `data` (`data_id`, `dataName`, `longitude`, `latitude`, `gpsquality`, `rssi`, `snr`, `oneValue`, `dateFrom`, `dateTo`, `component`, `gateway_id`) VALUES
(18, 'TestoneValue', '', '', '', '', '', 'LoraCoverageVIPAC01S05', '19/03/2020T17:46:00', '19/03/2020T23:47:00', 'LoraCoverageVIPAC01', '18'),
(19, 'New', '', '', '', '', '', 'LoraCoverageVIPAC01S05', '19/03/2020T11:46:00', '19/03/2020T22:47:00', 'LoraCoverageVIPAC01', '18'),
(27, 'testData', 'LoraCoverageVIPAC01S04', 'LoraCoverageVIPAC01S03', 'LoraCoverageVIPAC01S01', 'LoraCoverageVIPAC01S01', 'LoraCoverageVIPAC01S02', '', '01/04/2020T12:00:00', '04/04/2020T13:00:00', 'LoraCoverageVIPAC01', '11'),
(30, 'Villa', 'LoraCoverageVIPAC01S04', 'LoraCoverageVIPAC01S03', 'LoraCoverageVIPAC01S05', 'LoraCoverageVIPAC01S01', 'LoraCoverageVIPAC01S02', '', '16/04/2020T00:00:00', '16/04/2020T23:59:00', 'LoraCoverageVIPAC01', '22'),
(31, 'NewData', 'LoraCoverageVIPAC01S04', 'LoraCoverageVIPAC01S03', 'LoraCoverageVIPAC01S05', 'LoraCoverageVIPAC01S01', 'LoraCoverageVIPAC01S02', '', '23/04/2020T00:00:00', '23/04/2020T23:59:00', 'LoraCoverageVIPAC01', '23'),
(33, 'Newer', 'LoraCoverageVIPAC01S04', 'LoraCoverageVIPAC01S03', 'LoraCoverageVIPAC01S05', 'LoraCoverageVIPAC01S01', 'LoraCoverageVIPAC01S02', '', '23/04/2020T05:00:00', '23/04/2020T20:00:00', 'LoraCoverageVIPAC01', '23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gateway`
--

CREATE TABLE `gateway` (
  `gateway_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `longitude` varchar(225) NOT NULL,
  `latitude` varchar(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `config_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gateway`
--

INSERT INTO `gateway` (`gateway_id`, `name`, `longitude`, `latitude`, `description`, `config_id`) VALUES
(1, 'Test Gateway', '21', '21', 'Test Gateway', 1),
(11, 'Gateway1', '-0.39', '39.47975', 'Test', 4),
(15, 'Gateway2', '-0.37412', '39.47834', 'Desc2', 4),
(18, 'Test123', '-0.38739', '39.47975', 'Test', 4),
(19, 'Gateway7', '-0.36739', '39.47975', 'Fiets', 4),
(20, 'Gateway 6', '65.2', '-4.2', 'TEst', 1),
(21, 'Testje', '-0.38739', '39.47975', 'testgtwy', 4),
(22, 'Villamarxant', '-0.617676', '39.568329', 'Gateway', 4),
(23, 'New', '-1.137163', '39.922612', 'New Gateway', 4);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ForeignKey` (`config_id`);

--
-- Indexen voor tabel `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexen voor tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexen voor tabel `gateway`
--
ALTER TABLE `gateway`
  ADD PRIMARY KEY (`gateway_id`),
  ADD KEY `config_id` (`config_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `data`
--
ALTER TABLE `data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT voor een tabel `gateway`
--
ALTER TABLE `gateway`
  MODIFY `gateway_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `config` (`config_id`);

--
-- Beperkingen voor tabel `gateway`
--
ALTER TABLE `gateway`
  ADD CONSTRAINT `config_id` FOREIGN KEY (`config_id`) REFERENCES `config` (`config_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
