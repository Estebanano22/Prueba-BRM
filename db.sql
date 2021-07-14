-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 14, 2021 at 02:40 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `prueba_brm`
--

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE `compras` (
  `idCompra` varchar(50) NOT NULL,
  `idProducto` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `compras`
--

INSERT INTO `compras` (`idCompra`, `idProducto`, `cantidad`, `total`) VALUES
('60ef613e295e0', 'BRM60ef4cb096d1f', 10, 56000),
('60ef61ca16bf7', 'BRM60ef3d2fa020c', 4, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `idProducto` varchar(50) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `precio` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`idProducto`, `producto`, `cantidad`, `lote`, `fechaVencimiento`, `precio`) VALUES
('BRM60ef3d2fa020c', 'Lata Salchichas Zenu x 12', 6, 'LS7899', '2024-07-14', 5000),
('BRM60ef4cb096d1f', 'Jamon Enlatado 125gr', 20, 'JE0092', '2026-07-14', 5600),
('BRM60ef4d67be101', 'Frijoles x 180gr', 40, 'FL9861', '2024-07-14', 7000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idCompra`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);
