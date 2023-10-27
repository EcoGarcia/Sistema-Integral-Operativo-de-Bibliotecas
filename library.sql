-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2023 a las 02:36:33
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `library`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(2, 'Clive Dela Cruz', 'clive@yahoo.com', 'admin', 'f925916e2754e5e03f75dd58a5733251', '2019-04-11 13:56:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colocación`
--

CREATE TABLE `colocación` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `portada` varchar(200) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `isbn` char(25) NOT NULL,
  `cantidad` int(120) NOT NULL,
  `colocación` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `numero`, `nombre`, `portada`, `autor`, `categoria`, `isbn`, `cantidad`, `colocación`) VALUES
(14, 0, 'TECNOLOGIA 2. ', 'portadas/9788490771747.jpg', 'JUAN LUIS FUENTES GOMEZ ', 'Science', '978-2-409-1-2q', 17, ''),
(19, 1, 'ABC del desarrollo organizacional', 'portadas/descarga.jpg', 'Carlos Augusto Audirac Camarena', 'Administración', '123-456-78-89', 15, 'ADM 001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `AdminId` varchar(100) NOT NULL,
  `FullName` varchar(120) NOT NULL,
  `EmailId` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `AdminId`, `FullName`, `EmailId`, `Password`, `Status`, `RegDate`) VALUES
