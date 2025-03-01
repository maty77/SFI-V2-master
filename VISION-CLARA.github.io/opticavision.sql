-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2025 a las 11:02:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `opticavision`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `DNI_CLI` int(11) NOT NULL,
  `ID_PROV` int(11) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL,
  `APELLIDO` varchar(30) NOT NULL,
  `CONTACTO` int(11) NOT NULL,
  `DOMICILIO` varchar(40) NOT NULL,
  `CIUDAD` varchar(40) NOT NULL,
  `Disponibilidad` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`DNI_CLI`, `ID_PROV`, `NOMBRE`, `APELLIDO`, `CONTACTO`, `DOMICILIO`, `CIUDAD`, `Disponibilidad`, `Email`) VALUES
(87539, 1, 'German', 'Mendez', 1111111, 'Chubut 190', 'San Rafael', 0, 'gm@hotmail.com'),
(111222, 1, 'Richard', 'Winters', 1111112, 'Siempreviva 512', 'Palermo', 1, 'dickwinters@hotmail.com'),
(288236, 12, 'Fernando', 'Fernandez', 333222, 'Las toninas 198', 'San Rafael', 1, 'ff@hotmail.com'),
(333442, 16, 'Anastasia', 'Gomez', 6666666, 'Jilguero 123', 'Maipu', 1, 'anastasiag@hotmail.com'),
(333444, 12, 'Cira', 'Ojeda', 33334, 'Barrio Militar 23', 'Godoy', 1, 'cira@hotmail.com'),
(334566, 12, 'Nataly', 'Rodas', 887799998, 'San Martin 990', 'Mendoza', 1, 'nr@hotmail.com'),
(999000, 12, 'Charlotte', 'Cannigia', 90009, 'San fernando 8890', 'Mendoza', 1, 'chcgg@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobertura`
--

CREATE TABLE `cobertura` (
  `id_cob` int(11) NOT NULL,
  `cobertura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cobertura`
--

INSERT INTO `cobertura` (`id_cob`, `cobertura`) VALUES
(1, 'SWISS Medical'),
(2, 'OSDE'),
(3, 'IOSFA'),
(4, 'Medife'),
(5, 'SIN Obra Social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `ID_COMPRA` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `ID_PAGO` int(11) DEFAULT NULL,
  `FECHA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`ID_COMPRA`, `ID_PROVEEDOR`, `ID_PAGO`, `FECHA`) VALUES
(1, 847465, 4, '2025-02-13'),
(2, 847465, 4, '2025-02-12'),
(3, 6667423, 3, '2025-02-13'),
(4, 6667423, 1, '2025-02-10'),
(5, 6667423, 1, '2025-02-17'),
(6, 847465, 3, '2025-02-06'),
(7, 838747, 3, '2025-02-03'),
(8, 666775, 1, '2025-02-21'),
(9, 838747, 4, '2025-02-21'),
(10, 847465, 4, '2025-02-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cristales`
--

CREATE TABLE `cristales` (
  `id_cristal` int(11) NOT NULL,
  `tipo_cristal` varchar(10) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cristales`
--

INSERT INTO `cristales` (`id_cristal`, `tipo_cristal`, `precio`) VALUES
(1, 'Monofocal', 10000.00),
(2, 'Bifocal', 15000.00),
(3, 'Progresivo', 20000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `ID_COMPRA` int(11) NOT NULL,
  `ID_PROD` int(11) NOT NULL,
  `CANTPROD` int(11) NOT NULL,
  `TOTALCOMPRA` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detallecompra`
--

INSERT INTO `detallecompra` (`ID_COMPRA`, `ID_PROD`, `CANTPROD`, `TOTALCOMPRA`) VALUES
(2, 1011, 60, 210000.00),
(2, 1017, 78, 1326000.00),
(2, 1012, 100, 1500000.00),
(3, 1010, 90, 270000.00),
(4, 1015, 150, 375000.00),
(5, 1016, 30, 600000.00),
(6, 1019, 10, 200000.00),
(7, 1018, 15, 345000.00),
(8, 1020, 19, 285000.00),
(9, 1021, 25, 450000.00),
(9, 1019, 10, 200000.00),
(10, 1022, 40, 800000.00),
(1, 1022, 10, 200000.00),
(1, 1013, 10, 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `ID_VENTA` int(11) NOT NULL,
  `ID_PROD` int(11) NOT NULL,
  `CANTPROD` int(11) NOT NULL,
  `TOTALVENTA` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`ID_VENTA`, `ID_PROD`, `CANTPROD`, `TOTALVENTA`) VALUES
(1, 1011, 1, 9000.00),
(1, 1013, 1, 6000.00),
(1, 1016, 1, 45000.00),
(2, 1018, 1, 55000.00),
(3, 1019, 1, 45000.00),
(4, 1019, 1, 45000.00),
(5, 1019, 1, 45000.00),
(6, 1017, 1, 35000.00),
(7, 1019, 1, 45000.00),
(7, 1013, 1, 6000.00),
(8, 1015, 1, 6000.00),
(8, 1019, 1, 45000.00),
(9, 1019, 1, 45000.00),
(10, 1018, 1, 55000.00),
(11, 1019, 1, 45000.00),
(12, 1019, 1, 45000.00),
(13, 1019, 1, 45000.00),
(14, 1019, 1, 45000.00),
(15, 1012, 1, 35000.00),
(15, 1018, 1, 55000.00),
(16, 1018, 1, 55000.00),
(16, 1015, 1, 6000.00),
(16, 1016, 1, 45000.00),
(17, 1018, 1, 55000.00),
(17, 1016, 1, 45000.00),
(17, 1011, 1, 9000.00),
(18, 1021, 1, 43000.00),
(19, 1022, 1, 45000.00),
(20, 1022, 1, 45000.00),
(21, 1020, 1, 45000.00),
(21, 1012, 1, 35000.00),
(21, 1015, 1, 6000.00),
(21, 1018, 1, 55000.00),
(22, 1022, 1, 45000.00),
(22, 1021, 1, 43000.00),
(22, 1011, 1, 9000.00),
(22, 1010, 1, 8000.00),
(23, 1017, 1, 35000.00),
(24, 1019, 1, 45000.00),
(24, 1021, 1, 43000.00),
(25, 1020, 1, 45000.00),
(25, 1018, 1, 55000.00),
(25, 1015, 1, 6000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `ID_ESTATUS` int(11) NOT NULL,
  `ESTATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`ID_ESTATUS`, `ESTATUS`) VALUES
(1, 'Nacional'),
(2, 'Importado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_prod` int(11) DEFAULT NULL,
  `cantidad_v` int(11) DEFAULT 0,
  `cantidad_c` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_prod`, `cantidad_v`, `cantidad_c`) VALUES
(1013, 2, 100),
(1014, 0, 50),
(1011, 3, 60),
(1017, 2, 78),
(1012, 2, 100),
(1010, 1, 90),
(1015, 4, 150),
(1016, 3, 30),
(1019, 11, 20),
(1018, 7, 15),
(1020, 2, 19),
(1021, 3, 25),
(1022, 3, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jerarquia`
--

CREATE TABLE `jerarquia` (
  `ID_JER` int(11) NOT NULL,
  `JERARQUIA` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `jerarquia`
--

INSERT INTO `jerarquia` (`ID_JER`, `JERARQUIA`) VALUES
(1, 'Administrador'),
(2, 'Usuario'),
(3, 'Encargado de Compras'),
(4, 'Gerente Comercial'),
(5, 'Gerente Contable'),
(6, 'Encargado de Ventas'),
(7, 'Encargado de Inventario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `ID_MARCA` int(11) NOT NULL,
  `ID_ESTATUS` int(11) NOT NULL,
  `MARCA` varchar(50) NOT NULL,
  `Disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`ID_MARCA`, `ID_ESTATUS`, `MARCA`, `Disponibilidad`) VALUES
(1, 1, 'Infinit', 1),
(2, 1, 'Ranieri', 1),
(3, 1, 'Interlenses Argentina', 1),
(4, 1, 'Optitech', 1),
(5, 2, 'Ray-Ban', 1),
(6, 2, 'Gucci', 1),
(7, 2, 'Maui Jim', 1),
(8, 2, 'Carrera', 1),
(9, 2, 'CooperVision', 1),
(10, 1, 'Reef', 1),
(11, 2, 'Zeiss', 0),
(12, 1, 'Prune', 1),
(13, 2, 'Prada', 1),
(14, 2, 'Vogue', 1),
(15, 1, 'Wanama', 1),
(16, 1, 'Orbital by:Zaira Nara', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_PROD` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) NOT NULL,
  `ID_MARCA` int(11) NOT NULL,
  `PRODUCTO` varchar(40) NOT NULL,
  `PRECIO_VENTA` decimal(10,2) NOT NULL,
  `PRECIO_COMPRA` decimal(10,2) NOT NULL,
  `IMAGEN` varchar(300) NOT NULL,
  `id_tipoprod` int(11) NOT NULL,
  `MODELO` varchar(50) NOT NULL,
  `MATERIAL` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(100) NOT NULL,
  `Disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_PROD`, `ID_PROVEEDOR`, `ID_MARCA`, `PRODUCTO`, `PRECIO_VENTA`, `PRECIO_COMPRA`, `IMAGEN`, `id_tipoprod`, `MODELO`, `MATERIAL`, `DESCRIPCION`, `Disponibilidad`) VALUES
(1010, 666775, 13, 'Cadena Prada Rosa', 8000.00, 3000.00, 'assets/productos/cadena_prada.webp', 3, 'Plastic Pink', 'Plastico', 'Rosa', 1),
(1011, 666775, 15, 'Cadena Wanama Steel', 9000.00, 3500.00, 'assets/productos/cadena_wanama.webp', 3, 'Cadena Metal', 'Metal', '----', 1),
(1012, 838747, 8, 'Lentes de sol Carrera', 35000.00, 15000.00, 'assets/productos/carrera.webp', 4, 'MK3', 'Metal', '---', 1),
(1013, 847465, 3, 'Lentes de contacto COLOR', 6000.00, 500.00, 'assets/productos/interlenses_color.png', 1, 'Semanal color Celeste 001', 'plastico', '----', 1),
(1014, 847465, 9, 'Solucion Lentes de Contacto CooperVISION', 900.00, 400.00, 'assets/productos/coopervision_solucion.webp', 3, 'Limpiador 200ml', '----', '----', 0),
(1015, 6667423, 10, 'Correa Reef', 6000.00, 2500.00, 'assets/productos/correa_reef.jpg', 3, 'Sport sujetador universal', 'Tela', 'Negro liso ', 0),
(1016, 6667423, 6, 'Lentes sol Gucci', 45000.00, 20000.00, 'assets/productos/gucci.png', 4, 'Gucci golden ', 'Metal', 'Dorado', 1),
(1017, 838747, 1, 'Armazon Infinit', 35000.00, 17000.00, 'assets/productos/infinit.webp', 2, 'Black infinit', 'plastico', 'Negro liso ', 1),
(1018, 838747, 14, 'Montura Vogue Black', 55000.00, 23000.00, 'assets/productos/vogue.jpeg', 2, 'Office Black', 'Plastico', '----', 1),
(1019, 838747, 11, 'Armazon Zeiss Transparente', 45000.00, 20000.00, 'assets/productos/zeiss.webp', 2, 'Zeiss 900', 'Plastico', '----', 1),
(1020, 666775, 2, 'Armazon Ranieri rustic', 45000.00, 15000.00, 'assets/productos/armazon-renieri.jpg', 2, 'Ranieri rustic', 'Madera', 'claro', 1),
(1021, 838747, 4, 'Armazon Optitech 82', 43000.00, 18000.00, 'assets/productos/opti_arm.jpg', 2, 'Optitech 82', 'Metal', 'Negro liso ', 1),
(1022, 847465, 5, 'Armazon Ray Ban Golden Black', 45000.00, 20000.00, 'assets/productos/ray_arm.jpg', 2, 'Golden Black', 'Plastico', 'Negro liso ', 1),
(1023, 838747, 13, 'Armazon Prada square', 50000.00, 20000.00, 'assets/productos/prada_arm.jpg', 2, 'Prada Square', 'Metal', 'Metal negro', 1),
(1024, 666775, 5, 'Lentes de sol RayBan sunset', 48000.00, 19000.00, 'assets/productos/sunset_rayban.jpg', 4, 'Sunset beige ray ban', 'Plastico', 'Beige', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id_promo` int(11) NOT NULL,
  `promo` varchar(50) NOT NULL,
  `terminos` varchar(1000) NOT NULL,
  `valor_descuento` decimal(10,0) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id_promo`, `promo`, `terminos`, `valor_descuento`, `activo`) VALUES
(1, 'Envio Gratis', 'lorem lorem lorem lorem lorem lorem', 5, 0),
(2, 'Verano2025', 'lorem lorem lorem lorem', 30, 1),
(3, 'SIN PROMO', 'lorem lorem lorem lorem lorem lorem', 0, 1),
(4, 'MIERCOLES Rebaja', 'hhhhhhhhhhh', 10, 1),
(5, 'Asociados OSDE', 'hhshhshshhhshhsh', 30, 1),
(6, 'Buena vista', 'Valida para compras que incluyan armazones/monturas', 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_PROVEEDOR` int(11) NOT NULL,
  `ID_PROV` int(11) NOT NULL,
  `PROVEEDOR` varchar(40) NOT NULL,
  `CONTACTO` int(11) NOT NULL,
  `DOMICILIO` varchar(30) NOT NULL,
  `CIUDAD` varchar(40) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_PROVEEDOR`, `ID_PROV`, `PROVEEDOR`, `CONTACTO`, `DOMICILIO`, `CIUDAD`, `Email`, `Disponibilidad`) VALUES
(121212, 5, 'Ziltec', 1111222, 'Pueyrredón 4701', 'Carlos paz', 'ziltec@optica.com', 1),
(666775, 12, 'LentesLen MDZ', 1928391, 'Godoy 728', 'Mendoza', 'lenteslen@hotmail.com', 1),
(838747, 5, 'Eyez', 12291221, 'Los Angeles 290', 'Cordoba', 'eyez@hotmail.com', 1),
(847465, 5, 'Optica del Sur', 192883, 'las golondrinas 192 piso 1', 'Cordoba', 'opticasur@hotmail.com', 1),
(909090, 1, 'Optica LookOut', 999999, 'Santa fe 1900', 'CABA', 'opticaLO@hotmail.com', 1),
(6667423, 1, 'Sunset 11', 1123344, 'Entre rios 992', 'Palermo', 'sunset11@hotmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `ID_PROV` int(11) NOT NULL,
  `PROVINCIA_DESC` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`ID_PROV`, `PROVINCIA_DESC`) VALUES
(1, 'Buenos Aires'),
(2, 'Catamarca'),
(3, 'Chaco'),
(4, 'Chubut'),
(5, 'Cordoba'),
(6, 'Corrientes'),
(7, 'Entre Rios'),
(8, 'Formosa'),
(9, 'Jujuy'),
(10, 'La Pampa'),
(11, 'La Rioja'),
(12, 'Mendoza'),
(13, 'Misiones'),
(14, 'Neuquen'),
(15, 'Rio Negro'),
(16, 'Salta'),
(17, 'San Juan'),
(18, 'San Luis'),
(19, 'Santa Cruz'),
(20, 'Santa Fe'),
(21, 'Santiago del Estero'),
(22, 'Tierra del Fuego'),
(23, 'Tucuman');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `id_receta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `ojo_der_esf` varchar(2) NOT NULL,
  `ojo_der_cil` varchar(2) NOT NULL,
  `ojo_izq_esf` varchar(2) NOT NULL,
  `ojo_izq_cil` varchar(2) NOT NULL,
  `archivo_receta` varchar(300) NOT NULL,
  `indice_refraccion` decimal(10,2) NOT NULL,
  `id_cristal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `receta`
--

INSERT INTO `receta` (`id_receta`, `fecha`, `ojo_der_esf`, `ojo_der_cil`, `ojo_izq_esf`, `ojo_izq_cil`, `archivo_receta`, `indice_refraccion`, `id_cristal`) VALUES
(15, '2025-02-22', 'NO', 'SI', 'NO', 'SI', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740220815_Ejemplo_receta.webp', 2.00, 2),
(16, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740221583_WhatsApp Image 2024-10-11 at 1.39.40 PM.jpeg', 0.00, 2),
(17, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740221916_WhatsApp Image 2024-09-17 at 21.58.04.jpeg', 1.00, 3),
(18, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740222057_armazon-renieri.jpg', 2.00, 3),
(19, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740222057_SPRINT 0 (6).png', 2.00, 3),
(20, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740224865_WhatsApp Image 2024-02-07 at 14.18.17.jpeg', 1.00, 2),
(21, '2025-02-22', 'NO', 'SI', 'NO', 'SI', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740224865_WhatsApp Image 2024-02-13 at 17.00.39.jpeg', 2.00, 3),
(22, '2025-02-22', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740231517_WIN_20240917_21_52_59_Pro.jpg', 1.20, 1),
(23, '2025-02-24', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740403438_Captura de pantalla 2023-11-03 184404.png', 1.20, 1),
(24, '2025-02-24', 'NO', 'SI', 'NO', 'SI', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740403438_Captura de pantalla 2023-11-03 185205.png', 1.30, 3),
(25, '2025-02-25', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740489012_Captura de pantalla 2023-11-03 163650.png', 1.00, 2),
(26, '2025-02-25', 'SI', 'NO', 'SI', 'NO', 'C:\\1xampp\\htdocs\\Clases\\VISION CLARA\\SFI-V2-master\\funciones/uploads/1740489012_Captura de pantalla 2023-11-03 163703.png', 2.00, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_tratamientos`
--

CREATE TABLE `receta_tratamientos` (
  `id_receta` int(11) NOT NULL,
  `id_trat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `receta_tratamientos`
--

INSERT INTO `receta_tratamientos` (`id_receta`, `id_trat`) VALUES
(17, 1),
(17, 6),
(18, 1),
(18, 6),
(19, 4),
(20, 2),
(20, 4),
(21, 5),
(21, 6),
(22, 1),
(23, 1),
(24, 6),
(25, 1),
(25, 3),
(26, 1),
(26, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoentrega`
--

CREATE TABLE `tipoentrega` (
  `ID_ENT` int(11) NOT NULL,
  `ENTREGA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipoentrega`
--

INSERT INTO `tipoentrega` (`ID_ENT`, `ENTREGA`) VALUES
(1, 'Entrega Inmediata'),
(2, 'Producto para laboratorio'),
(3, 'MIXTA (Entrega Inm./Laboratorio)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE `tipopago` (
  `ID_PAGO` int(11) NOT NULL,
  `PAGO` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`ID_PAGO`, `PAGO`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta de Credito'),
(3, 'Tarjeta de Debito'),
(4, 'Transferencia Bancaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoproducto`
--

CREATE TABLE `tipoproducto` (
  `id_tipoprod` int(11) NOT NULL,
  `tipoproducto_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipoproducto`
--

INSERT INTO `tipoproducto` (`id_tipoprod`, `tipoproducto_desc`) VALUES
(1, 'Lentes de Contacto'),
(2, 'Montura'),
(3, 'Accesorio'),
(4, 'Lentes de Sol'),
(5, 'Producto Terapeutico y/o Especializado'),
(6, 'Dispositivo Optico Complementario'),
(7, 'Tecnologia Optica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id_trat` int(11) NOT NULL,
  `tipo_trat` varchar(20) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id_trat`, `tipo_trat`, `precio`) VALUES
(1, 'Antirreflejante', 10000.00),
(2, 'Endurecido', 11000.00),
(3, 'Antivaho', 12000.00),
(4, 'Fotocromatico', 14000.00),
(5, 'Polarizado', 13000.00),
(6, 'Luz Azul', 11000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `DNI_U` int(11) NOT NULL,
  `ID_JER` int(11) NOT NULL,
  `ID_PROV` int(11) NOT NULL,
  `CONTRASENA` varchar(15) NOT NULL,
  `NOMBRE` varchar(20) NOT NULL,
  `APELLIDO` varchar(20) NOT NULL,
  `USUARIO` varchar(30) NOT NULL,
  `CONTACTO` int(11) NOT NULL,
  `DOMICILIO` varchar(40) NOT NULL,
  `CIUDAD` varchar(40) NOT NULL,
  `Disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`DNI_U`, `ID_JER`, `ID_PROV`, `CONTRASENA`, `NOMBRE`, `APELLIDO`, `USUARIO`, `CONTACTO`, `DOMICILIO`, `CIUDAD`, `Disponibilidad`) VALUES
(55555, 1, 12, 'matias', 'Matias', 'Gomez', 'mg@administrador.com', 555555, 'Belgrano', 'Tunuyan', 1),
(60606, 2, 22, '111', 'Homero', 'Simpson', 'hs@hotmail.com', 10101, 'Evergreen', 'Maipu', 1),
(66788, 3, 1, 'lara', 'Lara Maria', 'Fort', 'lf@encacompras.com', 777777, 'Godoy 777', 'Maipu', 1),
(83992, 2, 14, 'guri', 'Guri', 'Ojeda', 'go@hotmail.com', 882993, 'Godoy', 'Las Lajas', 0),
(111000, 2, 12, 'marge', 'Marge', 'Simpson', 'ms@hotmail.com', 9900, 'Evergreen', 'Maipu', 1),
(333222, 2, 12, 'pamela', 'Pamela', 'Rey', 'pr_@hotmail.com', 55555, 'San martin 223', 'Las heras', 0),
(455444, 2, 12, 'camila', 'Camila', 'Law', 'cl@hotmail.com', 111100, 'Buenos aires 456', 'Malargüe', 1),
(555666, 2, 17, 'roberto', 'Roberto', 'Fernandez', 'rf@hotmail.com', 77777, 'Alberdi 89', 'San juan', 1),
(778877, 6, 1, 'marta', 'Marta', 'Martius', 'mm@encventas.com', 77778, 'España 1992', 'Maipu', 1),
(884663, 2, 12, 'lisa', 'Lisa Marie', 'Simpson', 'ls@hotmail.com', 883772, 'Evergreen', 'Maipu', 1),
(888333, 7, 12, 'javir', 'Javier', 'Fenix', 'jf@encinventario.com', 8888883, 'San martin 1126', 'Mendoza', 1),
(888999, 2, 12, 'graciela', 'Graciela', 'Moreno', 'grm@hotmail.com', 1112211, 'Reyes 2001', 'Malargüe', 0),
(4445554, 4, 1, 'lily', 'Lily', 'Simons', 'lsl@gercomercial.com', 444444444, 'Casilda 289', 'Mendoza', 1),
(7776667, 5, 1, 'loreley', 'Loreley', 'Martinez', 'lm@gercontable.com', 777777776, 'San juan 1225', 'Mendoza', 1),
(27389112, 1, 1, 'snow', 'Colaruis', 'Snow', 'cs@administrador.com', 1, 'Hunger game 10', 'CABA', 1),
(42518893, 2, 14, 'melin', 'Melina', 'Ojeda', 'melicareli2000@hotmail.com', 777777, 'Godoy', 'Las Lajas', 1),
(77666777, 2, 12, 'aldana', 'Aldana', 'Obregon', 'ao@hotmail.com', 444444, 'Martignac', 'Las heras', 0),
(111111111, 2, 1, 'kina', 'Kina', 'Nardini', '2000@hotmail.com', 88888, 'Godoy', 'Uspallata', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID_VENTA` int(11) NOT NULL,
  `DNI_CLI` int(11) NOT NULL,
  `FECHA` datetime NOT NULL,
  `ID_ENT` int(11) NOT NULL,
  `ID_PAGO` int(11) NOT NULL,
  `id_promo` int(11) NOT NULL,
  `DNI_U` int(11) NOT NULL,
  `id_cob` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`ID_VENTA`, `DNI_CLI`, `FECHA`, `ID_ENT`, `ID_PAGO`, `id_promo`, `DNI_U`, `id_cob`, `total`) VALUES
(1, 999000, '2025-02-19 04:17:38', 1, 1, 5, 111000, 2, 42000.00),
(2, 111222, '2025-02-20 05:37:00', 2, 3, 1, 111000, 3, 52250.00),
(3, 999000, '2025-02-20 05:40:24', 2, 1, 3, 111000, 2, 45000.00),
(4, 111222, '2025-02-20 05:45:35', 2, 1, 3, 111000, 1, 45000.00),
(5, 334566, '2025-02-20 06:00:05', 2, 2, 2, 111000, 1, 31500.00),
(6, 111222, '2025-02-20 08:02:54', 2, 3, 5, 111000, 2, 24500.00),
(7, 999000, '2025-02-20 08:04:05', 3, 4, 1, 111000, 3, 48450.00),
(8, 334566, '2025-02-20 08:12:57', 3, 1, 2, 111000, 5, 35700.00),
(9, 111222, '2025-02-20 08:15:37', 2, 2, 2, 111000, 4, 31500.00),
(10, 334566, '2025-02-20 08:20:27', 2, 1, 2, 111000, 1, 38500.00),
(11, 111222, '2025-02-22 04:00:23', 2, 2, 3, 111000, 2, 45000.00),
(12, 334566, '2025-02-22 04:04:00', 1, 1, 2, 111000, 4, 31500.00),
(13, 999000, '2025-02-22 04:22:48', 2, 1, 1, 111000, 3, 42750.00),
(14, 111222, '2025-02-22 04:29:38', 2, 3, 5, 111000, 2, 31500.00),
(15, 288236, '2025-02-22 04:42:02', 3, 3, 5, 111000, 2, 63000.00),
(16, 111222, '2025-02-22 04:47:08', 3, 4, 3, 111000, 2, 106000.00),
(17, 111222, '2025-02-22 04:53:42', 3, 4, 2, 111000, 2, 76300.00),
(18, 999000, '2025-02-22 07:39:36', 2, 3, 5, 111000, 2, 30100.00),
(19, 111222, '2025-02-22 07:52:18', 2, 4, 1, 111000, 1, 42750.00),
(20, 999000, '2025-02-22 07:57:28', 2, 4, 3, 111000, 1, 45000.00),
(21, 111222, '2025-02-22 07:58:51', 3, 3, 2, 111000, 3, 98700.00),
(22, 334566, '2025-02-22 08:45:32', 3, 3, 5, 111000, 2, 73500.00),
(23, 288236, '2025-02-22 10:37:31', 2, 2, 3, 111000, 5, 35000.00),
(24, 111222, '2025-02-24 10:12:06', 2, 3, 2, 55555, 2, 97300.00),
(25, 111222, '2025-02-25 10:08:20', 3, 2, 5, 42518893, 2, 127400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_receta`
--

CREATE TABLE `venta_receta` (
  `id_venta` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta_receta`
--

INSERT INTO `venta_receta` (`id_venta`, `id_prod`, `id_receta`) VALUES
(22, 1022, 20),
(22, 1021, 21),
(18, 1021, 15),
(19, 1022, 16),
(20, 1022, 17),
(21, 1020, 18),
(21, 1018, 19),
(23, 1017, 22),
(24, 1019, 23),
(24, 1021, 24),
(25, 1020, 25),
(25, 1018, 26);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`DNI_CLI`),
  ADD KEY `FK_PROVINCIA_CLI` (`ID_PROV`);

--
-- Indices de la tabla `cobertura`
--
ALTER TABLE `cobertura`
  ADD PRIMARY KEY (`id_cob`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_COMPRA`),
  ADD KEY `FK_PROVE_COMP` (`ID_PROVEEDOR`),
  ADD KEY `FK_TP_COMP` (`ID_PAGO`);

--
-- Indices de la tabla `cristales`
--
ALTER TABLE `cristales`
  ADD PRIMARY KEY (`id_cristal`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD KEY `ID_PROD` (`ID_PROD`),
  ADD KEY `ID_COMPRA` (`ID_COMPRA`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD KEY `ID_VENTA` (`ID_VENTA`),
  ADD KEY `ID_PROD` (`ID_PROD`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`ID_ESTATUS`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD KEY `id_prod` (`id_prod`);

--
-- Indices de la tabla `jerarquia`
--
ALTER TABLE `jerarquia`
  ADD PRIMARY KEY (`ID_JER`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID_MARCA`),
  ADD KEY `FK_EST_MARC` (`ID_ESTATUS`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_PROD`),
  ADD KEY `FK_MARC_PROD` (`ID_MARCA`),
  ADD KEY `FK_PROV_PROD` (`ID_PROVEEDOR`),
  ADD KEY `FK_PROD_TPPROD` (`id_tipoprod`) USING BTREE;

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id_promo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_PROVEEDOR`),
  ADD KEY `FK_PROVINCIA_PROV` (`ID_PROV`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`ID_PROV`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_cristal` (`id_cristal`);

--
-- Indices de la tabla `receta_tratamientos`
--
ALTER TABLE `receta_tratamientos`
  ADD PRIMARY KEY (`id_receta`,`id_trat`),
  ADD KEY `id_trat` (`id_trat`);

--
-- Indices de la tabla `tipoentrega`
--
ALTER TABLE `tipoentrega`
  ADD PRIMARY KEY (`ID_ENT`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`ID_PAGO`);

--
-- Indices de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  ADD PRIMARY KEY (`id_tipoprod`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id_trat`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`DNI_U`),
  ADD KEY `FK_JER_USU` (`ID_JER`),
  ADD KEY `FK_PROVINCIA_USER` (`ID_PROV`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID_VENTA`),
  ADD KEY `FK_CLI_VEN` (`DNI_CLI`),
  ADD KEY `FK_VEN_TE` (`ID_ENT`),
  ADD KEY `FK_VEN_TP` (`ID_PAGO`),
  ADD KEY `DNI_U` (`DNI_U`),
  ADD KEY `id_promo` (`id_promo`),
  ADD KEY `id_cob` (`id_cob`);

--
-- Indices de la tabla `venta_receta`
--
ALTER TABLE `venta_receta`
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_receta` (`id_receta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cobertura`
--
ALTER TABLE `cobertura`
  MODIFY `id_cob` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cristales`
--
ALTER TABLE `cristales`
  MODIFY `id_cristal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `ID_ESTATUS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jerarquia`
--
ALTER TABLE `jerarquia`
  MODIFY `ID_JER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `ID_PROV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tipoentrega`
--
ALTER TABLE `tipoentrega`
  MODIFY `ID_ENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `ID_PAGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  MODIFY `id_tipoprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id_trat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_PROVINCIA_CLI` FOREIGN KEY (`ID_PROV`) REFERENCES `provincia` (`ID_PROV`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `FK_PROVE_COMP` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedor` (`ID_PROVEEDOR`),
  ADD CONSTRAINT `FK_TP_COMP` FOREIGN KEY (`ID_PAGO`) REFERENCES `tipopago` (`ID_PAGO`);

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detallecompra_ibfk_1` FOREIGN KEY (`ID_PROD`) REFERENCES `producto` (`ID_PROD`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detallecompra_ibfk_2` FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `detalleventa_ibfk_1` FOREIGN KEY (`ID_PROD`) REFERENCES `producto` (`ID_PROD`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalleventa_ibfk_2` FOREIGN KEY (`ID_VENTA`) REFERENCES `venta` (`ID_VENTA`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`ID_PROD`);

--
-- Filtros para la tabla `marca`
--
ALTER TABLE `marca`
  ADD CONSTRAINT `FK_EST_MARC` FOREIGN KEY (`ID_ESTATUS`) REFERENCES `estatus` (`ID_ESTATUS`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_MARC_PROD` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`),
  ADD CONSTRAINT `FK_PROV_PROD` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedor` (`ID_PROVEEDOR`),
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_tipoprod`) REFERENCES `tipoproducto` (`id_tipoprod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `FK_PROVINCIA_PROV` FOREIGN KEY (`ID_PROV`) REFERENCES `provincia` (`ID_PROV`);

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`id_cristal`) REFERENCES `cristales` (`id_cristal`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `receta_tratamientos`
--
ALTER TABLE `receta_tratamientos`
  ADD CONSTRAINT `receta_tratamientos_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receta_tratamientos_ibfk_2` FOREIGN KEY (`id_trat`) REFERENCES `tratamientos` (`id_trat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_JER_USU` FOREIGN KEY (`ID_JER`) REFERENCES `jerarquia` (`ID_JER`),
  ADD CONSTRAINT `FK_PROVINCIA_USER` FOREIGN KEY (`ID_PROV`) REFERENCES `provincia` (`ID_PROV`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_CLI_VEN` FOREIGN KEY (`DNI_CLI`) REFERENCES `cliente` (`DNI_CLI`),
  ADD CONSTRAINT `FK_VEN_TE` FOREIGN KEY (`ID_ENT`) REFERENCES `tipoentrega` (`ID_ENT`),
  ADD CONSTRAINT `FK_VEN_TP` FOREIGN KEY (`ID_PAGO`) REFERENCES `tipopago` (`ID_PAGO`),
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_cob`) REFERENCES `cobertura` (`id_cob`) ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`id_promo`) REFERENCES `promociones` (`id_promo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_receta`
--
ALTER TABLE `venta_receta`
  ADD CONSTRAINT `venta_receta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`ID_VENTA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_receta_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `receta` (`id_receta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_receta_ibfk_3` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`ID_PROD`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
