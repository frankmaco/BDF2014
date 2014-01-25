

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bdf1312`
--
CREATE DATABASE IF NOT EXISTS `bdf1312` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bdf1312`;

-- --------------------------------------------------------

--
-- Table structure for table `appusers`
--

DROP TABLE IF EXISTS `appusers`;
CREATE TABLE IF NOT EXISTS `appusers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `appusers`
--

INSERT INTO `appusers` (`id`, `username`, `userpassword`) VALUES
(3, 'Frank2', '$2y$12$Qvd3RKV0cxhdgiGRVOo/rev2sEsixWxDMwTAYYj.jSwj.oKqXsCqe'),
(4, 'Frank1', '$2y$12$kCi6pQo.3nayDvsRhctkO..bNFrJpaEXDiFtzSJS0IRA380vqtRYO'),
(5, 'Jon', '$2y$12$fW23tXY40t1U5FajFnWq4uEiFubPQmqa44D3Bmu9owIJesnGkWtK.'),
(6, 'Sue3', '$2y$12$Jck4VoTsmwBamT9RFxIYJuOIwiXX2ieOkL4h0cq73pykvOYJ4EosK'),
(11, 'Frank3', '$2y$12$nmhe5skeM/gnSKprBwfAdOgC5aFU3Pz0pDDQFLo95ngxe.gnnTaU.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4294967295 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(4294967295, 'super_admin', '$2y$12$mTnc71DUlFoUHgNYtNr7SuGlbbVHsJ.8ipQtIuJ59znSlxtQvc3kO');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
