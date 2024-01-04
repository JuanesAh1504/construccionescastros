-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2023 a las 16:00:31
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `castro'ssolucion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `documentoId` varchar(10) NOT NULL,
  `tipoContribuyente` varchar(100) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  `nombreComercial` varchar(300) NOT NULL,
  `tipoDocumento` varchar(100) NOT NULL,
  `numeroDocumento` varchar(100) NOT NULL,
  `primerNombre` varchar(100) NOT NULL,
  `segundoNombre` varchar(100) NOT NULL,
  `primerApellido` varchar(100) NOT NULL,
  `segundoApellido` varchar(100) NOT NULL,
  `razonSocial` varchar(400) NOT NULL,
  `ciudad` varchar(400) NOT NULL,
  `direccion` varchar(400) NOT NULL,
  `telefonoCelular` varchar(100) NOT NULL,
  `correoElectronico` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `documentoId`, `tipoContribuyente`, `regimen`, `nombreComercial`, `tipoDocumento`, `numeroDocumento`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `razonSocial`, `ciudad`, `direccion`, `telefonoCelular`, `correoElectronico`) VALUES
(9, '88272', 'Persona natural', 'No responsable de IVA', 'GERG', 'Cédula de ciudadanía', '1036518302', 'DIEGO', 'ALEJANDRO', 'ALVAREZ', 'HOLGUIN', 'JUAN ESTEBAN', 'YOLOMBÓ', 'Carrera 10 #10 F - 11', 'ERTH', 'ERTH'),
(10, '82863', 'Persona natural', 'Responsable del impuesto sobre las ventas - IVA', 'GERG', 'Tarjeta de identidad', '2345235', '32', '2ERT', 'GEW', 'TREH', 'JUAN SEBASTIAN', '3EG', 'GWER', 'WERG', 'GER'),
(11, '47596', 'Persona natural', 'No responsable de IVA', 'PARROQUIA SANTÍSIMA TRINIDAD', 'NIT', '23424', 'PARROQUIA', 'TRINIDAD', 'DEL', 'LLANO', 'PARROQUIA LA SANTÍSIMA TRINIDAD DEL LLANO', 'Girardota', 'carrera ', '2896523', 'trinidad@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratosgenerados`
--

