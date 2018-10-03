-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 03 Octobre 2018 à 10:35
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.2.9-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `VallesBaques`
--

-- --------------------------------------------------------

--
-- Structure de la table `app_role`
--

CREATE TABLE `app_role` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `app_role`
--

INSERT INTO `app_role` (`id`, `name`, `code`) VALUES
(1, 'Administrateur', 'ROLE_ADMIN'),
(2, 'Member', 'ROLE_USER');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`) VALUES
(1, NULL, 'Cinéma'),
(2, NULL, 'Boisson & Nourriture'),
(3, NULL, 'Culture GEEK'),
(4, NULL, 'Animaux'),
(5, 2, 'Boisson'),
(6, 5, 'Biere'),
(7, NULL, 'Code'),
(8, 7, 'PHP'),
(9, 8, 'Symfony'),
(10, 7, 'WordPress'),
(11, 7, 'JavaScript'),
(12, 11, 'React'),
(13, 7, 'Html'),
(14, 7, 'CSS'),
(15, 14, 'Scss'),
(16, 3, 'OS'),
(17, 16, 'Linux'),
(18, 16, 'iOs'),
(19, 16, 'Windows');

-- --------------------------------------------------------

--
-- Structure de la table `crew`
--

CREATE TABLE `crew` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_private` int(11) NOT NULL,
  `avatar_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `crew`
--

INSERT INTO `crew` (`id`, `name`, `avatar`, `created_at`, `description`, `is_private`, `avatar_file`, `slug`) VALUES
(1, 'ViVi', 'https://www.proteloinc.com/wp-content/uploads/2018/01/netsuite-in-2018.jpg', '2018-09-09 16:24:00', NULL, 0, NULL, 'ViVi'),
(2, 'VaVa', NULL, '2018-09-02 07:22:43', NULL, 0, NULL, 'VaVa'),
(3, 'VouVou', NULL, '2018-09-04 12:19:40', NULL, 0, NULL, 'VouVou');

-- --------------------------------------------------------

--
-- Structure de la table `crew_quizzs`
--

CREATE TABLE `crew_quizzs` (
  `crew_id` int(11) NOT NULL,
  `quizz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `is_like`
--

CREATE TABLE `is_like` (
  `user_id` int(11) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  `like_it` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `level`
--

INSERT INTO `level` (`id`, `name`) VALUES
(1, 'Débutant'),
(2, 'Confirmé'),
(3, 'Expert');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180915122542'),
('20180918093636'),
('20180925181315'),
('20180926205358'),
('20180927202446'),
('20180928090423'),
('20180928133350'),
('20180928150404'),
('20180928192911'),
('20180929204858'),
('20180930135910'),
('20181001123207'),
('20181001185059'),
('20181002083648'),
('20181002091016');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prop1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prop2` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prop3` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prop4` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anecdote` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `errore` tinyint(1) NOT NULL,
  `nbr` int(11) NOT NULL,
  `image_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id`, `quizz_id`, `level_id`, `body`, `prop1`, `prop2`, `prop3`, `prop4`, `anecdote`, `source`, `errore`, `nbr`, `image_file`, `image`) VALUES