(1, 'SID015', 'Luis Florentino', 'luisflorentinogarciamedina22@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(2, '1', 'Luis', 'lluisga@gmail', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(3, '2', 'Luis', 'lluisga@gmail', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(4, '12', 'Dejame ', 'Dejame@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(5, '13', 'alex', 'alex@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(6, '14', 'Hola', 'Hola@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(7, '15', 'Hola', 'Hola@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(8, '16', 'Hola', 'Hola2@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(9, '17', 'jorge', 'Jorge@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(10, '18', 'Juan', 'Juan@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(11, '22', 'Luis Florentino García Medina', '611910454@utsalamanca.edu.mx', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(12, '25', 'john joseph', '62124214@utsalamanca.edu.mx', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(13, '27', 'Luis', 'Luis@utsalamanca.edu.mx', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(14, '3', 'David', 'David@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(15, '4', 'Gabriela', 'Gabriela@utsalamanca.edu.mx', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(16, '5', 'Luis García', '611910454@utsalamanca.edu.mx', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(17, '3', 'Jorge I', 'JorgeI@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06'),
(18, '4', 'Gael', 'Gael1@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1, '2023-06-06 23:20:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblauthors`
--

CREATE TABLE `tblauthors` (
  `id` int(11) NOT NULL,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(1, 'Anuj kumar', '2017-07-08 12:49:09', '2017-07-08 15:16:59'),
(2, 'Chetan Bhagatt', '2017-07-08 14:30:23', '2017-07-08 15:15:09'),
(3, 'Anita Desai', '2017-07-08 14:35:08', NULL),
(4, 'HC Verma', '2017-07-08 14:35:21', NULL),
(5, 'R.D. Sharma ', '2017-07-08 14:35:36', NULL),
(9, 'fwdfrwer', '2017-07-08 15:22:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblbooks`
--

CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` int(11) DEFAULT NULL,
  `BookPrice` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `RegDate`, `UpdationDate`) VALUES
(1, 'PHP And MySql programming', 5, 1, 222333, 20, '2017-07-08 20:04:55', '2017-07-15 05:54:41'),
(3, 'physics', 6, 4, 1111, 15, '2017-07-08 20:17:31', '2017-07-15 06:13:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(4, 'Romantic', 1, '2017-07-04 18:35:25', '2017-07-06 16:00:42'),
(5, 'Technology', 1, '2017-07-04 18:35:39', '2017-07-08 17:13:03'),
(6, 'Science', 1, '2017-07-04 18:35:55', '0000-00-00 00:00:00'),
(7, 'Management', 0, '2017-07-04 18:36:16', '0000-00-00 00:00:00'),
(8, 'Administración', 1, '2023-06-07 15:01:58', '0000-00-00 00:00:00'),
(9, 'Mecatronica', 1, '2023-06-08 00:35:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblissuedbookdetails`
--

CREATE TABLE `tblissuedbookdetails` (
  `id` int(11) NOT NULL,
  `BookId` int(11) DEFAULT NULL,
  `StudentID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT current_timestamp(),
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `RetrunStatus` int(1) DEFAULT NULL,
  `fine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `StudentID`, `IssuesDate`, `ReturnDate`, `RetrunStatus`, `fine`) VALUES
(1, 1, 'SID002', '2017-07-15 06:09:47', '2017-07-15 11:15:20', 1, 0),
(2, 1, 'SID002', '2017-07-15 06:12:27', '2017-07-15 11:15:23', 1, 5),
(3, 3, 'SID002', '2017-07-15 06:13:40', NULL, 0, NULL),
(4, 3, 'SID002', '2017-07-15 06:23:23', '2017-07-15 11:22:29', 1, 2),
(5, 1, 'SID009', '2017-07-15 10:59:26', NULL, 0, NULL),
(6, 3, 'SID011', '2017-07-15 18:02:55', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblstudents`
--

CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL,
  `StudentId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblstudents`
--

INSERT INTO `tblstudents` (`id`, `StudentId`, `FullName`, `EmailId`, `MobileNumber`, `Password`, `Status`, `RegDate`, `UpdationDate`) VALUES
(1, 'SID002', 'Andrew Braza', 'andrew1@gmail.com', '9865472555', 'f925916e2754e5e03f75dd58a5733251', 1, '2017-07-11 15:37:05', '2019-04-11 14:11:39'),
(4, 'SID005', 'John Roberts', 'john@yahoo.com', '8569710025', '92228410fc8b872914e023160cf4ae8f', 0, '2017-07-11 15:41:27', '2019-04-11 14:12:04'),
(9, 'SID010', 'Rey Tejada', 'rey@gmail.com', '8585856224', 'f925916e2754e5e03f75dd58a5733251', 1, '2017-07-15 13:40:30', '2019-04-11 14:12:27'),
(10, 'SID011', 'Clide Louie', 'CLIDE@gmail.com', '4672423754', 'f925916e2754e5e03f75dd58a5733251', 1, '2017-07-15 18:00:59', '2019-04-11 14:12:50'),
(11, 'SID012', 'Clive Dela Cruz', 'clive21@yahoo.com', '0945208280', '21232f297a57a5a743894a0e4a801fc3', 1, '2019-04-11 13:46:30', NULL),
(12, 'SID014', 'Luis florentino', 'florentino@gmail.com', NULL, '202cb962ac59075b964b07152d234b70', 1, '2023-05-24 21:48:07', NULL),
(13, '1', 'Isaac', 'Isaac@gmail.com', NULL, '202cb962ac59075b964b07152d234b70', 1, '2023-05-24 21:56:14', NULL),
(14, '2', 'rafa', 'rafa@gmail.com', NULL, '202cb962ac59075b964b07152d234b70', 1, '2023-05-24 22:20:24', NULL),
(15, '3', 'rafa', 'rafa@gmail.com', NULL, '202cb962ac59075b964b07152d234b70', 1, '2023-05-24 22:22:05', NULL),
(16, '4', 'gael', 'g@gmail.com', NULL, '250cf8b51c773f3f8dc8b4be867a9a02', 1, '2023-05-24 22:38:02', '2023-05-24 22:41:45'),
(17, '5', 'flore', 'darksoul@gmail.com', NULL, '250cf8b51c773f3f8dc8b4be867a9a02', 1, '2023-05-24 22:44:00', '2023-05-24 22:45:07'),
(18, '6', 'prueba', 'hola@gmail.com', NULL, '250cf8b51c773f3f8dc8b4be867a9a02', 1, '2023-05-25 06:16:09', '2023-05-25 06:17:31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colocación`
--
ALTER TABLE `colocación`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblauthors`
--
ALTER TABLE `tblauthors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `StudentId` (`StudentId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `colocación`
--
ALTER TABLE `colocación`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tblauthors`
--
ALTER TABLE `tblauthors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
