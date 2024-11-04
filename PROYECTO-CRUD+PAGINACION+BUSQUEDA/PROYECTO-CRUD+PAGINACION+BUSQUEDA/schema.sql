CREATE DATABASE rockstarvideogames;
USE rockstarvideogames;

CREATE TABLE `videojuegos` (
  `codigo_videojuego` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `fecha_salida` date NOT NULL,
  `edad_minima` int(11) NOT NULL,
  `genero` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo_videojuego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Agrega más tablas aquí siguiendo el mismo patrón