(1, 1, 1, 'Dans le film d\'animation L\'Âge de glace, qu\'est-ce qui échappe à l\'écureuil Scrat ?', 'Un gland', 'Une pierre', 'Un os', 'Une bille', 'À l\'occasion de la sortie de L\'Âge de glace 4, Scrat a eu son double de cire au Musée Grévin le 20 juin 2012.', 'Scrat', 0, 1, NULL, NULL),
(2, 7, 1, 'Comment se nomme l\'orque à sauver dans une saga cinématographique populaire ?', 'Willy', 'Tom', 'Monica', 'Jennifer', 'Si les deuxième et troisième films sont des suites du premier, le 4e n\'a aucun lien avec le reste et est en quelque sorte un reboot.', 'Sauvez_Willy_(série_de_films)', 0, 1, NULL, NULL),
(3, 8, 1, 'Dans le film Les Dents de la mer, quel animal provoque la terreur sur l\'île d\'Amity ?', 'Un requin', 'Une orque', 'Un kraken', 'Un piranha', 'Les Dents de la mer est un film charnière qui a rétrospectivement été considéré comme le premier des blockbusters américains.', 'Les_Dents_de_la_mer', 0, 1, NULL, NULL),
(4, 1, 1, 'Quel personnage de Disney, ami de Mickey Mouse, est un chien anthropomorphe très maladroit ?', 'Dingo', 'Félix', 'Donald', 'Mortimer', 'À partir des années 1990, Dingo est devenu papa dans une série télévisée dans laquelle son fils se prénomme Max.', 'Dingo_(Disney)', 0, 2, NULL, NULL),
(5, 7, 1, 'Dans un film d\'animation de Disney, comment se nomme le renardeau ami d\'un chien de chasse ?', 'Rox', 'Alex', 'Z', 'Simba', 'Rox et Rouky est le dernier dessin animé de Disney commençant par un générique complet et finissant par « The End ».', 'Rox_et_Rouky', 0, 2, NULL, NULL),
(6, 8, 1, 'Quel est le nom du chien de Mickey, apparenté à la race des Saint-Hubert ?', 'Pluto', 'Hector', 'Taz', 'Sylvestre', 'Dessiné par Norman Ferguson, Pluto est considéré comme l\'un des premiers personnages Disney à sortir du modèle standard.', 'Pluto_(Disney)', 0, 2, NULL, NULL),
(7, 1, 1, 'Dans le célèbre dessin animé, qui le chat Tom poursuit-il sans cesse ?', 'Jerry', 'Titi', 'Manny', 'Grosminet', 'Malgré sa popularité très acclamée, les courts-métrages Tom et Jerry ont fait l\'objet de nombreuses controverses.', 'Tom_et_Jerry', 0, 3, NULL, NULL),
(8, 7, 1, 'Quel chien peureux a pour compagnons Samy, Daphné, Véra et Fred ?', 'Scooby-Doo', 'Pluto', 'Beethoven', 'Droopy', 'Une gamme Lego est sortie en 2015 avec six produits inspirés de différents épisodes et fi de Scooby-Do.', 'Scooby-Doo', 0, 3, NULL, NULL),
(9, 8, 1, 'Parmi ces personnages des Looney Tunes, lequel est un canard ?', 'Daffy Duck', 'Titi', 'Bugs Bunny', 'Elmer Fudd', 'Daffy Ducka « sévi » dans 126 dessins animés jusqu\'en 1968 au cinéma avant d\'en disparaître totalement.', 'Daffy_Duck', 0, 3, NULL, NULL),
(10, 1, 1, 'Dans les deux films Babe, quel animal campe le personnage principal ?', 'Un cochon', 'Un mouton', 'Un chien', 'Une chèvre', 'Babe eut l\'idée tout à fait farfelue de devenir chien de berger, ou plutôt « cochon de berger ».', 'Babe', 0, 4, NULL, NULL),
(11, 7, 2, 'Dans le film Le Roi Lion, quel animal est Timon, le grand ami de Pumbaa ?', 'Un suricate', 'Un écureuil', 'Un tatou', 'Un castor', 'Le suricate est toujours là quand on a besoin de lui, mais il est très souvent ailleurs quand on est avec lui.', 'Timon_(Disney)', 0, 4, NULL, NULL),
(12, 8, 2, 'Quel nom de compositeur désigne aussi un saint-bernard héros de films ?', 'Beethoven', 'Mozart', 'Chopin', 'Brahms', 'Le chien fut baptisé Beethoven parce qu\'il a aboyé à la symphonie n°5 de Ludwig van Beethoven.', 'Beethoven_(série_de_films)', 0, 4, NULL, NULL),
(13, 1, 2, 'Des spécimens de quelle race de chiens intéressent tout particulièrement Cruella d\'Enfer ?', 'Dalmatien', 'Berger allemand', 'Fox-terrier', 'Jack Russel', 'Le personnage de Cruella d\'Enfer fut en partie inspiré par Tallulah Bankhead, dont certaines excentricités furent reprises dans le film.', 'Cruella_d\'Enfer', 0, 5, NULL, NULL),
(14, 7, 2, 'Dans un film d\'animation de Disney, quel animal est moqué pour ses grandes oreilles ?', 'Un éléphant', 'Une girafe', 'Un chien', 'Un cerf', 'Un message d\'espoir est délivré par l\'histoire : « quand on fait de son mieux, on en retire quelque chose de bien à la fin ».', 'Dumbo', 0, 5, NULL, NULL),
(15, 8, 2, 'Quel cheval de selle autrichien Napoléon Bonaparte a-t-il emporté avec lui sur l\'île d\'Elbe ?', 'L\'Ingénu', 'L\'Affranchi', 'L\'Iconoclaste', 'Le malin', 'Également surnommé Wagram en l\'honneur de la bataille du même nom, Napoléon l\'appréciait énormément.', 'L\'Ingénu_(cheval)', 0, 5, NULL, NULL),
(16, 1, 2, 'Quelle marque est représentée par un chat blanc généralement habillé de couleur rose ?', 'Hello Kitty', 'Hola Ginola', 'Santa Maria', 'Bravo Sammy', 'Selon le profil officiel de Hello Kitty, cette dernière se nomme Kitty White et est née à Londres, en Angleterre.', 'Hello_Kitty', 0, 6, NULL, NULL),
(17, 7, 2, 'Dans les films d\'animation en pâte à modeler, qui est le partenaire canin de Wallace ?', 'Gromit', 'Rouky', 'Coyote', 'Kaa', 'Tous les personnages sont en plasticine et les scènes sont animées image par image (stop motion).', 'Wallace_et_Gromit', 0, 6, NULL, NULL),
(18, 8, 2, 'Comment s\'appelle le chat noir et blanc, héros d\'une pub pour de la nourriture pour chats ?', 'Félix', 'Figaro', 'José', 'André', 'Felix ne prend pas d\'accent, principalement en raison de l\'internationalisation des marques.', 'Purina', 0, 6, NULL, NULL),
(19, 1, 2, 'Dans le film d\'animation de Pixar 1001 Pattes, quel insecte est Tilt, le personnage principal ?', 'Une fourmi', 'Un cafard', 'Une libellule', 'Une araignée', 'Woody le cow-boy héros du film d\'animation Toy Story est apparu dans le bêtisier du générique de fin.', '1001_pattes', 0, 7, NULL, NULL),
(20, 7, 2, 'Auprès de quel héros de BD le chien inefficace Rantanplan s\'est-il illustré ?', 'Lucky Luke', 'Gaston Lagaffe', 'Tintin', 'Astérix', 'Rantanplan appartient à l\'administration pénitentiaire, et a pour maître, le gardien Pavlov (en référence au fameux réflexe).', 'Rantanplan', 0, 7, NULL, NULL),
(21, 8, 3, 'Dans la film d\'animation Robin des Bois, quel animal est Robin des Bois ?', 'Un renard', 'Un lion', 'Un ours', 'Un tigre', 'La réalisation de Robin des Bois sera marquée par la réutilisation d\'éléments d\'animation des précédentes productions Disney.', 'Robin_des_Bois_(film,_1973)', 0, 7, NULL, NULL),
(22, 1, 3, 'De quel animal prénommé Roger veut-on « la peau » dans un film d\'animation ?', 'Un lapin', 'Un renard', 'Un chien', 'Un kangourou', 'Zemeckis dira de Roger qu\'il a « un corps de chez Disney, une tête de chez Warner et une attitude à la Tex Avery ».', 'Roger_Rabbit', 0, 8, NULL, NULL),
(23, 7, 3, 'Dans le roman de Cécile Aubry, quelle chienne Sébastien recueille-t-il dans son village ?', 'Belle', 'Simba', 'Daisy', 'Aurore', 'Belle et Sébastien a fait l\'objet d\'une adaptation en feuilleton télévisé, d\'une série d\'animation japonaise et de deux films.', 'Belle_et_Sébastien', 0, 8, NULL, NULL),
(24, 8, 3, 'Quelle tortue sait « compter deux par deux et lacer ses chaussures » ?', 'Franklin', 'Gamera', 'Donatello', 'Caroline', 'Dans chaque épisode, Franklin a un dilemme qu\'il résout toujours à la fin, permettant aux enfants de s\'identifier au personnage.', 'Franklin_(série_télévisée)', 0, 8, NULL, NULL),
(25, 1, 3, 'Quel chien est devenu le rival du chat Socks en tant qu\'animal de compagnie de la famille Clinton ?', 'Buddy', 'Snoopy', 'Oscar', 'Scooby', 'Les parents Clinton ont adopté un labrador nommé Buddy en hommage à l\'oncle de Bill qui vient de décéder.', 'Animaux_domestiques_des_présidents_des_États-Unis', 0, 9, NULL, NULL),
(26, 7, 3, 'Dans Peter Pan, comment se nomme la chienne de Wendy, John et Michael ?', 'Nana', 'Belle', 'Jasmine', 'Dolly', 'Peter Pan est un personnage créé par l\'auteur écossais J. M. Barrie, apparu pour la première fois en 1902.', 'Peter_Pan', 0, 9, NULL, NULL),
(27, 8, 3, 'Quel célèbre chat a une langue qui pend en permanence suite à une malformation ?', 'Lil Bub', 'Bébert', 'Simon', 'Choupette', 'La célèbre chatte est apparue dans un spot de l\'ONG Greenpeace à l\'occasion de la Journée internationale des tigres.', 'Lil_Bub', 0, 9, NULL, NULL),
(28, 1, 3, 'Dans le dessin animé Dora l\'exploratrice, comment s\'appelle le renard voleur ?', 'Chipeur', 'Silver', 'Sylvester', 'Denver', 'Par ce biais de ce méchant renard voleur, la série tente de faire distinguer aux enfants le bien du mal.', 'Dora_l\'exploratrice', 0, 10, NULL, NULL),
(29, 7, 3, 'Quel cochon Martin Veyron et Jean-Marc Rochette ont-ils inventé pour une BD humoristique ?', 'Edmond', 'Babe', 'Grégoire', 'Jonathan', 'Le style de cette série à l\'humour cru et hilarant se situe entre l\'underground américain et la tradition animalière française.', 'Edmond_le_cochon', 0, 10, NULL, NULL),
(30, 8, 3, 'Dans l\'aquarium de quelle ville allemande Paul le poulpe a-t-il eu son heure de gloire ?', 'Oberhausen', 'Brunswick', 'Karlsruhe', 'Mannheim', 'Paul était renommé pour le spectacle de ses prédictions du résultat des matchs de léquipe d\'Allemagne de football.', 'Paul_le_poulpe', 0, 10, NULL, NULL),
(31, 2, 1, 'À partir de la fève de quel arbre le chocolat est-il produit ?', 'Cacaoyer', 'Pacanier', 'Cotonnier', 'Palmier', 'Les fèves de cacao sont extraites des baies, que l\'on ouvre à la récolte et que l\'on met à sécher.', 'Fève_de_cacao', 0, 1, NULL, NULL),
(32, 9, 1, 'Quel beurre est extrait de la pâte de cacao liquide servant à la création du chocolat ?', 'Beurre de cacao', 'Saindoux', 'Beurre salé', 'Beurre gras', 'Le beurre de cacao est une des graisses les plus stables connues, contenant des antioxydants naturels.', 'Beurre_de_cacao', 0, 1, NULL, NULL),
(33, 10, 1, 'Que fait-on quand on torréfie les fèves de cacao pour la préparation du chocolat ?', 'On les grille', 'On les écrase', 'On les épluche', 'On les tord', 'La torréfaction, c\'est-à-dire un chauffage de 140 à 160 °C pendant 20 à 30 minutes, permet le développement des arômes du cacao.', 'Fève_de_cacao', 0, 3, NULL, NULL),
(34, 2, 1, 'Quel chocolat, parfois mélangé avec des épices, contient le moins de sucre ?', 'Noir', 'Blanc', 'Au lait', 'Praliné', 'La qualité du chocolat noir dépend des ingrédients utilisés, et de son pourcentage en cacao.', 'Chocolat_noir', 0, 2, NULL, NULL),
(35, 9, 1, 'En 1825, quel Suisse a créé une désormais célèbre fabrique de chocolat ?', 'Suchard', 'Lindt', 'Tobler', 'Jacobs', 'Philippe Suchard débuta dans la confiserie en 1825 à Neuchâtel et se lanca dans le chocolat à Serrières en 1826.', 'Philippe_Suchard', 0, 2, NULL, NULL),
(36, 10, 1, 'Que provoque la consommation de chocolat chez la plupart des animaux de compagnie ?', 'La mort', 'La paralysie', 'La cécité', 'Le diabète', 'Le chocolat contient de la théobromine, un produit semblable à la caféine que leur métabolisme ne permet pas d\'éliminer.', 'Chocolat', 0, 4, NULL, NULL),
(37, 2, 1, 'Quel chocolat, riche en acides gras saturés, est le plus amère ?', 'Noir', 'Au lait', 'Praliné', 'Blanc', 'Le chocolat noir, qui contient peu de cholesterol et très peu de sodium, est une bonne source de magnésium.', 'Chocolat_noir', 0, 3, NULL, NULL),
(38, 9, 1, 'Qui incarne la chocolatière dans le film adapté du roman Le chocolat de Joanne Harris ? ', 'Juliette Binoche', 'Isabelle Adjani', 'Karin Viard', 'Judith Godrèche', 'En 1959, durant le carême, une jeune femme et sa fille reprennent la vieille pâtisserie pour ouvrir une chocolaterie.', 'Le_Chocolat', 0, 3, NULL, NULL),
(39, 10, 1, 'Comment appelle-t-on le fruit du cacaoyer, se présentant sous la forme d\'une baie ?', 'Cabosse', 'Caboche', 'Ciboulot', 'Carabosse', 'Les cabosses se trouvent sur le tronc et les grosses branches, et non pas sur les rameaux jeunes.', 'Cabosse', 0, 5, NULL, NULL),
(40, 2, 1, 'Quel chocolat, généralement préféré par les puristes, ne contient pas de lait ?', 'Noir', 'Blanc', 'Au lait', 'Praliné', 'Réglementairement, le chocolat noir doit contenir au moins 35 % de cacao, sans limite supérieure pour la concentration de cacao.', 'Chocolat_noir', 0, 4, NULL, NULL),
(41, 9, 2, 'De quel peuple le chocolat serait-il originaire, l\'associant à leur dieu de la fertilité ?', 'Les Mayas', 'Les Incas', 'Les Toltèques', 'Les Otomis', 'Les Aztèques associaient le chocolat avec Xochiquetzal (qui a donné son nom au chocolat), la déesse de la fertilité.', 'Chocolat', 0, 4, NULL, NULL),
(42, 10, 2, 'Combien trouve-t-on environ de fèves de cacao dans une cabosse ?', 'Une quarantaine', 'Une dizaine', 'Une centaine', 'Un millier', 'La cabosse a une forme allongée et ressemble à un concombre assez rebondi.', 'Cabosse', 0, 6, NULL, NULL),
(43, 2, 2, 'Quel est le premier pays producteur de cacao, loin devant le Ghana et l\'Indonésie ?', 'La Côte d\'Ivoire', 'Le Brésil', 'Le Mexique', 'Le Cameroun', 'La production de cacao était en 2006 de 4.06 millions de tonnes, en hausse constante depuis 2003.', 'Cacao', 0, 5, NULL, NULL),
(44, 9, 2, 'Quel élément différencie le chocolat blanc des autres chocolats ?', 'La pâte de cacao', 'Le lait', 'Le beurre', 'Le sucre', 'Le chocolat blanc a d\'abord été distribué en Amérique en 1948 avec l\'introduction des barres de chocolat « blanc alpin » Nestlé.', 'Chocolat_blanc', 0, 5, NULL, NULL),
(45, 9, 2, 'Dans quel pays a été fabriquée la première tablette de chocolat ?', 'L\'Angleterre', 'La Suisse', 'Le Brésil', 'Le Mexique', 'Les premières plaques de chocolat ont été baptisées « Chocolat délicieux à manger ».', 'Tablette_de_chocolat', 0, 6, NULL, NULL),
(46, 2, 2, 'Combien peut-on faire de récoltes par an sur un cacaoyer en bonne santé ?', 'Deux', 'Quatre', 'Six', 'Huit', 'La maturation des fruits du cacaoyer dure, selon les génotypes, de cinq à sept mois.', 'Cacaoyer', 0, 6, NULL, NULL),
(47, 9, 2, 'Quel pays européen est le plus grand consommateur de chocolat ?', 'La Suisse', 'La Belgique', 'La France', 'Le Portugal', 'Les variantes au lait et fondant ont été créées respectivement par Daniel Peter en 1875 et Rudolf Lindt en 1879.', 'Suisse', 0, 7, NULL, NULL),
(48, 9, 2, 'De quel pays le cacaoyer, domestiqué il y a environ 3 000 ans, est-il originaire ?', 'Du Mexique', 'De Bolivie', 'Du Mozambique', 'De Madagascar', 'Le cacaoyer fut très probablement domestiqué au départ pour la confection d\'une boisson fermentée, donc alcoolisée.', 'Cacaoyer', 0, 8, NULL, NULL),
(49, 2, 2, 'Quel chocolat, devant contenir au minimum 20 % de beurre de cacao, est le plus sucré ?', 'Blanc', 'Noir', 'Praliné', 'Au lait', 'Le chocolat blanc a été produit pour la première fois par Nestlé en Suisse dans les années 1930.', 'Chocolat_blanc', 0, 7, NULL, NULL),
(50, 9, 2, 'Combien de cabosses un cacaoyer peut-il produire en moyenne ?', '20', '200', '2 000', '20 000', 'Chaque cabosse, ressemblant à un petit ballon de football américain, peut peser jusqu\'à 400 g pour 15 à 20 cm de long.', 'Cacaoyer', 0, 9, NULL, NULL),
(51, 10, 3, 'Pour les préliminaires de quel événement les Mayas se servent-ils du chocolat ?', 'Un mariage', 'Un décès', 'Une naissance', 'Un sacrifice', 'Le cacao purifie aussi les enfants mayas lors de cérémonies ou accompagne le défunt pour son voyage vers l\'au-delà.', 'Chocolat', 0, 7, NULL, NULL),
(52, 2, 3, 'Quelle civilisation précolombienne a la première cultivé le cacao ?', 'Les Olmèques', 'Les Africains', 'Les Berbères', 'Les Aztèques', 'La culture olmèque demeure inconnue jusqu\'à la deuxième moitié du XIXe siècle.', 'Olmèques', 0, 8, NULL, NULL),
(53, 9, 3, 'Dans quel pays d\'Europe a-t-on commencé à consommer du chocolat ?', 'En Espagne', 'En Italie', 'En Belgique', 'En France', 'Ce n\'est qu\'à partir de la conquête des Aztèques par les Espagnols que le chocolat fut importé en Europe.', 'Chocolat', 0, 10, NULL, NULL),
(54, 10, 3, 'Combien de fleurs un cacaoyer peut-il produire annuellement ?', '100 000', '10 000', '1 000', '100', 'Les fleurs apparaissent toute l\'année sur des renflements du bois de l\'arbre, appelés « coussinets floraux ».', 'Cacaoyer', 0, 8, NULL, NULL),
(55, 2, 3, 'Quel explorateur a rapporté le cacao en Europe en 1528 ?', 'Cortés', 'Christophe Colomb', 'Charcot', 'Foucauld', 'Hernán Cortés s\'est emparé de l\'Empire aztèque pour le compte de Charles Quint, roi de Castille et empereur romain germanique.', 'Hernán_Cortés', 0, 9, NULL, NULL),
(56, 9, 3, 'Quel chocolat noir est issu de cacao d\'une seule plantation ?', 'Grand cru', 'Origine', 'Premier choix', 'Label rouge', 'En France, c\'est l\'Institut national de l\'origine et de la qualité qui classifie la qualité des chocolats.', 'Chocolat_noir', 0, 1, NULL, NULL),
(57, 10, 3, 'Quelle substance est obtenue après broyage des fèves du cacaoyer ?', 'La masse', 'La tasse', 'La crasse', 'La nasse', 'Les fèves de cacao contiennent environ 50 % de matière grasse appelée « beurre de cacao ».', 'Fève_de_cacao', 0, 9, NULL, NULL),
(58, 2, 3, 'Une fois la masse de cacao pressée, quel produit est utilisé pour faire du cacao en poudre ?', 'Le tourteau', 'Le crabe', 'Le homard', 'La crevette', 'Deux procédés de trituration sont possibles : la pression discontinue à froid et la pression continue à chaud.', 'Tourteau_(résidu)', 0, 10, NULL, NULL),
(59, 9, 3, 'Laura Esquivel, écrivaine mexicaine contemporaine, a publié un livre intitulé...', 'Chocolat amer', 'Chocolat noir', 'Chocolat au lait', 'Chocolat blanc', 'Laura Esquivel est un auteur qui cherche constamment de nouveaux et originaux chemins dans ses uvres.', 'Laura_Esquivel', 0, 2, NULL, NULL),
(60, 10, 3, 'Dans quel rayon BD peut-on trouver l\'album Fraise et chocolat ?', 'Érotique', 'Jeunesse', 'Humour', 'Aventure', 'Aurélia Aurita est une auteure de bande dessinée française d\'origine chinoise et khmère.', 'Aurélia_Aurita_(bande_dessinée)', 0, 10, NULL, NULL),
(61, 3, 1, 'Quel programmeur a créé et continue de diriger le développement du noyau de Linux ?', 'Linus Torvalds', 'Steeve Jobs', 'Larry Ellison', 'Bill Gates', 'Linus a découvert l\'informatique vers l\'âge de 11 ans grâce à l\'ordinateur de son grand-père, un Commodore VIC-20.', 'Linus_Torvalds', 0, 1, NULL, NULL),
(62, 11, 1, 'Quel est le principal atout de Linux, développé et maintenu par Linus Torvalds ?', 'Il est libre', 'Il est beau', 'Il est Finlandais', 'Il est amusant', 'Linux est le nom couramment donné à tout système d\'exploitation libre fonctionnant avec le noyau Linux.', 'Linux', 0, 1, NULL, NULL),
(63, 12, 1, 'Quel animal représentant Linux est aussi la mascotte de l\'université d\'Helsinki ?', 'Un manchot', 'Une marmotte', 'Un caribou', 'Un gnou', 'Dessiné en 1996, son usage est libre et se retrouve dans de très nombreux projets et logotypes liés à Linux.', 'Tux', 0, 1, NULL, NULL),
(64, 3, 1, 'Quelle commande Linux, basée sur la commande UNIX, utilise-t-on pour effacer un fichier ?', 'Rm', 'Rem', 'Del', 'Delete', 'De par la filiation avec UNIX, la ligne de commande est toujours disponible dans GNU/Linux, quelle que soit la distribution.', 'Linux', 0, 2, NULL, NULL),
(65, 12, 1, 'Laquelle de ces propositions désigne une distribution Linux fondée en 1993 ?', 'Red Hat', 'Zubuntu', 'Souze', 'Mandrika', 'Red Hat est l\'une des entreprises dédiées aux logiciels Open Source les plus importantes et les plus reconnues.', 'Red_Hat', 0, 2, NULL, NULL),
(66, 12, 1, 'Quel système d\'exploitation mobile majeur de l\'industrie actuelle s\'appuie sur un noyau Linux ?', 'Android', 'iOS', 'Windows Phone', 'BlackBerry 10', 'En 2015, Android est le système d\'exploitation le plus utilisé dans le monde avec plus de 80 % de parts de marché.', 'Android', 0, 3, NULL, NULL),
(67, 3, 1, 'Sous Linux, comment appelle-t-on les logiciels assemblés autour du noyau ?', 'Une distribution', 'Un progiciel', 'Un intégré', 'Une logithèque', 'Il existe une très grande variété de distributions, ayant chacune des objectifs et une philosophie particulière.', 'Distribution_GNU/Linux', 0, 3, NULL, NULL),
(68, 11, 1, 'Quel serveur web présent sous Linux est aussi présent sur les serveurs du monde entier ?', 'Apache', 'Comanche', 'Siou', 'Mohican', 'Depuis avril 1996, selon l\'étude permanente de Netcraft, Apache est devenu le serveur HTTP le plus répandu sur Internet.', 'Apache_HTTP_Server', 0, 2, NULL, NULL),
(69, 12, 1, 'Quel est le nom de la mascotte de Linux, connue de tous les passionnés du système d\'exploitation ?', 'Tux', 'Wilber', 'Gnu', 'Puffy', 'Le dessin du personnage a été choisi à l\'issue d\'un concours organisé en 1996 remporté par Larry Ewing.', 'Tux', 0, 4, NULL, NULL),
(70, 3, 1, 'Parmi ces commandes Linux, laquelle affiche à l\'écran le contenu d\'un fichier texte ?', 'Cat', 'Type', 'Man', 'Ls', 'La différence essentielle de Linux par rapport à d\'autres systèmes d\'exploitation concurrents est d\'être un système d\'exploitation libre.', 'Linux', 0, 4, NULL, NULL),
(71, 11, 2, 'En quelle année Linus Torvalds a-t-il livré la première version du noyau Linux ?', '1991', '1993', '1995', '1997', 'En 1991, les compatibles PC dominent le marché des ordinateurs personnels et fonctionnent généralement sous MS-DOS ou Windows.', 'Linux', 0, 3, NULL, NULL),
(72, 12, 2, 'Quel ancien mot bantou désigne une célèbre distribution Linux ?', 'Ubuntu', 'Gentoo', 'Mandriva', 'Fedora', 'Le nom de la distribution provient d\'un ancien mot bantou qui signifie « Je suis ce que je suis grâce à ce que nous sommes tous ».', 'Ubuntu', 0, 5, NULL, NULL),
(73, 11, 2, 'Quel navigateur web et gestionnaire de fichiers est utilisé par défaut pour KDE ?', 'Konqueror', 'Firefox', 'Netscape', 'Chrome', 'Konqueror peut également afficher le contenu d\'un serveur FTP, permettre de parcourir le réseau local et de visualiser des fichiers.', 'Konqueror', 0, 4, NULL, NULL),
(74, 3, 2, 'Quel nom porte la distribution française de Linux, une des plus simples à installer et à utiliser ?', 'Mandriva', 'Debian', 'SUSE', 'Slackwave', 'Ciblant à la fois le grand public et les professionnels, cette distribution GNU/Linux est construite autour de KDE.', 'Mandriva_Linux', 0, 5, NULL, NULL),
(75, 3, 2, 'Quel type de fichiers est pris en compte par le gestionnaires de paquets intégré à Ubuntu ?', '.deb', '.dev', '.rss', '.rpm', 'Par défaut, Ubuntu est installé avec une pluralité de logiciels libres tels que LibreOffice, Firefox, Thunderbird et Transmission.', 'Ubuntu', 0, 6, NULL, NULL),
(76, 11, 2, 'Sous Linux, quelle commande est utilisée pour créer un compte utilisateur ?', 'Useradd', 'Adduser', 'Passwd', 'Mkaccount', 'Grâce à sa ligne de commande, scientifiques, ingénieurs et développeurs comptent parmi ses plus fréquents utilisateurs.', 'Linux', 0, 5, NULL, NULL),
(77, 11, 2, 'De quel projet sont tirés les outils gravitant autour de Linux ?', 'GNU', 'BSD', 'Mimix', 'iOS', 'GNU est un projet de système d\'exploitation libre lancé en 1983 par Richard Stallman, puis maintenu par le projet GNU.', 'GNU', 0, 6, NULL, NULL),
(78, 12, 2, 'De quelle distribution Linux est dérivé le système d\'exploitation Ubuntu ?', 'Debian', 'Red Hat', 'Slackware', 'Fedora', 'Ancien développeur Debian, Mark Shuttleworth souhaitait une version plus facile d\'accès pour les novices.', 'Ubuntu', 0, 6, NULL, NULL),
(79, 12, 2, 'Quelle est la plus ancienne distribution Linux encore maintenue à ce jour ?', 'Slackware', 'Ubuntu', 'Red Hat', 'Mandriva', 'Slackware est une distribution Linux qui, à la différence d\'autres distributions, a longtemps été maintenue par une seule personne.', 'Slackware', 0, 7, NULL, NULL),
(80, 11, 2, 'Quel environnement graphique de type « fenêtré » est utilisé sous Linux ?', 'X Window', 'K Window', 'Z Window', 'L Window', 'Cet environnement graphique gère l\'interaction homme-machine par l\'écran, la souris et le clavier de certains ordinateurs en réseau.', 'X_Window_System', 0, 7, NULL, NULL),
(81, 12, 3, 'Quel programmeur et militant du logiciel libre a créé le Projet GNU en 1984 ?', 'Richard Stallman', 'Linus Torvalds', 'John Von Neumann', 'Alan Cox', 'Richard Stallman consacre la majeure partie de son temps à la promotion du logiciel libre auprès de divers publics.', 'Richard_Stallman', 0, 8, NULL, NULL),
(82, 3, 3, 'Quel lecteur multimédia ressemblant à Winamp est souvent utilisé sous Linux ?', 'XMMS', 'Mplayer', 'Tomahawk', 'Spotify', 'XMMS fut originellement codé sous le nom de X11Amp par Peter et Mikal Alm en novembre 1997, pour combler un manque sou Linux.', 'XMMS', 0, 7, NULL, NULL),
(83, 3, 3, 'Quelle société financée par l\'entrepreneur sud-africain Mark Shuttleworth commandite Ubuntu ?', 'Canonical', 'Pentax', 'Panasonic', 'Nikon', 'Cette société, basée sur l\'Île de Man, a été créée en 2004 et opère dans 30 pays différents et emploie 500 personnes.', 'Canonical', 0, 8, NULL, NULL),
(84, 3, 3, 'Avec quel acteur du monde Linux Microsoft a-t-il signé un accord d\'importance ?', 'SUSE', 'Red Hat', 'Ubuntu', 'Mandriva', 'Apparue au début de l\'année 1994, SUSE est donc la plus ancienne distribution commerciale encore existante.', 'SUSE', 0, 9, NULL, NULL),
(85, 3, 3, 'La station spatiale internationale a abandonné Windows au profit de quelle distribution Linux ?', 'Debian', 'SUSE', 'Red Hat', 'Ubuntu', 'Debian est utilisée comme base de nombreuses autres distributions telles que Knoppix et Ubuntu qui rencontrent un grand succès.', 'Debian', 0, 10, NULL, NULL),
(86, 11, 3, 'Quel pays utilise à ce jour le plus Linux comme système d\'exploitation de bureau ?', 'Cuba', 'Le Venezuela', 'Le Kenya', 'La Finlande', 'Les deux environnements GNOME et KDE, qui reposent sur des technologies communes, ont atteint une maturité certaine.', 'Linux', 0, 8, NULL, NULL),
(87, 11, 3, 'Quel graphiste a dessiné en 1996 le manchot Tux initial, mascotte du projet Linux ?', 'Larry Ewing', 'Jeffrey Lynch', 'Rob Janoff', 'Wes Wilson', 'Ce programmeur américain a réalisé la mascotte Tux avec l\'aide du logiciel libre The GIMP.', 'Larry_Ewing', 0, 9, NULL, NULL),
(88, 11, 3, 'Lequel de ces jeux tourne nativement sous GNU/Linux ?', 'Quake III Arena', 'Super Mario Kart', 'Zelda', 'Splinter Cell', 'Le jeu développé par id Software a également été publié sur Macintosh, sur Dreamcast, sur PlayStation 2 et sur Xbox Live Arcade.', 'Quake_III_Arena', 0, 10, NULL, NULL),
(89, 12, 3, 'Quelle console de jeu open source possède un système d\'exploitation Linux compilé ?', 'Pandora', 'Game Gear', 'N-Gage', 'GP32', 'La Pandora est capable à ce jour de lancer Quake, Quake II et Quake III Arena sans ralentissement.', 'Pandora_(console_portable)', 0, 9, NULL, NULL),
(90, 12, 3, 'Comment fut initialement appelé le projet Linux, qui deviendra par la suite une marque déposée ?', 'Freax', 'Serval', 'Panther', 'Longhorn', 'Le projet trouve son nom définitif grâce à Ari Lemmke qui héberge le travail de Linus Torvalds dans un répertoire nommé Linux.', 'Linux', 0, 10, NULL, NULL),
(91, 4, 1, 'Qui est le padawan du chevalier et maître Jedi Obi-Wan Kenobi ?', 'Anakin Skywalker', 'Yoda', 'Mace Windu', 'Leia', 'Obi-Wan Kenobi est tout d\'abord le padawan de Qui-Gon Jinn avant de devenir lui-même l\'instructeur d\'Anakin Skywalker.', 'Obi-Wan_Kenobi', 0, 1, NULL, NULL),
(92, 4, 1, 'Quel petit bonhomme vert a enseigné à Luke comment utiliser la Force ?', 'Yoda', 'Anakin Skywalker', 'Jabba', 'Yado', 'Yoda est présent dans cinq épisodes sur les sept que compte la saga (I, II, III, V, VI).', 'Yoda', 0, 2, NULL, NULL),
(93, 4, 1, 'Dans la saga Star Wars, quels chevaliers se battent avec des sabres lasers ?', 'Jedi', 'Zodiak', 'Table ronde', 'Samourai', 'L\'Ordre Jedi est dirigé par le Conseil Jedi, qui se réunit sur la planète Coruscant.', 'Jedi', 0, 3, NULL, NULL),
(94, 13, 1, 'De quelle station spatiale ennemie la princesse Leia apprend-elle les plans de construction ?', 'L\'Étoile Noire', 'L\'Étoile qui tue', 'La Lune obscure', 'Le côté obscur', 'L\'Étoile noire et l\'Étoile de la mort sont deux stations spatiales sidérales mobiles de la taille d\'une lune.', 'Étoile_de_la_mort', 0, 1, NULL, NULL),
(95, 13, 1, 'Personnage central de la saga Star Wars, avec qui Anakin Skywalker se marie-t-il ?', 'Sénatrice Padme', 'Leia Organa', 'Madpe', 'Obiwana', 'Padmé Amidala Skywalker est née en 46 av. BY sur Naboo et morte en 19 av. BY sur Polis Massa.', 'Padmé_Amidala', 0, 2, NULL, NULL),
(96, 13, 1, 'Pour aider les Jedi a réparer leur vaisseau, Anakin doit gagner une course...', 'De module', 'De nodule', 'De acklay', 'De nexu', 'Après une course acharnée et très disputée, Anakin parviendra finalement à remporter la victoire.', 'Star_Wars,_épisode_I_:_La_Menace_fantôme', 0, 3, NULL, NULL),
(97, 14, 1, 'Que contrôlent les Jedi qui les rendent très différents des simples humains ?', 'La Force', 'La lumière', 'Le langage droïde', 'L\'immortalité', 'Les chevaliers Jedi forment un ordre d\'individus qui sont aptes à maîtriser la Force, et qui l\'utilisent uniquement pour faire le bien.', 'Jedi', 0, 1, NULL, NULL),
(98, 14, 1, 'Quels puissants ennemis et « seigneurs » les Jedi pensent-ils avoir vaincu ?', 'Les siths', 'Les friths', 'Les Ch\'tis', 'Les Vicks', 'Les siths sont les ennemis jurés des Jedi dont ils constituent une menace pour la République Galactique.', 'Sith', 0, 2, NULL, NULL),
(99, 14, 1, 'De qui la princesse Leia tombe-t-elle amoureuse dans la saga Star Wars ?', 'Han Solo', 'Luke Skywalker', 'Chewbacca', 'Obi-Wan Kenobi', 'Han Solo est un contrebandier, pilote et ancien élève officier impérial qui dut déserter pour sauver Chewbacca.', 'Han_Solo', 0, 3, NULL, NULL),
(100, 4, 1, 'Quelle armée aidera les Jedi pour ensuite se retourner contre eux et les forces du mal ?', 'L\'armée des clones', 'Les faucons', 'Les Bantha', 'Les Gungans', 'L\'Attaque des clones est l\'un des premiers films à être tourné entièrement en numérique.', 'Star_Wars,_épisode_II_:_L\'Attaque_des_clones', 0, 4, NULL, NULL),
(101, 4, 2, 'Quel chancelier suprême est seigneur noir des Sith et homme politique dans la série Star Wars ?', 'Palpatine', 'Padme Amidala', 'Valorum', 'Yoda', 'Originaire de Naboo, Palpatine a été formé au côté obscur de la Force dès le plus jeune âge par son maître, Dark Plagueis.', 'Palpatine', 0, 5, NULL, NULL),
(102, 4, 2, 'De qui Chewbacca, le plus célèbre des guerriers Wookie, est-il le co-pilote ?', 'Han Solo', 'Obi-Wan Kenobi', 'Luke Skywalker', 'Anakin Skywalker', 'Chewbacca fait partie du noyau de rebelles qui ont restauré la liberté dans la galaxie.', 'Chewbacca', 0, 6, NULL, NULL),
(103, 4, 2, 'Que se passe-t-il lorsqu\'Anakin Skywalker affronte le compte Dooku la première fois ?', 'Il perd une main', 'Il gagne le duel', 'Yoda tue Dooku', 'Dooku lui file sa toux', 'Dooku fut l\'héritier d\'une famille d\'aristocrates et diplomates de Serenno à la fortune colossale.', 'Comte_Dooku', 0, 7, NULL, NULL),
(104, 13, 2, 'Parmi ces personnages de Star Wars, qui dirige le conseil des Jedi avec Yoda ?', 'Mace Windu', 'Anakin Skywalker', 'Qui Go Jin', 'Obiwan Kenobi', 'En plus de sa réputation de sage, Windu est considéré comme l\'un des meilleurs combattants au sabre laser de l\'Ordre Jedi.', 'Mace_Windu', 0, 4, NULL, NULL),
(105, 13, 2, 'Quel maître Jedi d\'Obi-Wan Kenobi sera finalement tué par Dark Maul ?', 'Qui-Gon Jinn', 'Ki-Adi-Mundi', 'Plo Koon', 'Adi Gallia', 'Le personnage est interprété par Liam Neeson et doublé par Samuel Labarthe en France.', 'Qui-Gon_Jinn', 0, 5, NULL, NULL),
(106, 13, 2, 'Quel apprenti Sith Obi-Wan va-t-il tuer en vengeant la mort de son maître ?', 'Dark Maul', 'Dark Sidious', 'Dark Pantouf', 'Dark Leouf', 'Le personnage de Dark Maul fut créé par l\'illustrateur Iain Mccaig pour Industrial Light & Magic.', 'Dark_Maul', 0, 6, NULL, NULL),
(107, 13, 2, 'Quel nom porte le vaisseau spatial du contrebandier Han Solo ?', 'Faucon Millénium', 'Anneau Solaire', 'Intergalactique', 'Enterprise', 'Le Faucon Millénium fut appelé Millenium Condor dans la version française du premier épisode produit.', 'Faucon_Millenium', 0, 7, NULL, NULL),
(108, 14, 2, 'Qui tue Boba Fett, redoutable chasseur de primes connu pour son adresse à traquer sa proie ?', 'Han Solo', 'Luke Skywalker', 'Obi-Wan Kenobi', 'Dark Vador', 'On apprendra plus tard qu\'il échappe à la digestion du Gerand Sarlacc et qu\'il reviendra dans l\'histoire.', 'Boba_Fett', 0, 4, NULL, NULL),
(109, 14, 2, 'Sur quelle planète vit Anakin avant de partir rejoindre les Jedi ?', 'Tatooine', 'Dagobah', 'Naboo', 'Mustafar', 'Située dans la Bordure extérieure, cette planète désertique est le refuge des plus vils brigands de la galaxie.', 'Tatooine', 0, 5, NULL, NULL),
(110, 14, 2, 'Quel célèbre chasseur de primes a été engagé par Dark Vador pour traquer Han Solo ?', 'Boba Fett', 'Jabba le Hutt', 'Han Solo', 'Zam Wesell', 'L\'origine de Boba Fett est donnée dans L\'Attaque des clones : il est le « fils » du légendaire chasseur de primes Jango Fett.', 'Boba_Fett', 0, 6, NULL, NULL),
(111, 4, 3, 'Une fois mesurée, quelle molécule permet de savoir si un individu peut être un Chevalier Jedi ?', 'Midi-chloriens', 'Meti-chlorien', 'Chlorydrate', 'Chlori-Metica', 'Dans la saga Star Wars, Anakin Skywalker se fait remarquer par son fort taux de midi-chloriens.', 'Force_(Star_Wars)', 0, 8, NULL, NULL),
(112, 4, 3, 'Quel taux de cette molécule Anakin possède-t-il lorsque Qui-Gon l\'analyse pour la première fois ?', 'Plus de 20 000', 'Plus de 10 000', 'Plus de 5 000', 'Plus de 1 000', 'Ce taux de midi-­chloriens est de plus supérieur à celui de Yoda, pourtant reconnu comme Grand Maître des Jedi.', 'Force_(Star_Wars)', 0, 9, NULL, NULL),
(113, 4, 3, 'Quel mystique de la connaissance est le maître de Dark Sidious ?', 'Dark Plagueis', 'Dark Vador', 'Dark Bane', 'Dark Tyranus', 'Seigneur Noir des Sith, il possédait un pouvoir inimaginable qui lui permettait de garder les gens en vie avec la Force.', 'Dark_Plagueis', 0, 10, NULL, NULL),
(114, 13, 3, 'Lesquels de ces épisodes de Star Wars n\'ont pas été réalisés par George Lucas ?', '5 et 6', '1 à 3', '3 et 4', '2 et 3', 'Même s\'il ne les a pas réalisés, George Luas a donné de très nombreuses directives à Irvin Kerschner et Richard Marquand.', 'Star_Wars', 0, 8, NULL, NULL),
(115, 13, 3, 'À partir de quelle bataille peut-on mesurer la chronologie dans Star Wars ?', 'Bataille de Yavin', 'Bataille de Jaku', 'Bataille de Coruscant', 'Bataille de Naboo', 'La bataille de Yavin oppose l\'Empire galactique aux Rebelles autour de la planète gazeuse Yavin.', 'Bataille_de_Yavin', 0, 9, NULL, NULL),
(116, 13, 3, 'Que signifie la dernière phrase de Dark Vador avant de mourir : « Tu l\'as déjà fait Luke » ?', 'L\'avoir sauvé', 'L\'avoir retrouvé', 'L\'avoir trahi', 'L\'avoir aimé', 'Le fait que Dark Vador soit le père des jumeaux Luke Skywalker et Leia Organa constitue l\'intrigue principale de la saga.', 'Anakin_Skywalker', 0, 10, NULL, NULL),
(117, 14, 3, 'Contre qui Han Solo remporte-t-il le Faucon Millénium lors d\'une partie de sabacc ?', 'Lando Calrissian', 'Jabba le Hutt', 'Boba Fett', 'Watto', 'Lando Calrissian est devenu par la suite administrateur de la cité des Nuages, une colonie minière.', 'Lando_Calrissian', 0, 7, NULL, NULL),
(118, 14, 3, 'Sur quelle planète Luke est-il parti pour apprendre à devenir un véritable Jedi ?', 'Dagobah', 'Naboo', 'Utapau', 'Malastare', 'Dagobah, dans le secteur Sluis, est un monde de sombres marais, de bayous putrides et de forêts d\'arbres tortueux.', 'Dagobah', 0, 8, NULL, NULL),
(119, 14, 3, 'Dans Star Wars, de George Lucas, qui tue le chancelier Palpatine alias Dark Sidious ?', 'Dark Vador', 'Luke Skywalker', 'La princesse Leia', 'Han Solo', 'Le règne de Palpatine s\'achève dans l\'épisode VI, à la fin duquel il est tué par Anakin Skywalker en l\'an 4 ap. BY.', 'Palpatine', 0, 9, NULL, NULL),
(120, 14, 3, 'Combien d\'années séparent le premier épisode sorti en salle de l\'épisode 3 ?', '28 ans', '26 ans', '24 ans', '30 ans', 'À l\'origine nommée La Guerre des étoiles, Star Wars est un univers de science-fiction créé par George Lucas en 1977.', 'Star_Wars', 0, 10, NULL, NULL),
(121, 5, 1, 'Quelle bière est fabriquée en ajoutant des cerises acides au lambic ?', 'La Kriek', 'La Chimay', 'La Leffe', 'La Duvel', 'Jadis, certaines brasseries produisaient des krieks réalisées à partir d\'un mélange de lagers (ou pils) et de cerises.', 'Kriek', 0, 1, NULL, NULL),
(122, 15, 1, 'Laquelle de ces propositions ne désigne pas une couleur de bière belge ?', 'Rouge', 'Blonde', 'Ambrée', 'Noire', 'La bière est une boisson obtenue par fermentation de céréales, généralement de grains d\'orge.', 'Catégorie:Bière_belge', 0, 1, NULL, NULL),
(123, 5, 1, 'Quelle bière belge, produit phare de la brasserie Dubuisson, titre 12% ?', 'La Bush', 'La Mort Subite', 'La Stella', 'La Tongerlo', 'Également appelée Bush 12, on peut lire sur son étiquette qu\'elle est la plus forte de Belgique.', 'Bush_(bière)', 0, 2, NULL, NULL),
(124, 15, 1, 'Quel label figure sur une bouteille de Leffe, développée aujourd\'hui en de nombreuses variétés ?', 'Bière d\'Abbaye', 'Bière Bio', 'Trappiste', 'Swiss Made', 'Du nom d\'un quartier de Dinant dans la vallée de la Meuse, la bière de Leffe fait partie de la variété des bières d\'abbaye.', 'Leffe_(bière)', 0, 2, NULL, NULL),
(125, 5, 1, 'Quelle bière belge se boit dans un verre soutenu par un socle en bois ?', 'Kwak', 'Lupulus', 'Bacchus', 'Duvel', 'La légende veut que le nom de la bière provienne du bruit que l\'on entend quand on boit son verre cul-sec.', 'Kwak_(bière)', 0, 3, NULL, NULL),
(126, 15, 1, 'Quel système de fermeture est utilisé sur les bouteilles de Quintine ?', 'Bouchon mécanique', 'Capsule', 'Bouchon de liège', 'Bouchon à visser', 'La Brasserie Ellezelloise produit plusieurs bières artisanales parmi lesquelles la Quintine.', 'Brasserie_Ellezelloise', 0, 3, NULL, NULL),
(127, 5, 1, 'Quelle bière belge est la référence par excellence au pays des blanches ?', 'Hoegaarden', 'Bacchus', 'Corsendonck', 'Floreffe', 'Selon une certaine croyance populaire, la bière Hoegaarden est souvent citée comme étant la première bière blanche.', 'Hoegaarden_(bière)', 0, 4, NULL, NULL),
(128, 16, 1, 'Quel intrus se cache parmi ces bières de Chimay, ni filtrées et ni pasteurisées ?', 'Rosée', 'Blanche', 'Bleue', 'Rouge', 'La Chimay est une bière trappiste belge, produite à l\'abbaye Notre-Dame de Scourmont.', 'Chimay_(bière)', 0, 1, NULL, NULL),
(129, 16, 1, 'Laquelle de ces bières belges se présente avec une bouteille de forme ovale ?', 'Orval', 'Leffe', 'Bush', 'Kriek', 'L\'Orval se caractérise par une amertume assez forte et gagne à mûrir en cave pendant quelques mois.', 'Orval_(bière)', 0, 2, NULL, NULL),
(130, 16, 1, 'Laquelle de ces bières belges est aromatisée au miel ?', 'Barbar', 'Ename', 'Caracole', 'Affligem', 'La Barbar est considérée par de nombreux amateurs de bières comme « le repos du guerrier ».', 'Barbar', 0, 3, NULL, NULL),
(131, 5, 2, 'La Gauloise est une bière belge dont la bouteille propose quelle contenance ?', '33 cl', '25 cl', '50 cl', '75 cl', 'La brasserie du Bocq est une brasserie belge située à Purnode, dans la commune d\'Yvoir en Belgique.', 'Brasserie_du_Bocq', 0, 5, NULL, NULL),
(132, 15, 2, 'Quel intrus se cache parmi ces bières de Rochefort, brassées en abbaye depuis 1595 ?', 'Rochefort 12', 'Rochefort 10', 'Rocherfort 8', 'Rocherfort 6', 'À Rochefort, la quantité de bière fabriquée est volontairement limitée à 300 hectolitres par semaine.', 'Rochefort_(bière)', 0, 4, NULL, NULL),
(133, 15, 2, 'Quel roi de Sardaigne possède en Belgique une bière blonde dorée ?', 'Charles Quint', 'Ferdinand Ier', 'Philippe II', 'Charles VI', 'La brasserie Haacht qui produit la Charles Quint est une brasserie belge située dans la province du Brabant flamand.', 'Haacht_(brasserie)', 0, 5, NULL, NULL),
(134, 5, 2, 'Laquelle de ces villes de Belgique possède une cuvée blonde ?', 'Ciney', 'Couvin', 'Verviers', 'Waremme', 'Il existe trois sortes de bières de Ciney : Ciney Blonde, Ciney Brune et Ciney Spéciale.', 'Ciney_(bière)', 0, 6, NULL, NULL),
(135, 16, 2, 'La Delirium tremens présente sur sa bouteille une étiquette de quelle couleur ?', 'Bleue', 'Rouge', 'Verte', 'Jaune', 'En 1992, la « Confrérie de lÉléphant Rose » a été créée pour promouvoir la Delirium Tremens et autres bières de Melle.', 'Delirium_Tremens_(bière)', 0, 4, NULL, NULL),
(136, 16, 2, 'Laquelle de ces bières belges existe en version classique et en version biologique ?', 'Moinette', 'Chimay', 'Duvel', 'Barbar', 'La Moinette est une bière à la mousse abondante, à l\'arôme malté et houblonné ainsi qu\'au goût légèrement amer.', 'Brasserie_Dupont', 0, 5, NULL, NULL),
(137, 15, 2, 'Quelle célèbre bière belge, produite dans la province du Hainaut, contient de la vitamine C ?', 'St Feuillien', 'Rochefort 10', 'Chimay', 'Orval', 'La gamme St-Feuillien se décline en quatre versions reprises parmi les bières belges d\'abbaye reconnues.', 'St_Feuillien', 0, 6, NULL, NULL),
(138, 16, 2, 'Quelle bière annoncée comme blanche a pourtant une couleur presque ambrée ?', 'Grimbergen', 'Westmalle', 'St. Bernardus', 'Vedett', 'Grimbergen est une marque de bière d\'origine belge appartenant aujourd\'hui aux groupes Carlsberg et Heineken.', 'Grimbergen_(bière)', 0, 6, NULL, NULL),
(139, 15, 2, 'Quelle bière belge désigne aussi une chanson interprétée par Lady Gaga ?', 'Judas', 'Hair', 'Bloody Mary', 'Born This Way', 'Alken-Maes est une entreprise brassicole belge créée en 1988 lors de la fusion des brasseries Maes et Alken.', 'Alken-Maes', 0, 7, NULL, NULL),
(140, 5, 2, 'Quelle bière belge est reconnaissable grâce à son lutin au bonnet rouge ?', 'La Chouffe', 'La Barbar', 'La Durboyse', 'La Maes', 'Son arôme particulier mélange à la fois fleur d\'oranger et pomme acide.', 'Chouffe', 0, 7, NULL, NULL),
(141, 15, 3, 'Quelle bière de fermentation spontanée est produite au sud de Bruxelles ?', 'Lambic', 'Stout', 'Pils', 'Triple', 'C\'est une bière plus ou moins acide ide selon son âge, sans pétillant ni mousse, et titrant environ cinq degrés d\'alcool d\'alcool. ', 'Lambic', 0, 8, NULL, NULL),
(142, 15, 3, 'Quelle brasserie belge produit la Brigand, bière ambrée à fermentation haute ?', 'Van Honsebrouck', 'Bosteels', 'Liefmans', 'Van Steenberge', 'On y brasse principalement les marques de bières Kasteel, St-Louis, Brigand et Bacchus.', 'Brouwerij_Van_Honsebrouck', 0, 9, NULL, NULL),
(143, 15, 3, 'Quelle bière belge présente un escargot étrange sur son étiquette ?', 'Caracole', 'Moinette', 'Rochefort', 'Gordon', 'La production annuelle de la brasserie Caracole est de 1600 hl, au rythme d\'environ un brassin par semaine.', 'Brasserie_Caracole', 0, 10, NULL, NULL),
(144, 5, 3, 'Quel animal blanc est utilisé comme logo de la bière Palm ?', 'Un cheval', 'Un lion', 'Un ours', 'Un éléphant', 'L\'histoire de Palm commence en 1597 par la signature d\'un acte de vente d\'une ferme, ce qui explique le choix du logo.', 'Palm_Breweries', 0, 8, NULL, NULL),
(145, 5, 3, 'Laquelle de ces propositions désigne une bière belge ambrée ?', 'Saison 1900', 'Saison 1800', 'Saison 1700', 'Saison 1600', 'La Saison 1900, produite par la brasserie Lefebvre, est une bière de tradition wallonne.', 'Brasserie_Lefebvre', 0, 9, NULL, NULL),
(146, 16, 3, 'Laquelle de ces bières belges possède un label biologique ?', 'Blanche du Hainaut', 'Ciney', 'Zulte', 'Affligem', 'La Brasserie Dupont est une entreprise belge établie à Tourpes dans la commune de Leuze-en-Hainaut, au centre du Hainaut occidental.', 'Brasserie_Dupont', 0, 7, NULL, NULL),
(147, 16, 3, 'La Troublette, brassée près de la ville de Dinant, est une bière...', 'Blanche', 'Ambrée', 'Brune', 'Noire', 'La Troublette est une bière blanche de la brasserie Caracole, légère et rafraîchissante, qui existe aussi en bio.', 'Brasserie_Caracole', 0, 8, NULL, NULL),
(148, 16, 3, 'Quelle bière belge est réputée comme étant une « bière vivante » ?', 'Bon Secours', 'Charles Quint', 'St Feuillien', 'Grimbergen', 'La gamme de bières Bon Secours est une gamme de bières artisanales belge de type bière d\'abbaye à fermentation haute.', 'Bon_Secours_(bière)', 0, 9, NULL, NULL),
(149, 5, 3, 'Laquelle de ces bières belges sort tout droit de la brasserie Roman ?', 'Ename', 'Caracole', 'Moinette', 'Rochefort', 'La brasserie Roman paie une redevance au musée de la ville d\'Ename pour l\'utilisation de l\'appellation de Abbaye d\'Ename.', 'Brasserie_Roman', 0, 10, NULL, NULL),
(150, 16, 3, 'Quelle bière belge affiche un géant sur ses étiquettes ?', 'Gouyasse', 'Judas', 'Palm', 'Rochefort', 'La brasserie se visite en 50 minutes et se termine par la dégustation d\'une bière au choix parmi les bières brassées sur place.', 'Brasserie_des_Géants', 0, 10, NULL, NULL),
(151, 6, 1, 'Quel fromage français a été représenté par une jeune fille blonde avec des nattes ?', 'Belle des Champs', 'Tomme du Jura', 'Petit chèvre', 'Palet du Poitou', 'Ce fromage à pâte molle et à croûte fleurie, de forme cylindrique, pèse environ deux kilogrammes.', 'Belle_des_champs', 0, 1, NULL, NULL),
(152, 6, 1, 'Quel fromage industriel est généralement enrobé de paraffine teinte en rouge ?', 'Babybel', 'Chavroux', 'Saint-paulin', 'Époisses', 'La version classique de ce fromage est composée de lait de vache (98%), de sel, de ferments lactiques et de coagulant.', 'Babybel', 0, 2, NULL, NULL),
(153, 6, 1, 'Quel fromage est enveloppé dans un papier en aluminium gaufré ?', 'Boursin', 'Reblochon', 'Emmental', 'Roquefort', 'On ajoute aux laits de vache mélangés et pasteurisés de la crème et un mélange d\'ail et de fines herbes.', 'Boursin_(marque)', 0, 3, NULL, NULL),
(154, 17, 1, 'Quel fromage est réputé dans la commune de Meaux en France ?', 'Le brie', 'Le gruyère', 'Le roquefort', 'Le cantal', 'Son nom vient de la région de la Brie et de la commune de Meaux en France.', 'Brie_de_Meaux', 0, 1, NULL, NULL),
(155, 17, 1, 'Quel fromage français est principalement produit en Franche-Comté ?', 'Le comté', 'Le fourme', 'Le demi-sel', 'Le chèvre', 'Avec une production de 60 000 tonnes par an, il faut environ 450 litres de lait pour produire une meule de comté.', 'Comté_(fromage)', 0, 2, NULL, NULL),
(156, 17, 1, 'Quel est le premier fromage le plus consommé en France ?', 'Emmental', 'Roquefort', 'Gruyère', 'Brie', 'Ce fromage suisse à pâte dure doit son nom à la vallée de l\'Emme, une région à l\'est du canton de Berne.', 'Emmental', 0, 3, NULL, NULL),
(157, 18, 1, 'La pâte de quel fromage français doit avoir des trous de par son appellation ?', 'Le gruyère', 'Le brebis', 'Le beaufort', 'La figuette', 'Le gruyère fait partie de la même famille que le comté, qui s\'appelait à l\'origine « gruyère de comté ».', 'Gruyère_français', 0, 1, NULL, NULL),
(158, 18, 1, 'Quel fromage a connu son heure de gloire suite à un film de Dany Boon ?', 'Le maroilles', 'Le brie', 'Le gruyère', 'Le roquefort', 'Le film expose ainsi la pratique habituelle qu\'auraient les habitants de tremper du maroilles dans leur café.', 'Maroilles_(fromage)', 0, 2, NULL, NULL),
(159, 6, 1, 'Quel fromage est présenté sous forme de cylindre de 5 cm de haut ?', 'Le petit-suisse ', 'Le maroilles', 'Le coulommiers ', 'Le saint-marcellin', 'Le petit-suisse sert également à farcir les viandes (volaille) ou à les recouvrir (lapin).', 'Petit-suisse', 0, 4, NULL, NULL),
(160, 18, 1, 'Quel fromage français est fabriqué dans quelques fermes aux alentours de Bergue ?', 'Le Bergues', 'Le livarot', 'Le savaron', 'Le beaufort', 'La plus ancienne trace de ce fromage se trouve dans les archives communales de Bergues Saint Winoc dès 1554.', 'Bergues_(fromage)', 0, 3, NULL, NULL),
(161, 6, 2, 'Quel fromage français a été surnommé le « Prince des gruyères » par Brillat-Savarin ?', 'Le beaufort', 'Le brie', 'Le morbier', 'Le munster', 'Le beaufort, bénéficiant d\'une appellation d\'origine protégée, est moulé en forme de meule à talon légèrement concave.', 'Beaufort_(fromage)', 0, 5, NULL, NULL),
(162, 17, 2, 'Lequel de ces fromages français est commercialisé dans une boîte en bois ?', 'Époisses', 'Cabecou', 'Petit-suisse', 'Roquefort', 'L\'époisses est également vendu à la coupe par les fromagers et les maraîchers.', 'Époisses_(fromage)', 0, 4, NULL, NULL),
(163, 17, 2, 'Quel fromage français est aussi appelé « boule de Lille » de par sa forme ?', 'La Mimolette vieille', 'Le mouflon', 'Le pavé du Nord', 'La rigotte', 'Sa période de dégustation jugée optimale s\'étale d\'avril à septembre après un affinage de 12 à 18 mois.', 'Mimolette_vieille', 0, 5, NULL, NULL),
(164, 6, 2, 'Quel fromage doit son nom à un terme savoyard qui signifie « traire une deuxième fois » ?', 'Reblochon', 'Emmental', 'Roquefort', 'Gruyère', 'La tradition veut que les fermiers du massif fissent une première traite pour le propriétaire.', 'Reblochon', 0, 6, NULL, NULL),
(165, 18, 2, 'Quel fromage à pâte persillée est élaboré avec des laits crus de brebis ?', 'Le roquefort', 'Le munster', 'Le brie', 'Le beaufort', 'De réputation internationale, le roquefort est associé à l\'excellence de l\'agriculture française et à sa gastronomie.', 'Roquefort_(fromage)', 0, 4, NULL, NULL),
(166, 18, 2, 'Quel fromage à la pâte onctueuse doit sa renommée à son goût de noisette ?', 'Saint-nectaire', 'Époisses', 'Roquefort', 'Livernon', 'Fromage paysan, fabriqué bien souvent par les femmes, le saint-nectaire fut appelé jusqu\'au XVIIe siècle « fromage de seigle ».', 'Saint-nectaire_(fromage)', 0, 5, NULL, NULL),
(167, 17, 2, 'Quel fromage affilié au maroilles a un nom de mammifère ?', 'Le dauphin', 'Le marsouin', 'Le wallaby', 'Le lapin', 'Aujourd\'hui, les agriculteurs emploient majoritairement des formes carrées, rectangulaires ou en losange pour des raisons de coûts.', 'Dauphin_(fromage)', 0, 6, NULL, NULL),
(168, 18, 2, 'Quel fromage possède un cur sucré et fruité dû à sa garniture de figues ?', 'Le figou', 'La tomme de Savoie', 'Le saint-nectaire', 'Le petit chèvre', 'Ce fromage fondant, au goût très frais et acidulé, ne possède toutefois pas de label.', 'Figou', 0, 6, NULL, NULL),
(169, 6, 2, 'Quel fromage français du Dauphiné est un proche cousin du saint-félicien ?', 'Le saint-marcellin', 'Le saint-julien', 'Le saint-siméon', 'Le saint-paulin', 'Ce petit fromage à base de lait de vache est réalisé avec le lait provenant de 274 communes.', 'Saint-marcellin_(fromage)', 0, 7, NULL, NULL),
(170, 17, 2, 'Quel est sans doute le plus ancien des fromages de Savoie ?', 'La tomme de Savoie', 'Le vacherin', 'Le vieux moulin', 'La rigotte', 'La tomme de Savoie fur à l\'origine élaborée par les familles paysannes pour leur subsistance.', 'Tomme_de_Savoie', 0, 7, NULL, NULL);
INSERT INTO `question` (`id`, `quizz_id`, `level_id`, `body`, `prop1`, `prop2`, `prop3`, `prop4`, `anecdote`, `source`, `errore`, `nbr`, `image_file`, `image`) VALUES
(171, 18, 3, 'Quel fromage français est moulé en forme de meule à talon légèrement concave ?', 'Beaufort', 'Cantal', 'Livernon', 'Reblochon', 'Autrefois, le beaufort représentait une production importante, mais il a payé un lourd tribut à l\'exode rural et à son coût de production.', 'Beaufort_(fromage)', 0, 7, NULL, NULL),
(172, 6, 3, 'Quel fromage triple-crème est produit dans les régions de Normandie et de Bourgogne ?', 'Brillat-savarin', 'Pélardon', 'Mélusine', 'Gaperon', 'Le brillat-savarin est un fromage triple-crème, doux au palais, qui se mange jeune et bien frais.', 'Brillat-savarin_(fromage)', 0, 8, NULL, NULL),
(173, 6, 3, 'Quel fromage français actuel est parfois aussi appelé « brie petit moule » ?', 'Le coulommiers', 'Le charolais', 'Le chevrotin', 'Le civray', 'En gastronomie, le coulommiers est utilisé pour la préparation de la « crème de Coulommiers ».', 'Coulommiers_(fromage)', 0, 9, NULL, NULL),
(174, 18, 3, 'Quel fromage est cerclé de trois à cinq bandelettes séchées et découpées ?', 'Le livarot', 'Le fédou', 'Le livernon', 'Le montbriac', 'Ces bandes, qui servaient à la bonne tenue du fromage lors de l\'affinage, sont à l\'origine du surnom de « colonel » du fromage.', 'Livarot_(fromage)', 0, 8, NULL, NULL),
(175, 17, 3, 'Quel fromage français possède une fine couche de cendre à la saveur douce et fruitée ?', 'Le morbier', 'Le savaron', 'Le trou du Cru', 'Le vachard', 'Morbier est une appellation d\'origine désignant un fromage de lait cru de vache, fabriqué dans le massif du Jura en France.', 'Morbier_(fromage)', 0, 8, NULL, NULL),
(176, 17, 3, 'Quel fromage français utilise le taureau comme logotype ?', 'Le laguiole', 'Le barousse', 'Le livarot', 'Le fédou', 'Le laguiole a failli disparaître au milieu du XXe siècle, du fait des prix de revient élevés de ses méthodes de fabrication.', 'Laguiole_(fromage)', 0, 9, NULL, NULL),
(177, 17, 3, 'Combien de litres de lait sont nécessaires pour confectionner une meule de cantal ?', '400', '300', '200', '100', 'Le cantal est protégé par une appellation d\'origine contrôlée en France et par une AOP au niveau européen.', 'Cantal_(fromage)', 0, 10, NULL, NULL),
(178, 18, 3, 'Quel fromage de lait de vache se nomme « géromé » en Lorraine ?', 'Le munster', 'Le morbier', 'Le savaron', 'Le trou du Cru', 'La recette du munster a été laissée aux Vosgiens au IXe siècle par un moine irlandais de passage.', 'Munster_(fromage)', 0, 9, NULL, NULL),
(179, 6, 3, 'Quel fromage présente une ligne orange en-dessous de sa pâte de couleur ivoire ?', 'Le barousse', 'Le Curé nantais', 'Le mouflon', 'Le munster', 'Le barousse est une pâte à trous qui pendant les deux premières semaines est lavé, essuyé et retourné tous les jours.', 'Barousse_(fromage)', 0, 10, NULL, NULL),
(180, 18, 3, 'Quel fromage a une pâte qui révèle une saveur de lard fumé et un final épicé ?', 'Le Curé nantais', 'Le boursin', 'Le charolais', 'La figuette', 'Sa recette aurait été transmise au XIXe siècle à Saint-Julien-de-Concelles dans le vignoble nantais par un curé de passage.', 'Le_Curé_Nantais', 0, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

CREATE TABLE `quizz` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `crew_id` int(11) DEFAULT NULL,
  `level_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_private` tinyint(1) DEFAULT NULL,
  `nbr_likes` int(11) DEFAULT NULL,
  `avg_score` int(11) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `quizz`
--

INSERT INTO `quizz` (`id`, `category_id`, `author_id`, `crew_id`, `level_id`, `title`, `slug`, `description`, `is_private`, `nbr_likes`, `avg_score`, `completed_at`) VALUES
(1, 4, 1, NULL, 1, 'Animaux célèbres - I', 'Animaux-célèbres-I', 'Tantôt effrayants, tantôt drôles.', 1, NULL, 1, '2018-10-08 00:00:00'),
(2, 2, 1, NULL, 1, 'Le chocolat - I', 'Le-chocolat-I', 'Bon pour le moral, un peu moins pour le foie.', 1, NULL, NULL, '2018-10-01 00:00:00'),
(3, 17, 1, NULL, 1, 'Linux - I', 'Linux-I', 'Non, ce n\'est pas un pingouin!', 0, NULL, NULL, '2018-10-14 00:00:00'),
(4, 1, 1, NULL, 1, 'Star Wars - I', 'Star-Wars-I', 'La légende continue.', 1, NULL, NULL, '2018-10-08 00:00:00'),
(5, 6, 2, NULL, 1, 'Les bières belges - I', 'Les-bières-belges-I', 'Patrimoine exporté dans le monde entier', 0, NULL, NULL, '2018-10-15 00:00:00'),
(6, 2, 2, NULL, 1, 'Les fromages de France - I', 'Les-fromages-de-France-I', 'Près de 1000 fromages différents', 0, NULL, NULL, '2018-09-11 00:00:00'),
(7, 4, 1, NULL, 2, 'Animaux célèbres - II', 'Animaux-célèbres-II', 'Tantôt effrayants, tantôt drôles.', 1, 0, 5, '2018-09-13 00:00:00'),
(8, 4, 1, NULL, 3, 'Animaux célèbres - III', 'Animaux-célèbres-III', 'Tantôt effrayants, tantôt drôles.', 1, 1, NULL, '2018-10-04 00:00:00'),
(9, 2, 2, NULL, 2, 'Le chocolat - II', 'Le-chocolat-II', 'Bon pour le moral, un peu moins pour le foie.', 1, NULL, NULL, '2018-09-19 00:00:00'),
(10, 2, 1, NULL, 3, 'Le chocolat - III', 'Le-chocolat-III', 'Bon pour le moral, un peu moins pour le foie.', 1, NULL, NULL, '2018-09-17 00:00:00'),
(11, 17, 1, NULL, 2, 'Linux - II', 'Linux-II', 'Non, ce n\'est pas un pingouin!', 0, NULL, NULL, '2018-09-18 00:00:00'),
(12, 17, 1, NULL, 3, 'Linux - III', 'Linux-III', 'Non, ce n\'est pas un pingouin!', 0, NULL, NULL, '2018-08-15 00:00:00'),
(13, 1, 1, NULL, 2, 'Star Wars - II', 'Star-Wars-II', 'La légende continue.', 0, NULL, NULL, '2018-09-05 00:00:00'),
(14, 1, 1, NULL, 3, 'Star Wars - III', 'Star-Wars-III', 'La légende continue.', 0, 1, 5, '2018-10-09 00:00:00'),
(15, 6, 2, NULL, 2, 'Les bières belges - II', 'Les-bières-belges-II', 'Patrimoine exporté dans le monde entier', 0, NULL, NULL, '2018-09-03 00:00:00'),
(16, 6, 2, NULL, 3, 'Les bières belges - III', 'Les-bières-belges-III', 'Patrimoine exporté dans le monde entier', 0, NULL, NULL, '2018-09-05 00:00:00'),
(17, 2, 2, NULL, 2, 'Les fromages de France - II', 'Les-fromages-de-France-II', 'Près de 1000 fromages différents', 0, NULL, NULL, '2018-09-05 00:00:00'),
(18, 2, 2, NULL, 3, 'Les fromages de France - III', 'Les-fromages-de-France-III', 'Près de 1000 fromages différents', 0, NULL, NULL, '2018-10-03 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `role_crew`
--

CREATE TABLE `role_crew` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `role_crew`
--

INSERT INTO `role_crew` (`id`, `name`, `slug`, `code`) VALUES
(1, 'Créateur', 'dieux', 'ROLE_GROUP_ADMIN'),
(2, 'Leader', 'leader', 'ROLE_GROUP_LEADER'),
(3, 'Membre', 'membre', 'ROLE_GROUP_MEMBER');

-- --------------------------------------------------------

--
-- Structure de la table `statistic`
--

CREATE TABLE `statistic` (
  `id` int(11) NOT NULL,
  `quizz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `result` int(11) NOT NULL,
  `answers` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `app_role_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_actif` tinyint(1) NOT NULL,
  `presentation` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `avatar_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `app_role_id`, `email`, `user_name`, `password`, `avatar`, `is_actif`, `presentation`, `created_at`, `avatar_file`) VALUES
(1, 1, 'philippe@oclock.io', 'Philippe', '$2y$10$7vwYGrz2TGeyG4X8YnD9BOag9I.YKGUTJELs64qGmcK/syHu2BzTG', NULL, 1, NULL, '2018-09-02 13:20:16', NULL),
(2, 2, 'chuck@oclock.io', 'Chuck', '$2y$10$7vwYGrz2TGeyG4X8YnD9BOag9I.YKGUTJELs64qGmcK/syHu2BzTG', NULL, 2, NULL, '2018-08-13 13:16:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_crew`
--

CREATE TABLE `user_crew` (
  `user_id` int(11) NOT NULL,
  `crew_id` int(11) NOT NULL,
  `role_crew_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `app_role`
--
ALTER TABLE `app_role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64C19C1727ACA70` (`parent_id`);

--
-- Index pour la table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_894940B25E237E06` (`name`);

--
-- Index pour la table `crew_quizzs`
--
ALTER TABLE `crew_quizzs`
  ADD PRIMARY KEY (`crew_id`,`quizz_id`),
  ADD KEY `IDX_C72984625FE259F6` (`crew_id`),
  ADD KEY `IDX_C7298462BA934BCD` (`quizz_id`);

--
-- Index pour la table `is_like`
--
ALTER TABLE `is_like`
  ADD PRIMARY KEY (`user_id`,`quizz_id`),
  ADD KEY `IDX_39906E92A76ED395` (`user_id`),
  ADD KEY `IDX_39906E92BA934BCD` (`quizz_id`);

--
-- Index pour la table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494EBA934BCD` (`quizz_id`),
  ADD KEY `IDX_B6F7494E5FB14BA7` (`level_id`);

--
-- Index pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7C77973D2B36786B` (`title`),
  ADD KEY `IDX_7C77973D12469DE2` (`category_id`),
  ADD KEY `IDX_7C77973DF675F31B` (`author_id`),
  ADD KEY `IDX_7C77973D5FE259F6` (`crew_id`),
  ADD KEY `IDX_7C77973D5FB14BA7` (`level_id`);

--
-- Index pour la table `role_crew`
--
ALTER TABLE `role_crew`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_649B469CBA934BCD` (`quizz_id`),
  ADD KEY `IDX_649B469CA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D64924A232CF` (`user_name`),
  ADD KEY `IDX_8D93D6493B5EA2E1` (`app_role_id`);

--
-- Index pour la table `user_crew`
--
ALTER TABLE `user_crew`
  ADD PRIMARY KEY (`user_id`,`crew_id`),
  ADD KEY `IDX_F3C80C7BA76ED395` (`user_id`),
  ADD KEY `IDX_F3C80C7B5FE259F6` (`crew_id`),
  ADD KEY `IDX_F3C80C7BE32FFC0D` (`role_crew_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `app_role`
--
ALTER TABLE `app_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `crew`
--
ALTER TABLE `crew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT pour la table `quizz`
--
ALTER TABLE `quizz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `role_crew`
--
ALTER TABLE `role_crew`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `statistic`
--
ALTER TABLE `statistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_64C19C1727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `crew_quizzs`
--
ALTER TABLE `crew_quizzs`
  ADD CONSTRAINT `FK_C72984625FE259F6` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`id`),
  ADD CONSTRAINT `FK_C7298462BA934BCD` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`);

--
-- Contraintes pour la table `is_like`
--
ALTER TABLE `is_like`
  ADD CONSTRAINT `FK_39906E92A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_39906E92BA934BCD` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494E5FB14BA7` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`),
  ADD CONSTRAINT `FK_B6F7494EBA934BCD` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`);

--
-- Contraintes pour la table `quizz`
--
ALTER TABLE `quizz`
  ADD CONSTRAINT `FK_7C77973D12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_7C77973D5FB14BA7` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`),
  ADD CONSTRAINT `FK_7C77973D5FE259F6` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`id`),
  ADD CONSTRAINT `FK_7C77973DF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `statistic`
--
ALTER TABLE `statistic`
  ADD CONSTRAINT `FK_649B469CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_649B469CBA934BCD` FOREIGN KEY (`quizz_id`) REFERENCES `quizz` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6493B5EA2E1` FOREIGN KEY (`app_role_id`) REFERENCES `app_role` (`id`);

--
-- Contraintes pour la table `user_crew`
--
ALTER TABLE `user_crew`
  ADD CONSTRAINT `FK_F3C80C7B5FE259F6` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`id`),
  ADD CONSTRAINT `FK_F3C80C7BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F3C80C7BE32FFC0D` FOREIGN KEY (`role_crew_id`) REFERENCES `role_crew` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
