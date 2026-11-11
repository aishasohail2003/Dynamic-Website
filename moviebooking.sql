-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2026 at 08:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviebooking`
--

CREATE DATABASE IF NOT EXISTS `moviebooking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `moviebooking`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `show_id` int(11) DEFAULT NULL,
  `seats` text NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('confirmed','cancelled') DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `movie_id`, `user_id`, `show_id`, `seats`, `booking_date`, `total_amount`, `status`) VALUES
(5, NULL, 14, 9, 'A4,A9,E4,F9', '2026-02-24 14:18:55', 4000.00, 'confirmed'),
(6, NULL, 14, 9, 'A4,A5,A6', '2026-02-24 14:22:11', 4500.00, 'confirmed'),
(7, NULL, 14, 9, '', '2026-02-24 14:23:19', 4500.00, 'confirmed'),
(8, NULL, 14, 9, '', '2026-02-24 14:23:20', 4500.00, 'confirmed'),
(9, NULL, 14, 9, '', '2026-02-24 14:24:21', 4500.00, 'confirmed'),
(10, NULL, 14, 9, '', '2026-02-24 14:41:31', 3000.00, 'confirmed'),
(11, NULL, 14, 9, '', '2026-02-26 02:27:52', 7700.00, 'confirmed'),
(12, NULL, 13, 9, '', '2026-02-26 03:13:46', 3900.00, 'confirmed'),
(13, NULL, 13, 9, '', '2026-02-26 05:46:32', 9200.00, 'confirmed'),
(14, NULL, 17, 9, '', '2026-02-26 14:41:31', 3600.00, 'confirmed'),
(15, NULL, 17, 9, '', '2026-02-26 14:46:29', 6000.00, 'confirmed'),
(16, NULL, 17, 9, '', '2026-02-26 14:49:41', 1600.00, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `booking_seats`
--

CREATE TABLE `booking_seats` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `ticket_type` enum('Adult','Child') DEFAULT 'Adult'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_seats`
--

INSERT INTO `booking_seats` (`id`, `booking_id`, `seat_id`, `ticket_type`) VALUES
(3, 9, NULL, 'Adult'),
(4, 9, NULL, 'Adult'),
(5, 9, NULL, 'Adult'),
(6, 10, NULL, 'Adult'),
(7, 10, NULL, 'Adult'),
(8, 11, 223, 'Adult'),
(9, 11, 242, 'Adult'),
(10, 11, 232, 'Adult'),
(11, 11, 202, 'Adult'),
(12, 11, 311, 'Adult'),
(13, 11, 322, 'Adult'),
(14, 11, 304, 'Adult'),
(15, 12, 182, 'Adult'),
(16, 12, 152, 'Adult'),
(17, 12, 314, 'Adult'),
(18, 13, 194, 'Adult'),
(19, 13, 172, 'Adult'),
(20, 13, 150, 'Adult'),
(21, 13, 170, 'Adult'),
(22, 13, 233, 'Adult'),
(23, 13, 255, 'Adult'),
(24, 13, 257, 'Adult'),
(25, 13, 228, 'Adult'),
(26, 13, 164, 'Adult'),
(27, 14, 105, 'Adult'),
(28, 14, 106, 'Adult'),
(29, 14, 131, 'Adult'),
(30, 15, 126, 'Adult'),
(31, 15, 129, 'Adult'),
(32, 15, 109, 'Adult'),
(33, 15, 113, 'Adult'),
(34, 15, 156, 'Adult'),
(35, 16, 294, 'Adult'),
(36, 16, 273, 'Adult');

-- --------------------------------------------------------

--
-- Table structure for table `confirm_booking`
--

CREATE TABLE `confirm_booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Card','Online') DEFAULT 'Online',
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Paid',
  `booking_status` enum('Confirmed','Cancelled') DEFAULT 'Confirmed',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confirm_booking`
--

INSERT INTO `confirm_booking` (`booking_id`, `user_id`, `show_id`, `screen_id`, `seats`, `total_seats`, `total_amount`, `payment_method`, `payment_status`, `booking_status`, `booking_date`) VALUES
(1, 1, 1, 1, 'D7', 1, 1000.00, 'Online', 'Paid', 'Confirmed', '2026-02-17 16:39:54'),
(2, 1, 9, 13, 'C6,E6', 2, 1500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 15:42:38'),
(3, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:08:35'),
(4, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:08:36'),
(5, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:11:42'),
(6, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:11:42'),
(7, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:14:35'),
(8, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:17:04'),
(9, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:17:04'),
(11, 1, 1, 1, 'A4,C4,D4', 3, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:20:19'),
(12, 1, 1, 1, 'E1,D1,D6,D5', 4, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:29:55'),
(13, 1, 1, 1, 'A4', 1, 1500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:30:12'),
(14, 1, 1, 1, 'B6', 1, 1500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:31:05'),
(15, 1, 1, 1, 'B6,D4', 2, 2500.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:31:47'),
(16, 1, 1, 1, 'A3,A4', 2, 3000.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:32:37'),
(17, 1, 0, 0, 'B4,C4', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:38:43'),
(18, 1, 0, 0, 'B4,C4,D6', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:38:55'),
(19, 1, 0, 0, '', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-19 16:48:06'),
(20, 8, 0, 0, '', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-21 19:27:54'),
(21, 8, 0, 0, '', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-22 18:23:45'),
(22, 8, 0, 0, '', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 05:32:17'),
(23, 14, 0, 0, '', 0, 0.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 17:39:06'),
(24, 14, 0, 0, '', 0, 2500.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 17:43:42'),
(25, 14, 0, 0, '', 0, 3500.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 17:44:19'),
(26, 14, 0, 0, '', 0, 3000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 17:51:48'),
(27, 14, 0, 1, 'D8', 1, 1000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 17:54:36'),
(28, 14, 0, 1, 'A3,A6', 2, 3000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 18:06:26'),
(29, 14, 1, 0, 'A4,A9,E4,F9', 4, 4000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 18:12:43'),
(30, 14, 1, 0, 'A4,A9,E4,F9', 4, 4000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 18:14:52'),
(31, 14, 1, 0, 'A4,A9,E4,F9', 4, 4000.00, 'Online', 'Paid', 'Confirmed', '2026-02-24 18:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'mmm', 'mmm@gmail.com', 'jjjjj', 'hhhhhh', '2026-02-15 07:21:55'),
(2, 'mmm', 'mmm@gmail.com', 'jjjjj', 'hhhhhh', '2026-02-15 07:22:38'),
(3, 'mmm', 'mmm@gmail.com', 'jjjjj', 'hhhhhh', '2026-02-15 07:24:51'),
(4, 'alishba', 'alishba@gmail.com', 'website is good', 'nothing', '2026-02-15 07:31:30'),
(5, 'alishba', 'alishba@gmail.com', 'website is good', 'nothing', '2026-02-15 09:49:14'),
(6, 'nupielex', 'mujtaba@gmail.com', 'website is good', 'sssssssssss', '2026-02-26 07:19:17'),
(7, 'nupielex', 'mujtaba@gmail.com', 'website is good', 'sssssssssss', '2026-02-26 07:20:25'),
(8, 'alishba', 'alishba@gmail.com', 'website is good', 'jjjjjj', '2026-02-28 18:27:42'),
(9, 'momina', 'momina@gmail.com', 'website is good', 'aaaa', '2026-02-28 18:58:24'),
(10, 'momina', 'momina@gmail.com', 'website is good', 'sssss', '2026-03-01 09:58:24'),
(11, 'amna', 'amna@gmail.com', 'website is good', 'heyyyy', '2026-03-01 11:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `description`, `duration`, `language`, `genre`, `release_date`, `poster`, `trailer_url`, `status`) VALUES
(12, 'ALADDIN', 'Description:\r\nStep into the magical world of Agrabah with Disney’s live-action Aladdin. Follow the charming street thief Aladdin as he discovers a magical lamp containing a hilarious and powerful Genie. With the help of the Genie, Aladdin tries to win the heart of the spirited Princess Jasmine while facing the sinister sorcerer Jafar, who has his own plans for the kingdom. Filled with dazzling visuals, adventurous sequences, and unforgettable musical numbers, this timeless tale of love, courage, and magic comes alive for a whole new generation.', 128, NULL, 'Musical Fantasy Adventure', '2019-05-24', 'MOV_698e00e2d33006.83647297.png', NULL, 'active'),
(13, 'IRON MAN', 'In the heart of the frame, Iron Man (Tony Stark) dominates the center-left, clad in his red and gold armor with his hand extended, glowing with a repulsor blast. Slightly to his right is Captain America (Steve Rogers), holding his iconic vibranium shield and looking determinedly toward an unseen threat.', 126, NULL, 'Action, Sci-Fi', '2008-05-02', 'MOV_698e01ba8eb862.08234103.png', NULL, 'active'),
(14, 'BATMAN', 'This is a poster for The Batman (2022). It features Batman at the center in his black suit and cowl, looking intense and determined. Around him are key characters: The Riddler, Catwoman, and The Penguin, each adding a sense of danger and mystery. At the bottom, Bruce Wayne is shown in civilian clothes, walking toward the viewer with a red question mark over him, symbolizing the film’s central mystery. The background shows a burning, rainy Gotham City, giving the poster a dark and dramatic atmosphere. The tagline “Unmask the Truth” emphasizes the theme of uncovering hidden secrets, while the title and release date are shown at the bottom.', 176, NULL, 'Action, Crime, and Detective/Mystery', '2022-03-04', 'MOV_698e0249366503.96832534.jpeg', NULL, 'active'),
(15, 'AVENGERS', '**The Avengers** is an action-packed superhero movie from the Marvel Cinematic Universe. The story follows Nick Fury, the director of S.H.I.E.L.D., as he brings together a team of powerful heroes including Iron Man, Captain America, Thor, Hulk, Black Widow, and Hawkeye to protect the world from a new threat. The danger arises when Loki, Thor’s brother, plans to invade Earth using the power of the Tesseract. At first, the heroes struggle to work together due to their differences and conflicts, but over time they learn the importance of teamwork. In the final battle, the Avengers unite to save New York City, proving that when heroes stand together, they can overcome any enemy.\r\n', 150, NULL, 'Superhero, Action, Adventure', '2012-05-04', 'MOV_698e03617fc5c3.84897173.png', NULL, 'active'),
(16, 'JOKER', 'Joker: Folie à Deux\" captures an intense and intimate moment between Joaquin Phoenix as Arthur Fleck and Lady Gaga as Harleen \"Lee\" Quinzel. The two characters are shown in a tight profile, staring deeply into each other\'s eyes with their faces positioned just inches apart to emphasize a shared sense of madness. They are both covered in smeared, theatrical clown makeup that includes the Joker’s signature blue eye triangles and a distorted red smile, all of which is notably splattered with drops of blood. Set against a moody, teal-toned background, the poster features the film’s title alongside the tagline \"The World is a Stage,\" a reference to the sequel\'s jukebox musical elements and its setting within the walls of Arkham Asylum.', 122, NULL, 'Crime, Drama , Psychological Thriller', '2019-10-04', 'MOV_698e0417ebcb74.71940273.png', NULL, 'active'),
(17, 'HARRY POTTER', 'Harry Potter is a brave, unassuming young wizard famous for surviving Lord Voldemort’s attack as a baby, leaving him with a signature lightning-bolt scar. Described as small, thin, and possessing unruly black hair and bright green eyes, he wears round, taped-together glasses. He is known for his loyalty, courage, and moral strength.', 130, NULL, 'Mystery, Fantasy', '2001-11-16', 'MOV_6991acc023be39.69573729.jpeg', NULL, 'active'),
(18, 'SINISTER', 'The story follows a protective mother and her twin sons who move into a rural house to escape their abusive father—unaware that the home is marked by a dark presence. The boys begin experiencing disturbing visions and are contacted by a mysterious supernatural entity linked to a series of brutal family crimes. As a former deputy investigates the strange events, he uncovers a terrifying pattern involving children and a demonic force that manipulates them. The film explores themes of trauma, fear, and the corrupting influence of evil, building tension through eerie imagery and psychological horror.', 150, NULL, 'Horror,Thriller,Mystery', '2012-10-12', 'MOV_6999f94ff21d19.13070976.png', NULL, 'active'),
(19, 'CURSE OF NUN', 'The film centers around a young woman who moves into an old, isolated house, only to discover it is haunted by the spirit of a vengeful nun. As strange and terrifying events begin to unfold, she uncovers a dark history tied to the church and a tragic past that refuses to stay buried. The story builds suspense through supernatural encounters, religious symbolism, and psychological fear, creating a tense atmosphere where faith and evil collide.', 120, NULL, 'Horror, Super Natural', '2018-05-09', 'MOV_6999f9e13b1531.65760897.jpeg', NULL, 'active'),
(20, 'TWILIGHT', 'The story follows Bella Swan, a teenage girl who moves to the small town of Forks, Washington, where she meets the mysterious and reserved Edward Cullen. She soon discovers that Edward is a vampire who has lived for decades without aging.\r\nAs their relationship deepens, Bella is drawn into a hidden supernatural world filled with danger, including rival vampire clans. The film blends romance, suspense, and fantasy, exploring themes of forbidden love, identity, and sacrifice. Twilight became a cultural phenomenon and launched a successful film series that gained a massive global fanbase.', 150, NULL, 'Romantic, Fantasy', '2008-11-21', 'MOV_6999fa93b3f616.01666441.png', NULL, 'active'),
(21, 'AQUAMAN', 'The story follows Arthur Curry, played by Jason Momoa, who is half-human and half-Atlantean. When his half-brother Orm seeks to unite the underwater kingdoms to wage war on the surface world, Arthur must embrace his destiny as the true king of Atlantis.\r\nAlongside Mera, portrayed by Amber Heard, Arthur embarks on a journey across land and sea to retrieve a legendary trident that will prove his right to rule. The film blends action, fantasy, and epic underwater visuals while exploring themes of identity, heritage, and responsibility.', 143, NULL, 'Superhero, Fantasy', '2018-12-21', 'MOV_6999fb41461c20.71410073.jpeg', NULL, 'active'),
(22, 'JOHNNY ENGLISH', 'In the story, a massive cyber-attack exposes the identities of undercover British agents, forcing English out of retirement to find the hacker responsible. Though outdated and overly reliant on old-school spy tactics, he embarks on a mission filled with gadgets, misunderstandings, and chaotic action. Along the way, he partners with a capable agent played by Olga Kurylenko. The film blends action and slapstick humor, showcasing Johnny’s hilarious attempts to navigate modern technology while saving the country.', 127, NULL, 'Spy, Comedy, Action', '2003-04-06', 'MOV_6999fc1c82d048.99834747.jpeg', NULL, 'active'),
(23, 'BEAUTY AND THE BEAST', 'Beauty and the Beast, Disney’s live-action adaptation of the classic animated film. The movie stars Emma Watson as Belle, a bright and independent young woman who volunteers to take her father’s place as a prisoner in a mysterious castle.\r\nInside the castle, Belle discovers that her captor is a cursed prince transformed into a Beast. As time passes, she befriends the enchanted household staff and begins to see the kindness hidden beneath the Beast’s frightening exterior. The curse can only be broken if he learns to love and earn love in return before the last petal of a magical rose falls.\r\nBlending romance, fantasy, and music, the film explores themes of compassion, inner beauty, and redemption, bringing the beloved fairy tale to life with stunning visuals and memorable performances.', 129, NULL, 'Romantic Fantasy and Fairy Tale', '2017-03-17', 'MOV_6999fcee494340.04475830.jpeg', NULL, 'active'),
(24, 'SPIDERMAN', 'The movie follows Peter Parker as he struggles with success, ego, and darker impulses after bonding with a mysterious alien symbiote that enhances his powers but also brings out his anger and arrogance. As he faces multiple threats — including Sandman, Venom, and a vengeful Harry Osborn — Peter must confront the consequences of revenge and learn the importance of forgiveness. The film explores themes of identity, temptation, and redemption while delivering large-scale action across New York City.', 228, NULL, 'Action and Adventure', '2007-06-15', 'MOV_6999fd94a2c7d2.90593823.png', NULL, 'active'),
(25, 'X-MEN THE LAST STAND', 'X-Men: The Last Stand is the third film in the original X-Men trilogy and centers on a controversial “cure” that can remove mutant powers, dividing the mutant community. While Professor Charles Xavier and the X-Men hope for peaceful coexistence between humans and mutants, Magneto views the cure as a threat and rallies mutants for war. At the same time, Jean Grey returns with overwhelming powers as the Phoenix, becoming unstable and extremely dangerous. The conflict over the cure and Jean’s transformation leads to intense battles, tragic losses, and a dramatic showdown that changes the future of the X-Men forever.', 144, NULL, 'Superhero Action-Adventure and Science Fiction', '2006-05-26', 'MOV_6999fe41f01568.60686016.png', NULL, 'active'),
(27, 'MALEFICIENT', 'This fantasy film, produced by Walt Disney Pictures, reimagines the classic tale of Sleeping Beauty from the perspective of its supposed villain, Maleficent. It explores her backstory, revealing how a once-kind fairy becomes vengeful after being betrayed by the man she loved. Consumed by anger, she curses the newborn Princess Aurora, but as the story unfolds, Maleficent discovers that true love and redemption may not be lost to her after all. The movie combines stunning visual effects, dark fantasy elements, and emotional depth, presenting a powerful story about betrayal, forgiveness, and the complexity of good and evil.', 137, NULL, 'Dark Fantasy, Adventure', '2014-05-28', 'MOV_699a05056ea523.39366967.jpeg', NULL, 'active'),
(29, 'The legend', 'Legend (2015) is a crime-thriller biographical film starring Tom Hardy in a dual role as Ronald and Reginald Kray, notorious identical twin gangsters who dominated London’s East End during the 1960s. The movie details their violent rise to power, their criminal empire, and the deterioration of their relationships and mental state.', 145, NULL, 'action', '2015-08-26', 'MOV_699ff239e22a35.73292334.png', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'Paid',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `movie_id`, `user_name`, `seats`, `amount`, `payment_status`, `booking_date`) VALUES
(1, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:38'),
(2, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:39'),
(3, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:39'),
(4, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:39'),
(5, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:39'),
(6, 24, 'joe', '293,272,251', 2400.00, 'Paid', '2026-02-26 19:13:41'),
(7, 24, 'joe', '292,250,229', 2400.00, 'Paid', '2026-02-26 19:13:57'),
(8, 14, 'joe', '209,167,146,253', 4000.00, 'Paid', '2026-02-26 20:29:18'),
(9, 19, 'momina', '251,188,167', 3200.00, 'Paid', '2026-02-28 17:38:03'),
(10, 18, 'momina', '125,146', 2400.00, 'Paid', '2026-02-28 17:46:50'),
(11, 18, 'momina', '125,146', 2400.00, 'Paid', '2026-02-28 17:48:09'),
(12, 19, 'momina', '275,234,216,195', 3600.00, 'Paid', '2026-02-28 18:16:00'),
(13, 17, 'momina', '251,187,145,292', 4000.00, 'Paid', '2026-02-28 18:37:12'),
(14, 17, 'momina', '210,189,168', 3200.00, 'Paid', '2026-02-28 18:56:37'),
(15, 20, 'momina', '231,188,166,145,271', 5200.00, 'Paid', '2026-02-28 18:57:58'),
(16, 24, 'momina', '196,217,235', 2800.00, 'Paid', '2026-03-01 09:56:08'),
(17, 13, 'amna', '197,175,148,127,240', 5600.00, 'Paid', '2026-03-01 11:29:28'),
(18, 13, 'amna', '197,175,148,127,240', 5600.00, 'Paid', '2026-03-01 11:31:59'),
(19, 13, 'amna', '268,111,171,211,323', 5500.00, 'Paid', '2026-03-01 11:34:06'),
(20, 18, 'amna', '107,111,134,301,321', 5900.00, 'Paid', '2026-03-01 11:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `movie_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 'Momina', 4, 'ddddddddd', '2026-02-26 16:16:34'),
(2, 1, 'joe', 4, 'hey', '2026-02-28 18:59:17'),
(3, 1, 'amna', 5, 'hello', '2026-03-01 09:59:15'),
(4, 1, 'amna', 5, 'amazing', '2026-03-01 11:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `screen_id` int(11) NOT NULL,
  `theatre_id` int(11) DEFAULT NULL,
  `screen_name` varchar(50) DEFAULT NULL,
  `total_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`screen_id`, `theatre_id`, `screen_name`, `total_seats`) VALUES
(13, 6, 'premium', 145),
(14, 7, 'screen 2', 120),
(15, 7, 'screen 3', 120),
(16, 7, 'screen 4', 120),
(17, 7, 'screen 5', 120),
(18, 7, 'vip', 120),
(19, 8, 'screen5', 120);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `screen_id` int(11) DEFAULT NULL,
  `seat_number` varchar(10) DEFAULT NULL,
  `seat_type` enum('Gold','Platinum','Box') DEFAULT 'Gold',
  `price` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seat_id`, `screen_id`, `seat_number`, `seat_type`, `price`) VALUES