CREATE TABLE `contratosgenerados` (
  `id` int(11) NOT NULL,
  `numerocontrato` varchar(10) NOT NULL,
  `valorPago1` varchar(10) NOT NULL,
  `valorPago2` varchar(10) NOT NULL,
  `valorPago3` varchar(10) NOT NULL,
  `valorPago4` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contratosgenerados`
--

INSERT INTO `contratosgenerados` (`id`, `numerocontrato`, `valorPago1`, `valorPago2`, `valorPago3`, `valorPago4`) VALUES
(10, '97453', '100.000', '', '', ''),
(11, '97453', '10.000', '', '', ''),
(12, '20481', '228.770', '228.770', '228.770', '76.256'),
(14, '59156', '660.346', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL,
  `documentoId` varchar(5) NOT NULL,
  `fechaCotizacion` varchar(30) NOT NULL,
  `fechaCotizacionFin` varchar(20) NOT NULL,
  `organizacionEmpresas` varchar(150) NOT NULL,
  `alcanceObra` varchar(100) NOT NULL,
  `material` varchar(200) NOT NULL,
  `metros_unidades` varchar(500) NOT NULL,
  `precio_unitario` varchar(500) NOT NULL,
  `cantidad` varchar(500) NOT NULL,
  `precio_total` varchar(500) NOT NULL,
  `iva` varchar(100) NOT NULL,
  `totalIva` varchar(100) NOT NULL,
  `retefuente` varchar(100) NOT NULL,
  `totalRetefuente` varchar(100) NOT NULL,
  `totalPorTodo` varchar(100) NOT NULL,
  `totalValores` varchar(15) NOT NULL,
  `totalNetoInput` varchar(30) NOT NULL,
  `totalIVAInput` varchar(30) NOT NULL,
  `totalRetefuenteTablaInput` varchar(30) NOT NULL,
  `totalPorTodoTablaInput` varchar(30) NOT NULL,
  `dias` varchar(100) NOT NULL,
  `manoObra` varchar(500) NOT NULL,
  `porcentajeAdmin` varchar(200) NOT NULL,
  `porcentajeUtilidad` varchar(200) NOT NULL,
  `alquilerEquipos` varchar(500) NOT NULL,
  `transporte` varchar(500) NOT NULL,
  `elementosProteccion` varchar(500) NOT NULL,
  `Dotacion` varchar(500) NOT NULL,
  `Porcentaje1` varchar(10) NOT NULL,
  `Porcentaje2` varchar(10) NOT NULL,
  `Porcentaje3` varchar(10) NOT NULL,
  `Porcentaje4` varchar(10) NOT NULL,
  `valorTotalCotizacion` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`id`, `documentoId`, `fechaCotizacion`, `fechaCotizacionFin`, `organizacionEmpresas`, `alcanceObra`, `material`, `metros_unidades`, `precio_unitario`, `cantidad`, `precio_total`, `iva`, `totalIva`, `retefuente`, `totalRetefuente`, `totalPorTodo`, `totalValores`, `totalNetoInput`, `totalIVAInput`, `totalRetefuenteTablaInput`, `totalPorTodoTablaInput`, `dias`, `manoObra`, `porcentajeAdmin`, `porcentajeUtilidad`, `alquilerEquipos`, `transporte`, `elementosProteccion`, `Dotacion`, `Porcentaje1`, `Porcentaje2`, `Porcentaje3`, `Porcentaje4`, `valorTotalCotizacion`, `estado`) VALUES
(181, '28628', '2023-12-04', '2023-12-07', '1036518302', 'HOLA', '', '', '', '', '', '', '', '', '', '', '', '40.000', '7.600', '800', '48.400', '3', '19%', '30%', '30%', '2%', '4%', '5%', '6%', '10%', '46%', '24%', '35%', '94.864', 1),
(182, '28628', '', '', '', '', 'GRE', 'UNIDADES', '10.000', '4', '40.000', '19', '7.600', '2', '800', '48.400', '94.864', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(183, '20481', '2023-11-29', '2023-12-15', '1036518302', 'REPARACIÓN COCINA', '', '', '', '', '', '', '', '', '', '', '', '320.000', '60.800', '2.400', '383.200', '16', '19%', '10%', '14%', '12%', '18%', '10%', '10%', '30', '30', '30', '10', '762.568', 1),
(184, '20481', '', '', '', '', 'CEMENTO', 'M2', '30.000', '4', '120.000', '19', '22.800', '2', '2.400', '145.200', '288.948', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(185, '20481', '', '', '', '', 'MADERA', 'LINEAL', '20.000', '10', '200.000', '19', '38.000', '', '', '238.000', '473.620', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(186, '74986', '2023-12-08', '2023-12-18', '1036518302', 'ger', '', '', '', '', '', '', '', '', '', '', '', '24', '0', '0', '24', '10', '', '', '', '', '', '', '', '', '', '', '', '24', 0),
(187, '74986', '', '', '', '', 'ge', 'g', '24', '1', '24', '', '0', '', '', '24', '24', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(188, '74986', '2023-12-08', '2023-12-18', '1036518302', 'ger', '', '', '', '', '', '', '', '', '', '', '', '24', '0', '0', '24', '10', '', '', '', '', '', '', '', '', '', '', '', '24', 0),
(189, '74986', '', '', '', '', 'ge', 'g', '24', '1', '24', '', '0', '', '', '24', '24', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0),
(190, '59156', '2023-12-10', '2023-12-14', '2345235', 'MAPALE', '', '', '', '', '', '', '', '', '', '', '', '350.780', '99.734', '70.179', '520.693', '4', '400.000', '12000', '', '', '', '', '', '50%', '', '', '', '1.320.693', 1),
(191, '59156', '', '', '', '', 'HOLA', 'EQ1', '10.000', '5', '50.000', '19', '9.500', '2', '1.000', '60.500', '460.500', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(192, '59156', '', '', '', '', 'MAPAEL', '23', '50.130', '6', '300.780', '30', '90.234', '23', '69.179', '460.193', '860.193', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastoscontratos`
--

CREATE TABLE `gastoscontratos` (
  `id` int(11) NOT NULL,
  `numeralPorcentaje` varchar(3) NOT NULL,
  `porcentaje` varchar(10) NOT NULL,
  `idContrato` varchar(10) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `precio` varchar(10) NOT NULL,
  `total` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gastoscontratos`
--

INSERT INTO `gastoscontratos` (`id`, `numeralPorcentaje`, `porcentaje`, `idContrato`, `producto`, `precio`, `total`) VALUES
(47, '1', '30', '20481', 'CEMENTO', '13.000', ''),
(48, '1', '30', '20481', 'BULTO DE TIERRA', '50.000', ''),
(49, '', '', '', '', '', '20.831');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombreRol` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombreRol`) VALUES
(1, 'Administrador del sistema'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `nombreCompleto` varchar(30) NOT NULL,
  `apellidoCompleto` varchar(30) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `correoElectronico` varchar(100) NOT NULL,
  `numeroIdentificacion` varchar(20) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `contrasena` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol`, `nombreCompleto`, `apellidoCompleto`, `celular`, `correoElectronico`, `numeroIdentificacion`, `usuario`, `contrasena`) VALUES
(1, 1, 'Juan Esteban', 'Álvarez Holguín', '3008244184', 'juanestebanalvarezholguin@gmail.com', '1036518302', 'JuanesAh1504', '15041504');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contratosgenerados`
--
ALTER TABLE `contratosgenerados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastoscontratos`
--
ALTER TABLE `gastoscontratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `contratosgenerados`
--
ALTER TABLE `contratosgenerados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT de la tabla `gastoscontratos`
--
ALTER TABLE `gastoscontratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
