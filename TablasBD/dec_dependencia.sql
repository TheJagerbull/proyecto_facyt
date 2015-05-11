-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `deca_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_dependencia`
--

CREATE TABLE IF NOT EXISTS `dec_dependencia` (
  `id_dependencia` bigint(20) NOT NULL,
  `dependen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dec_dependencia`
--

INSERT INTO `dec_dependencia` (`id_dependencia`, `dependen`) VALUES
(1, 'COMPUTACION'),
(2, 'OFICINA DE SERVICIOS TELEMATICOS'),
(3, 'MATEMATICA'),
(4, 'SOCIOHUMANISTICA'),
(5, 'BIOLOGIA'),
(6, 'FISICA'),
(7, 'QUIMICA'),
(8, 'BIBLIOTECA'),
(9, 'DECANATO');