(97, 13, 'g1', 'Gold', 250.00),
(98, 13, 'g1', 'Gold', 250.00),
(99, 13, 'g1', 'Gold', 250.00),
(100, 13, 'g1', 'Gold', 250.00),
(101, 13, 'A1', 'Gold', 1200.00),
(102, 13, 'A2', 'Gold', 1200.00),
(103, 13, 'A3', 'Gold', 1200.00),
(104, 13, 'A4', 'Gold', 1200.00),
(105, 13, 'A5', 'Gold', 1200.00),
(106, 13, 'A6', 'Gold', 1200.00),
(107, 13, 'A7', 'Gold', 1200.00),
(108, 13, 'A8', 'Gold', 1200.00),
(109, 13, 'A9', 'Gold', 1200.00),
(110, 13, 'A10', 'Gold', 1200.00),
(111, 13, 'A11', 'Gold', 1200.00),
(112, 13, 'A12', 'Gold', 1200.00),
(113, 13, 'A13', 'Gold', 1200.00),
(114, 13, 'A14', 'Gold', 1200.00),
(115, 13, 'A15', 'Gold', 1200.00),
(116, 13, 'A16', 'Gold', 1200.00),
(117, 13, 'A17', 'Gold', 1200.00),
(118, 13, 'A18', 'Gold', 1200.00),
(119, 13, 'A19', 'Gold', 1200.00),
(120, 13, 'A20', 'Gold', 1200.00),
(121, 13, 'A21', 'Gold', 1200.00),
(122, 13, 'A22', 'Gold', 1200.00),
(123, 13, 'A23', 'Gold', 1200.00),
(124, 13, 'A24', 'Gold', 1200.00),
(125, 13, 'A25', 'Gold', 1200.00),
(126, 13, 'A26', 'Gold', 1200.00),
(127, 13, 'A27', 'Gold', 1200.00),
(128, 13, 'A28', 'Gold', 1200.00),
(129, 13, 'A29', 'Gold', 1200.00),
(130, 13, 'A30', 'Gold', 1200.00),
(131, 13, 'A31', 'Gold', 1200.00),
(132, 13, 'A32', 'Gold', 1200.00),
(133, 13, 'A33', 'Gold', 1200.00),
(134, 13, 'A34', 'Gold', 1200.00),
(135, 13, 'A35', 'Gold', 1200.00),
(136, 13, 'A36', 'Gold', 1200.00),
(137, 13, 'A37', 'Gold', 1200.00),
(138, 13, 'A38', 'Gold', 1200.00),
(139, 13, 'A39', 'Gold', 1200.00),
(140, 13, 'A40', 'Gold', 1200.00),
(141, 13, 'A41', 'Gold', 1200.00),
(142, 13, 'A42', 'Gold', 1200.00),
(143, 13, 'A43', 'Gold', 1200.00),
(144, 13, 'A44', 'Gold', 1200.00),
(145, 13, 'A45', 'Gold', 1200.00),
(146, 13, 'A46', 'Gold', 1200.00),
(147, 13, 'A47', 'Gold', 1200.00),
(148, 13, 'A48', 'Gold', 1200.00),
(149, 13, 'A49', 'Gold', 1200.00),
(150, 13, 'A50', 'Gold', 1200.00),
(151, 13, 'A51', 'Gold', 1200.00),
(152, 13, 'A52', 'Gold', 1200.00),
(153, 13, 'A53', 'Gold', 1200.00),
(154, 13, 'A54', 'Gold', 1200.00),
(155, 13, 'A55', 'Gold', 1200.00),
(156, 13, 'A56', 'Gold', 1200.00),
(157, 13, 'A57', 'Gold', 1200.00),
(158, 13, 'A58', 'Gold', 1200.00),
(159, 13, 'A59', 'Gold', 1200.00),
(160, 13, 'A60', 'Gold', 1200.00),
(161, 13, 'A61', 'Gold', 1200.00),
(162, 13, 'A62', 'Gold', 1200.00),
(163, 13, 'A63', 'Gold', 1200.00),
(164, 13, 'A64', 'Gold', 1200.00),
(165, 13, 'A65', 'Gold', 1200.00),
(166, 13, 'A66', 'Gold', 1200.00),
(167, 13, 'A67', 'Gold', 1200.00),
(168, 13, 'A68', 'Gold', 1200.00),
(169, 13, 'A69', 'Gold', 1200.00),
(170, 13, 'A70', 'Gold', 1200.00),
(171, 13, 'A71', 'Gold', 1200.00),
(172, 13, 'A72', 'Gold', 1200.00),
(173, 13, 'A73', 'Gold', 1200.00),
(174, 13, 'A74', 'Gold', 1200.00),
(175, 13, 'A75', 'Gold', 1200.00),
(176, 13, 'A76', 'Gold', 1200.00),
(177, 13, 'A77', 'Gold', 1200.00),
(178, 13, 'A78', 'Gold', 1200.00),
(179, 13, 'A79', 'Gold', 1200.00),
(180, 13, 'A80', 'Gold', 1200.00),
(181, 13, 'A81', 'Gold', 1200.00),
(182, 13, 'A82', 'Gold', 1200.00),
(183, 13, 'A83', 'Gold', 1200.00),
(184, 13, 'A84', 'Gold', 1200.00),
(185, 13, 'A85', 'Gold', 1200.00),
(186, 13, 'A86', 'Gold', 1200.00),
(187, 13, 'A87', 'Gold', 1200.00),
(188, 13, 'A88', 'Gold', 1200.00),
(189, 13, 'A89', 'Gold', 1200.00),
(190, 13, 'A90', 'Gold', 1200.00),
(191, 13, 'A91', 'Gold', 1200.00),
(192, 13, 'A92', 'Gold', 1200.00),
(193, 13, 'A93', 'Gold', 1200.00),
(194, 13, 'A94', 'Gold', 1200.00),
(195, 13, 'A95', 'Gold', 1200.00),
(196, 13, 'A96', 'Gold', 1200.00),
(197, 13, 'A97', 'Gold', 1200.00),
(198, 13, 'A98', 'Gold', 1200.00),
(199, 13, 'A99', 'Gold', 1200.00),
(200, 13, 'A100', 'Gold', 1200.00),
(201, 13, 'A101', 'Gold', 1200.00),
(202, 13, 'C1', 'Platinum', 800.00),
(203, 13, 'C2', 'Platinum', 800.00),
(204, 13, 'C3', 'Platinum', 800.00),
(205, 13, 'C4', 'Platinum', 800.00),
(206, 13, 'C5', 'Platinum', 800.00),
(207, 13, 'C6', 'Platinum', 800.00),
(208, 13, 'C7', 'Platinum', 800.00),
(209, 13, 'C8', 'Platinum', 800.00),
(210, 13, 'C9', 'Platinum', 800.00),
(211, 13, 'C10', 'Platinum', 800.00),
(212, 13, 'C11', 'Platinum', 800.00),
(213, 13, 'C12', 'Platinum', 800.00),
(214, 13, 'C13', 'Platinum', 800.00),
(215, 13, 'C14', 'Platinum', 800.00),
(216, 13, 'C15', 'Platinum', 800.00),
(217, 13, 'C16', 'Platinum', 800.00),
(218, 13, 'C17', 'Platinum', 800.00),
(219, 13, 'C18', 'Platinum', 800.00),
(220, 13, 'C19', 'Platinum', 800.00),
(221, 13, 'C20', 'Platinum', 800.00),
(222, 13, 'C21', 'Platinum', 800.00),
(223, 13, 'C22', 'Platinum', 800.00),
(224, 13, 'C23', 'Platinum', 800.00),
(225, 13, 'C24', 'Platinum', 800.00),
(226, 13, 'C25', 'Platinum', 800.00),
(227, 13, 'C26', 'Platinum', 800.00),
(228, 13, 'C27', 'Platinum', 800.00),
(229, 13, 'C28', 'Platinum', 800.00),
(230, 13, 'C29', 'Platinum', 800.00),
(231, 13, 'C30', 'Platinum', 800.00),
(232, 13, 'C31', 'Platinum', 800.00),
(233, 13, 'C32', 'Platinum', 800.00),
(234, 13, 'C33', 'Platinum', 800.00),
(235, 13, 'C34', 'Platinum', 800.00),
(236, 13, 'C35', 'Platinum', 800.00),
(237, 13, 'C36', 'Platinum', 800.00),
(238, 13, 'C37', 'Platinum', 800.00),
(239, 13, 'C38', 'Platinum', 800.00),
(240, 13, 'C39', 'Platinum', 800.00),
(241, 13, 'C40', 'Platinum', 800.00),
(242, 13, 'C41', 'Platinum', 800.00),
(243, 13, 'C42', 'Platinum', 800.00),
(244, 13, 'C43', 'Platinum', 800.00),
(245, 13, 'C44', 'Platinum', 800.00),
(246, 13, 'C45', 'Platinum', 800.00),
(247, 13, 'C46', 'Platinum', 800.00),
(248, 13, 'C47', 'Platinum', 800.00),
(249, 13, 'C48', 'Platinum', 800.00),
(250, 13, 'C49', 'Platinum', 800.00),
(251, 13, 'C50', 'Platinum', 800.00),
(252, 13, 'C51', 'Platinum', 800.00),
(253, 13, 'C52', 'Platinum', 800.00),
(254, 13, 'C53', 'Platinum', 800.00),
(255, 13, 'C54', 'Platinum', 800.00),
(256, 13, 'C55', 'Platinum', 800.00),
(257, 13, 'C56', 'Platinum', 800.00),
(258, 13, 'C57', 'Platinum', 800.00),
(259, 13, 'C58', 'Platinum', 800.00),
(260, 13, 'C59', 'Platinum', 800.00),
(261, 13, 'C60', 'Platinum', 800.00),
(262, 13, 'C61', 'Platinum', 800.00),
(263, 13, 'C62', 'Platinum', 800.00),
(264, 13, 'C63', 'Platinum', 800.00),
(265, 13, 'C64', 'Platinum', 800.00),
(266, 13, 'C65', 'Platinum', 800.00),
(267, 13, 'C66', 'Platinum', 800.00),
(268, 13, 'C67', 'Platinum', 800.00),
(269, 13, 'C68', 'Platinum', 800.00),
(270, 13, 'C69', 'Platinum', 800.00),
(271, 13, 'C70', 'Platinum', 800.00),
(272, 13, 'C71', 'Platinum', 800.00),
(273, 13, 'C72', 'Platinum', 800.00),
(274, 13, 'C73', 'Platinum', 800.00),
(275, 13, 'C74', 'Platinum', 800.00),
(276, 13, 'C75', 'Platinum', 800.00),
(277, 13, 'C76', 'Platinum', 800.00),
(278, 13, 'C77', 'Platinum', 800.00),
(279, 13, 'C78', 'Platinum', 800.00),
(280, 13, 'C79', 'Platinum', 800.00),
(281, 13, 'C80', 'Platinum', 800.00),
(282, 13, 'C81', 'Platinum', 800.00),
(283, 13, 'C82', 'Platinum', 800.00),
(284, 13, 'C83', 'Platinum', 800.00),
(285, 13, 'C84', 'Platinum', 800.00),
(286, 13, 'C85', 'Platinum', 800.00),
(287, 13, 'C86', 'Platinum', 800.00),
(288, 13, 'C87', 'Platinum', 800.00),
(289, 13, 'C88', 'Platinum', 800.00),
(290, 13, 'C89', 'Platinum', 800.00),
(291, 13, 'C90', 'Platinum', 800.00),
(292, 13, 'C91', 'Platinum', 800.00),
(293, 13, 'C92', 'Platinum', 800.00),
(294, 13, 'C93', 'Platinum', 800.00),
(295, 13, 'C94', 'Platinum', 800.00),
(296, 13, 'C95', 'Platinum', 800.00),
(297, 13, 'C96', 'Platinum', 800.00),
(298, 13, 'C97', 'Platinum', 800.00),
(299, 13, 'C98', 'Platinum', 800.00),
(300, 13, 'C99', 'Platinum', 800.00),
(301, 13, 'C100', 'Platinum', 800.00),
(302, 13, 'C101', 'Platinum', 800.00),
(303, 13, 'g5', 'Platinum', 250.00),
(304, 13, 'g1', 'Box', 1500.00),
(305, 13, 'g2', 'Box', 1500.00),
(306, 13, 'g3', 'Box', 1500.00),
(307, 13, 'g4', 'Box', 1500.00),
(308, 13, 'g5', 'Box', 1500.00),
(309, 13, 'g6', 'Box', 1500.00),
(310, 13, 'g7', 'Box', 1500.00),
(311, 13, 'g8', 'Box', 1500.00),
(312, 13, 'g9', 'Box', 1500.00),
(313, 13, 'g10', 'Box', 1500.00),
(314, 13, 'g11', 'Box', 1500.00),
(315, 13, 'g12', 'Box', 1500.00),
(316, 13, 'g13', 'Box', 1500.00),
(317, 13, 'g14', 'Box', 1500.00),
(318, 13, 'g15', 'Box', 1500.00),
(319, 13, 'g16', 'Box', 1500.00),
(320, 13, 'g17', 'Box', 1500.00),
(321, 13, 'g18', 'Box', 1500.00),
(322, 13, 'g19', 'Box', 1500.00),
(323, 13, 'g20', 'Box', 1500.00),
(324, 13, 'F1', 'Platinum', 1500.00),
(325, 13, 'F2', 'Platinum', 1500.00),
(326, 13, 'F3', 'Platinum', 1500.00),
(327, 13, 'F4', 'Platinum', 1500.00),
(328, 13, 'F5', 'Platinum', 1500.00),
(329, 13, 'F6', 'Platinum', 1500.00),
(330, 13, 'F7', 'Platinum', 1500.00),
(331, 13, 'F8', 'Platinum', 1500.00),
(332, 13, 'F9', 'Platinum', 1500.00),
(333, 13, 'F10', 'Platinum', 1500.00),
(334, 13, 'F11', 'Platinum', 1500.00),
(335, 13, 'F12', 'Platinum', 1500.00),
(336, 13, 'F13', 'Platinum', 1500.00),
(337, 13, 'F14', 'Platinum', 1500.00),
(338, 13, 'F15', 'Platinum', 1500.00),
(339, 13, 'F16', 'Platinum', 1500.00),
(340, 13, 'F17', 'Platinum', 1500.00),
(341, 13, 'F18', 'Platinum', 1500.00),
(342, 13, 'F19', 'Platinum', 1500.00),
(343, 13, 'F20', 'Platinum', 1500.00),
(344, 13, 'F21', 'Platinum', 1500.00),
(345, 13, 'F22', 'Platinum', 1500.00),
(346, 13, 'F23', 'Platinum', 1500.00),
(347, 13, 'F24', 'Platinum', 1500.00),
(348, 13, 'F25', 'Platinum', 1500.00),
(349, 13, 'F26', 'Platinum', 1500.00),
(350, 13, 'F27', 'Platinum', 1500.00),
(351, 13, 'F28', 'Platinum', 1500.00),
(352, 13, 'F29', 'Platinum', 1500.00),
(353, 13, 'F30', 'Platinum', 1500.00),
(354, 13, 'F31', 'Platinum', 1500.00),
(355, 13, 'F32', 'Platinum', 1500.00),
(356, 13, 'F33', 'Platinum', 1500.00),
(357, 13, 'F34', 'Platinum', 1500.00),
(358, 13, 'F35', 'Platinum', 1500.00),
(359, 13, 'F36', 'Platinum', 1500.00),
(360, 13, 'F37', 'Platinum', 1500.00),
(361, 13, 'F38', 'Platinum', 1500.00),
(362, 13, 'F39', 'Platinum', 1500.00),
(363, 13, 'F40', 'Platinum', 1500.00),
(364, 13, 'F41', 'Platinum', 1500.00),
(365, 13, 'F42', 'Platinum', 1500.00),
(366, 13, 'F43', 'Platinum', 1500.00),
(367, 13, 'F44', 'Platinum', 1500.00),
(368, 13, 'F45', 'Platinum', 1500.00),
(369, 13, 'F46', 'Platinum', 1500.00),
(370, 13, 'F47', 'Platinum', 1500.00),
(371, 13, 'F48', 'Platinum', 1500.00),
(372, 13, 'F49', 'Platinum', 1500.00),
(373, 13, 'F50', 'Platinum', 1500.00),
(374, 13, 'F51', 'Platinum', 1500.00),
(375, 13, 'F52', 'Platinum', 1500.00),
(376, 13, 'F53', 'Platinum', 1500.00),
(377, 13, 'F54', 'Platinum', 1500.00),
(378, 13, 'F55', 'Platinum', 1500.00),
(379, 13, 'F56', 'Platinum', 1500.00),
(380, 13, 'F57', 'Platinum', 1500.00),
(381, 13, 'F58', 'Platinum', 1500.00),
(382, 13, 'F59', 'Platinum', 1500.00),
(383, 13, 'F60', 'Platinum', 1500.00),
(384, 13, 'F61', 'Platinum', 1500.00),
(385, 13, 'F62', 'Platinum', 1500.00),
(386, 13, 'F63', 'Platinum', 1500.00),
(387, 13, 'F64', 'Platinum', 1500.00),
(388, 13, 'F65', 'Platinum', 1500.00),
(389, 13, 'F66', 'Platinum', 1500.00),
(390, 13, 'F67', 'Platinum', 1500.00),
(391, 13, 'F68', 'Platinum', 1500.00),
(392, 13, 'F69', 'Platinum', 1500.00),
(393, 13, 'F70', 'Platinum', 1500.00),
(394, 13, 'F71', 'Platinum', 1500.00),
(395, 13, 'F72', 'Platinum', 1500.00),
(396, 13, 'F73', 'Platinum', 1500.00),
(397, 13, 'F74', 'Platinum', 1500.00),
(398, 13, 'F75', 'Platinum', 1500.00),
(399, 13, 'F76', 'Platinum', 1500.00),
(400, 13, 'F77', 'Platinum', 1500.00),
(401, 13, 'F78', 'Platinum', 1500.00),
(402, 13, 'F79', 'Platinum', 1500.00),
(403, 13, 'F80', 'Platinum', 1500.00),
(404, 13, 'F81', 'Platinum', 1500.00),
(405, 13, 'F82', 'Platinum', 1500.00),
(406, 13, 'F83', 'Platinum', 1500.00),
(407, 13, 'F84', 'Platinum', 1500.00),
(408, 13, 'F85', 'Platinum', 1500.00),
(409, 13, 'F86', 'Platinum', 1500.00),
(410, 13, 'F87', 'Platinum', 1500.00),
(411, 13, 'F88', 'Platinum', 1500.00),
(412, 13, 'F89', 'Platinum', 1500.00),
(413, 13, 'F90', 'Platinum', 1500.00),
(414, 13, 'F91', 'Platinum', 1500.00),
(415, 13, 'F92', 'Platinum', 1500.00),
(416, 13, 'F93', 'Platinum', 1500.00),
(417, 13, 'F94', 'Platinum', 1500.00),
(418, 13, 'F95', 'Platinum', 1500.00),
(419, 13, 'F96', 'Platinum', 1500.00),
(420, 13, 'F97', 'Platinum', 1500.00),
(421, 13, 'F98', 'Platinum', 1500.00),
(422, 13, 'F99', 'Platinum', 1500.00),
(423, 13, 'F100', 'Platinum', 1500.00),
(424, 13, 'F101', 'Platinum', 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `theatre_id` int(11) DEFAULT NULL,
  `screen_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `movie_id`, `theatre_id`, `screen_id`, `show_date`, `show_time`) VALUES
(9, 12, 6, 13, '2026-02-24', '13:21:00'),
(10, 14, 7, 13, '2026-03-04', '14:45:00'),
(11, 16, 6, 17, '2026-03-13', '11:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `theatres`
--

CREATE TABLE `theatres` (
  `theatre_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theatres`
--

INSERT INTO `theatres` (`theatre_id`, `name`, `city`, `address`, `status`) VALUES
(6, 'nupielex', 'Gujranwala', 'north, nazimabad', 'active'),
(7, 'nupielex', 'Rawalpindi', 'nazimabad karachii', 'active'),
(8, 'nupielex', 'Hyderabad', 'mmmmmmm, hyderabad', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('valid','used','cancelled') DEFAULT 'valid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `booking_id`, `ticket_number`, `issued_at`, `status`) VALUES
(9, 11, 'VIP-889568', '2026-02-19 16:20:19', 'valid'),
(10, 12, 'VIP-591858', '2026-02-19 16:29:55', 'valid'),
(11, 13, 'VIP-530356', '2026-02-19 16:30:12', 'valid'),
(12, 14, 'VIP-537708', '2026-02-19 16:31:05', 'valid'),
(13, 15, 'VIP-486808', '2026-02-19 16:31:47', 'valid'),
(14, 16, 'VIP-202952', '2026-02-19 16:32:37', 'valid'),
(27, 5, 'VIP-790196', '2026-02-24 18:18:55', 'valid'),
(28, 9, 'VIP-949010', '2026-02-24 18:24:21', 'valid'),
(29, 10, 'VIP-493084', '2026-02-24 18:41:31', 'valid'),
(30, 11, 'VIP-211909', '2026-02-26 06:27:52', 'valid'),
(31, 12, 'VIP-812384', '2026-02-26 07:13:46', 'valid'),
(32, 13, 'VIP-302543', '2026-02-26 09:46:32', 'valid'),
(33, 14, 'VIP-326622', '2026-02-26 18:41:31', 'valid'),
(34, 15, 'VIP-756615', '2026-02-26 18:46:29', 'valid'),
(35, 16, 'VIP-502705', '2026-02-26 18:49:41', 'valid'),
(40, 5, 'VIP-321980', '2026-02-26 19:13:39', 'valid'),
(41, 6, 'VIP-236843', '2026-02-26 19:13:41', 'valid'),
(42, 7, 'VIP-756180', '2026-02-26 19:13:57', 'valid'),
(43, 8, 'VIP-173167', '2026-02-26 20:29:18', 'valid'),
(44, 9, 'VIP-648606', '2026-02-28 17:38:03', 'valid'),
(45, 10, 'VIP-906561', '2026-02-28 17:46:50', 'valid'),
(46, 11, 'VIP-723729', '2026-02-28 17:48:09', 'valid'),
(47, 12, 'VIP-114798', '2026-02-28 18:16:00', 'valid'),
(48, 13, 'VIP-681336', '2026-02-28 18:37:12', 'valid'),
(49, 14, 'VIP-878802', '2026-02-28 18:56:37', 'valid'),
(50, 15, 'VIP-400223', '2026-02-28 18:57:58', 'valid'),
(51, 16, 'VIP-536195', '2026-03-01 09:56:08', 'valid');

-- --------------------------------------------------------

--
-- Table structure for table `trailers`
--

CREATE TABLE `trailers` (
  `trailer_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `trailer_title` varchar(150) DEFAULT NULL,
  `trailer_url` varchar(255) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trailers`
--

INSERT INTO `trailers` (`trailer_id`, `movie_id`, `trailer_title`, `trailer_url`, `duration`, `thumbnail`, `created_at`) VALUES
(1, 29, 'The legend Official Trailer', 'https://www.youtube.com/watch?v=yI3v6KfR9Mw&pp=ygUYdGhlIGxlZ2VuZCBtb3ZpZSB0cmFpbGVy', NULL, NULL, '2026-02-26 07:11:53'),
(2, 27, 'MALEFICIENT Official Trailer', 'https://youtu.be/IuY4-6qWm-8?si=uz39n4tx23AQLWZa', NULL, NULL, '2026-02-26 19:43:32'),
(3, 21, 'AQUAMAN Official Trailer', 'https://youtu.be/WVHlrfzLjd4?si=MazIruBkAgPEYkdy', NULL, NULL, '2026-02-26 20:00:08'),
(4, 24, 'SPIDERMAN Official Trailer', 'https://youtu.be/e5wUilOeOmg?si=EX2UcysvyBWAIe2n', NULL, NULL, '2026-02-26 20:00:45'),
(5, 18, 'SINISTER Official Trailer', 'https://youtu.be/_kbQAJR9YWQ?si=A5p6Faxoq50GI2ii', NULL, NULL, '2026-02-26 20:01:05'),
(6, 19, 'CURSE OF NUN Official Trailer', 'https://youtu.be/_bI1hJafWUI?si=CTpEjOMHOnVVMnMo', NULL, NULL, '2026-02-26 20:01:44'),
(7, 23, 'BEAUTY AND THE BEAST Official Trailer', 'https://youtu.be/pnkgw6pAKkM?si=UA0xQjXOivQbrUdN', NULL, NULL, '2026-02-26 20:02:09'),
(8, 16, 'JOKER Official Trailer', 'https://youtu.be/zAGVQLHvwOY?si=Cllxco2pLU0RowMB', NULL, NULL, '2026-02-26 20:02:41'),
(9, 14, 'BATMAN Official Trailer', 'https://youtu.be/mqqft2x_Aa4?si=ht7TuULiYdI-u5m_', NULL, NULL, '2026-02-26 20:03:16'),
(10, 12, 'ALADDIN Official Trailer', 'https://youtu.be/-G5XI61Y9ms?si=3WYz2waiXvmFawHl', NULL, NULL, '2026-02-26 20:04:09'),
(11, 22, 'JOHNNY ENGLISH Official Trailer', 'https://youtu.be/bbi0A2EUQUs?si=cFQf3YD9rbq8zOmx', NULL, NULL, '2026-02-26 20:05:32'),
(12, 13, 'IRON MAN Official Trailer', 'https://youtu.be/KAE5ymVLmZg?si=pr-J1SrG2J4kFKXy', NULL, NULL, '2026-02-26 20:06:16'),
(13, 15, 'AVENGERS Official Trailer', 'https://youtu.be/eOrNdBpGMv8?si=am--adSFmQxS3tU2', NULL, NULL, '2026-02-26 20:07:01'),
(14, 20, 'TWILIGHT Official Trailer', 'https://youtu.be/uxjNDE2fMjI?si=s54_nAO1Ta1zGujY', NULL, NULL, '2026-02-26 20:07:39'),
(15, 25, 'X-MEN THE LAST STAND Official Trailer', 'https://youtu.be/ZQ0v5dXbw7M?si=e844PPBhM8BUtnN3', NULL, NULL, '2026-02-26 20:09:50'),
(16, 17, 'HARRY POTTER Official Trailer', 'https://youtu.be/VyHV0BRtdxo?si=14XwjxXPpW-SaXGU', NULL, NULL, '2026-02-26 20:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `role`, `created_at`, `profile_pic`) VALUES
(12, 'alishba', 'alishba@gmail.com', '$2y$10$/bH6ceqOD5KPM0lYEbsUJ.Nkswpz4eGr2PEEt6Tk7w0s0xtRXTary', '', 'customer', '2026-02-24 05:39:21', NULL),
(13, 'Mujtaba', 'mujtaba@gmail.com', '$2y$10$KbhPgprFd.DG3hZNvTcRPOXrbwLL2mwz38YODchgvzLxi4.qsKoMy', '123654789', 'customer', '2026-02-24 05:49:39', '1772126610_13.png'),
(14, 'momina', 'momina@gmail.com', '$2y$10$o40S.adoNoyUSnvCPTvSYOtDtSzHtHYpqfpMD/lrPTyQZ9rcqrgo6', '3262339871', 'customer', '2026-02-24 06:18:24', '1772304068_14.jpeg'),
(15, 'aisha', 'aisha@gmail.com', '$2y$10$fTAh2q7nNufAqbRTyaykWOL03HSNWWY8epUZuUv3IdGE3TcsO8wzK', '', 'customer', '2026-02-24 07:00:22', NULL),
(16, 'admin', 'admin@gmail.com', '$2y$10$C/RfG./LTSD4wupu9p7QxOw3KDB3JoY47kVCFDcCAaZUmq61mEZzO', '', 'customer', '2026-02-26 07:32:16', NULL),
(17, 'joe', 'adminjoe@gmail.com', '$2y$10$2Kj49dluh8yQERztQjryNukG1bLWTqR69pIyLZqnn7FlcTqhQcQEm', '0123654789', 'admin', '2026-02-26 18:33:37', '1772133943_17.png'),
(18, 'joe', 'joe@gmail.com', '$2y$10$AmNrATU7MRYbXjivtLi5buJ4Zv4wTugdlucQoGhjz1Jha6uD4YhQe', '', 'customer', '2026-02-27 05:02:33', NULL),
(19, 'amna', 'amna@gmail.com', '$2y$10$NGqFr9pRm2cmA7U3bMSW2.axeDNYGzwT4rR8BeaBOlUra3jTeew3.', '', 'customer', '2026-03-01 11:28:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Indexes for table `confirm_booking`
--
ALTER TABLE `confirm_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`screen_id`),
  ADD KEY `theatre_id` (`theatre_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `theatres`
--
ALTER TABLE `theatres`
  ADD PRIMARY KEY (`theatre_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `trailers`
--
ALTER TABLE `trailers`
  ADD PRIMARY KEY (`trailer_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `booking_seats`
--
ALTER TABLE `booking_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `confirm_booking`
--
ALTER TABLE `confirm_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `screens`
--
ALTER TABLE `screens`
  MODIFY `screen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `theatres`
--
ALTER TABLE `theatres`
  MODIFY `theatre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `trailers`
--
ALTER TABLE `trailers`
  MODIFY `trailer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`);

--
-- Constraints for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD CONSTRAINT `booking_seats_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_seats_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`);

--
-- Constraints for table `screens`
--
ALTER TABLE `screens`
  ADD CONSTRAINT `screens_ibfk_1` FOREIGN KEY (`theatre_id`) REFERENCES `theatres` (`theatre_id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`screen_id`) ON DELETE CASCADE;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shows_ibfk_2` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`screen_id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `trailers`
--
ALTER TABLE `trailers`
  ADD CONSTRAINT `trailers_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
