-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ubiz
CREATE DATABASE IF NOT EXISTS `tkp` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `tkp`;

-- Dumping structure for table ubiz.customer
DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `cus_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cus_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `cus_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_type` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_phone` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_fax` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_flg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inp_user` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) NOT NULL,
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ubiz.customer: ~0 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table ubiz.customer_address
DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE IF NOT EXISTS `customer_address` (
  `cad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cus_id` int(11) NOT NULL,
  `cad_address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_flg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inp_user` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) NOT NULL,
  PRIMARY KEY (`cad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ubiz.customer_address: ~0 rows (approximately)
/*!40000 ALTER TABLE `customer_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_address` ENABLE KEYS */;

-- Dumping structure for table ubiz.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ubiz.migrations: ~7 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2018_07_02_000000_create_users_table', 1),
	(2, '2018_07_02_100000_create_password_resets_table', 1),
	(3, '2018_07_02_200000_create_m_department_table', 1),
	(4, '2018_07_02_300000_create_m_permission_table', 1),
	(5, '2018_07_02_400000_create_customer_table', 1),
	(6, '2018_07_02_500000_create_customer_address_table', 1),
	(7, '2018_07_02_600000_create_m_currency_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_company
DROP TABLE IF EXISTS `m_company`;
CREATE TABLE IF NOT EXISTS `m_company` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_nm` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_logo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_address` text COLLATE utf8_unicode_ci,
  `com_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_fax` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_web` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_hotline` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_mst` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inp_user` bigint(20) DEFAULT NULL,
  `upd_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_company: ~2 rows (approximately)
/*!40000 ALTER TABLE `m_company` DISABLE KEYS */;
INSERT INTO `m_company` (`com_id`, `com_nm`, `com_logo`, `com_address`, `com_phone`, `com_fax`, `com_web`, `com_email`, `com_hotline`, `com_mst`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 'CÔNG TY TNHH KỸ THUẬT THƯƠNG MẠI THÁI KHƯƠNG', 'logo-1.png', '38A Phan Văn Sửu, Phường 13, Q. Tân Bình, TP. HCM, Việt Nam', '(+84) 28 3813 4728/ 29', '(+84) 28 3813 4727', 'www.thaikhuongpump.com', 'info@thaikhuongpump.com', '(+84) 941 400 488', '0304844502', '0', '2018-12-18 18:10:28', NULL, '2018-12-18 18:10:28', NULL),
	(2, 'CÔNG TY TNHH DỊCH VỤ THƯƠNG MẠI XÂY DỰNG HỮU TÀI', 'logo-2.png', '62 Phan Văn Sửu, Phường 15, Tân Bình, Hồ Chí Minh\r\n', '(+84) 2838 102 853 - (+84) 2838 125 913\r\n\r\n', '(+84) 28 38120364\r\n\r\n', 'www.huutai.vn/', 'huutai@huutai.vn', '0949 040474', NULL, '0', '2018-12-18 15:38:22', NULL, '2018-12-18 15:38:22', NULL);
/*!40000 ALTER TABLE `m_company` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_currency
DROP TABLE IF EXISTS `m_currency`;
CREATE TABLE IF NOT EXISTS `m_currency` (
  `cur_id` int(11) NOT NULL,
  `cur_ctr_nm` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_ctr_cd_alpha_2` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_ctr_cd_alpha_3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_ctr_cd_numeric` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_nm` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_cd_numeric_default` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_cd_alpha` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_cd_numeric` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_minor_units` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cur_symbol` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '1',
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_currency: ~248 rows (approximately)
/*!40000 ALTER TABLE `m_currency` DISABLE KEYS */;
INSERT INTO `m_currency` (`cur_id`, `cur_ctr_nm`, `cur_ctr_cd_alpha_2`, `cur_ctr_cd_alpha_3`, `cur_ctr_cd_numeric`, `cur_nm`, `cur_cd_numeric_default`, `cur_cd_alpha`, `cur_cd_numeric`, `cur_minor_units`, `cur_symbol`, `active_flg`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 'Afghanistan', 'af', 'AFG', '004', 'Afghanii', '971', 'AFN', '971', '2', '؋', '1', '0', '2018-12-02 18:12:22', 1, '2018-12-02 18:12:22', 1),
	(2, 'Albania', 'al', 'ALB', '008', 'Lek', '008', 'ALL', '008', '2', 'Lek', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(3, 'Algeria', 'dz', 'DZA', '012', 'Algerian Dinar', '012', 'DZD', '012', '2', 'دج', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(4, 'American Samoa', 'as', 'ASM', '016', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(5, 'Andorra', 'ad', 'AND', '022', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-12-03 18:37:37', 1, '2018-12-03 18:37:37', 1),
	(6, 'Angola', 'ao', 'AGO', '024', 'Kwanza', '973', 'AOA', '973', '2', 'Kz', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(7, 'Anguilla', 'ai', 'AIA', '660', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(8, 'Antigua and Barbuda', 'ag', 'ATG', '028', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(9, 'Argentina', 'ar', 'ARG', '032', 'Argentine Peso', '032', 'ARS', '032', '2', '$', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(10, 'Armenia', 'am', 'ARM', '051', 'Armenian Dram', '051', 'AMD', '051', '2', 'դր.', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(11, 'Aruba', 'aw', 'ABW', '533', 'Aruban Guilder', '533', 'AWG', '533', '2', NULL, '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(12, 'Australia', 'au', 'AUS', '036', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(13, 'Austria', 'at', 'AUT', '040', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:25', 1, '2018-11-30 14:28:25', 1),
	(14, 'Azerbaijan', 'az', 'AZE', '031', 'Azerbaijan Manat', '944', 'AZN', '944', '2', '₼', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(15, 'BAhamas', 'bs', 'BHS', '044', 'Bahamian Dollar', '044', 'BSD', '044', '2', '$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(16, 'Bahrain', 'bh', 'BHR', '048', 'Bahraini Dinar', '048', 'BHD', '048', '2', '.د.ب', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(17, 'Bangladesh', 'bd', 'BGD', '050', 'Taka', '050', 'BDT', '050', '2', '৳', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(18, 'Barbados', 'bb', 'BRB', '052', 'Barbados Dollar', '052', 'BBD', '052', '2', '$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(19, 'Belarus', 'by', 'BLR', '112', 'Belarusian Ruble', '974', 'BYR', '974', '0', 'Br', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(20, 'Belgium', 'be', 'BEL', '056', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(21, 'Belize', 'bz', 'BLZ', '084', 'Belize Dollar', '084', 'BZD', '084', '2', 'BZ$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(22, 'Benin', 'bj', 'BEN', '204', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(23, 'Bermuda', 'bm', 'BMU', '060', 'Bermudian Dollar', '060', 'BMD', '060', '2', NULL, '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(24, 'India', 'in', 'IND', '064', 'Indian Rupee', '064', 'INR', '064', '2', '₹', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(25, 'Bhutan', 'bt', 'BTN', '356', 'Bhutan', '356', 'BTN', '356', '2', 'Nu.', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(26, 'Bolivia', 'bo', 'BOL', '068', 'Boliviano', '068', 'BOB', '068', '2', '$b', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(27, 'Bonaire', 'bq', 'BES', '535', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(28, 'Bosnia and Herzegovina', 'ba', 'BIH', '070', 'Convertible Mark', '977', 'BAM', '977', '2', 'KM', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(29, 'Botswana', 'bw', 'BWA', '072', 'Pula', '072', 'BWP', '072', '2', 'P', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(30, 'Bouvet Is.', 'bv', 'BVT', '074', 'Norwegian Krone', '578', 'NOK', '578', '2', 'kr', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(31, 'Brazil', 'br', 'BRA', '076', 'Brazilian Real', '076', 'BRL', '986', '2', 'R$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(32, 'British Indian Ocean Territory', 'io', 'IOT', '086', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(33, 'British Virgin Is.', 'vg', 'VGB', '092', 'US Dollar', 'X840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:26', 1, '2018-11-30 14:28:26', 1),
	(34, 'Brunei Darussalam', 'bn', 'BRN', '096', 'Brunei Dollar', '096', 'BND', '096', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(35, 'Bulgaria', 'bg', 'BGR', '100', 'Bulgarian Lev', '975', 'BGN', '975', '2', 'лв', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(36, 'Burkina Faso', 'bf', 'BFA', '854', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(37, 'Burundi', 'bi', 'BDI', '108', 'Burundi Franc', '108', 'BIF', '108', '0', 'FBu', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(38, 'Cambodia', 'kh', 'KHM', '116', 'Riel', '116', 'KHR', '116', '2', '៛', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(39, 'Cameroon, United Republic of', 'cm', 'CMR', '120', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(40, 'Canada', 'ca', 'CAN', '124', 'Canadian Dollar', '124', 'CAD', '124', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(41, 'Cayman Is.', 'ky', 'CYM', '136', 'Cayman Is. Dollar', '136', 'KYD', '136', '2', NULL, '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(42, 'Central African Republic', 'cf', 'CAF', '140', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(43, 'Chad', 'td', 'TCD', '148', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(44, 'Chile', 'cl', 'TCD', '152', 'Chilean Peso', '152', 'CLP', '152', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(45, 'China', 'cn', 'CHN', '156', 'Yuan Renminbi', '156', 'CNY', '156', '2', '¥', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(46, 'Christmas Is.', 'cx', 'CXR', '162', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(47, 'Cocos (Keeling) Is.', 'cc', 'CCK', '166', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(48, 'Colombia', 'co', 'COL', '170', 'Colombian Peso', '170', 'COP', '170', '2', '$', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(49, 'Comoros', 'km', 'COM', '174', 'Comoro Franc', '174', 'KMF', '174', '0', 'CF', '1', '0', '2018-11-30 14:28:27', 1, '2018-11-30 14:28:27', 1),
	(50, 'Congo', 'cg', 'COG', '178', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(51, 'Cook Is.', 'ck', 'COK', '184', 'New Zealand Dollar', '554', 'NZD', '554', '2', '$', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(52, 'Costa Rica', 'cr', 'CRI', '188', 'Costa Rican Colon', '188', 'CRC', '188', '2', '₡', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(53, 'Cote d\'Ivoire (Ivory Coast)', 'ci', 'CIV', '384', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(54, 'Croatia', 'hr', 'HRV', '191', 'Croatian Kuna', '191', 'HRK', '191', '2', 'kn', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(55, 'Cuba', 'cu', 'CUW', '192', 'Cuban Peso', '192', 'CUP', '192', '2', NULL, '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(56, 'Curacao', 'cw', 'CUW', '531', 'Netherlands Antillean Guilder', '532', 'ANG', '532', '2', NULL, '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(57, 'Cyprus', 'cy', 'CYP', '196', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(58, 'Czech Republic', 'cz', 'CZE', '203', 'Czech Koruna', '203', 'CZK', '203', '2', 'Kč', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(59, 'Democratic Republic of the Congo', 'cd', 'COD', '180', 'Franc Congolais', '976', 'CDF', '976', '2', 'FC', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(60, 'Denmark', 'dk', 'DNK', '208', 'Danish Krone', '208', 'DKK', '208', '2', 'kr.', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(61, 'Djibouti', 'dj', 'DJI', '262', 'Djibouti Franc', '262', 'DJF', '262', '0', 'Fdj', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(62, 'Dominica', 'dm', 'DMA', '212', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(63, 'Dominican Rep.', 'do', 'DOM', '214', 'Dominican Peso', '214', 'DOP', '214', '2', 'RD$', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(64, 'Ecuador', 'ec', 'ECU', '218', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(65, 'Egypt', 'eg', 'EGY', '818', 'Egyptian Pound', '818', 'EGP', '818', '2', '£', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(66, 'El Salvador', 'sv', 'SLV', '222', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(67, 'Equatorial Guinea', 'gq', 'GNQ', '226', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:28', 1, '2018-11-30 14:28:28', 1),
	(68, 'Eritrea', 'er', 'ERI', '232', 'Eritrean Nakfa', '232', 'ERN', '232', '2', 'ናቕፋ', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(69, 'Estonia', 'ee', 'EST', '233', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(70, 'Ethiopia', 'et', 'ETH', '231', 'Ethiopian Birr', '230', 'ETB', '230', '2', 'ብር', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(71, 'European Union', '', '', '', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(72, 'Faroe Is.', 'fo', 'FRO', '234', 'Danish Krone', '208', 'DKK', '208', '2', 'kr.', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(73, 'Falkland Is. (Malvinas)', 'fk', 'FLK', '238', 'Falkland Is. Pound', '238', 'FKP', '238', '2', NULL, '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(74, 'Fiji', 'fj', 'FJI', '242', 'Fiji Dollar', '242', 'FJD', '242', '2', '$', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(75, 'Finland', 'fi', 'FIN', '246', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(76, 'France', 'fr', 'FRA', '250', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(77, 'France, Metropolitan', 'fx', 'FXX', '249', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(78, 'French Guiana', 'gf', 'GUF', '254', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(79, 'French Polynesia', 'pf', 'PYF', '258', 'CFP Franc', '953', 'XPF', '953', '0', NULL, '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(80, 'French Southern Territory', 'tf', 'ATF', '260', 'Euro', '978', 'Euro', '978', '2', NULL, '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(81, 'Gabon', 'ga', 'GAB', '266', 'CFA Franc BEAC', '950', 'XAF', '950', '0', 'FCFA', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(82, 'Gambia', 'ga', 'GAB', '266', 'Dalasi', '270', 'GMD', '270', '2', 'D', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(83, 'Georgia', 'ge', 'GEO', '268', 'Lari', '981', 'GEL', '981', '2', 'ლ', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(84, 'Germany', 'de', 'DEU', '276', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:29', 1, '2018-11-30 14:28:29', 1),
	(85, 'Ghana', 'gh', 'GHA', '288', 'Cedi', '936', 'GHS', '936', '2', NULL, '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(86, 'Gibraltar', 'gi', 'GIB', '292', 'Gibraltar Pound', '292', 'GIP', '292', '2', NULL, '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(87, 'Greece', 'gr', 'GRC', '300', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(88, 'Greenland', 'gl', 'GRL', '304', 'Danish Krone', '208', 'DKK', '208', '2', 'kr.', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(89, 'Grenada', 'gd', 'GRD', '308', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(90, 'Guadeloupe', 'gp', 'GLP', '312', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(91, 'Guam', 'gu', 'GUM', '316', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(92, 'Guatemala', 'gt', 'GTM', '320', 'Quetzal', '320', 'GTQ', '320', '2', 'Q', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(93, 'Guinea', 'gn', 'GIN', '324', 'Guinea Franc', '324', 'GNF', '324', '2', 'FG', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(94, 'Guinea-Bissau', 'gw', 'GNB', '624', 'Guinea-Bissau Peso', '624', 'GWP', '624', '2', NULL, '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(95, 'Guyana', 'gy', 'GUY', '328', 'Guyana Dollar', '328', 'GYD', '328', '2', '$', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(96, 'Haiti', 'ht', 'HTI', '332', 'Gourde', '332', 'HTG', '332', '2', 'G', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(97, 'Heard and McDonald Is.', 'hm', 'HMD', '334', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(98, 'Holy See (Vatican City State)', 'va', 'VAT', '336', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(99, 'Honduras', 'hn', 'HND', '340', 'Lempira', '340', 'HNL', '340', '2', 'L', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(100, 'Hong Kong, China', 'hk', 'HKG', '344', 'Hong Kong Dollar', '344', 'HKD', '344', '2', NULL, '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(101, 'Hungary', 'hu', 'HUN', '348', 'Forint', '348', 'HUF', '348', '2', 'Ft', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(102, 'Iceland', 'is', 'ISL', '352', 'Iceland Krona', '352', 'ISK', '352', '2', 'kr', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(103, 'India', 'in', 'IND', '356', 'Indian Rupee', '356', 'INR', '356', '2', '₹', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(104, 'Indonesia', 'id', 'IDN', '360', 'Rupiah', '360', 'IDR', '360', '2', 'Rp', '1', '0', '2018-11-30 14:28:30', 1, '2018-11-30 14:28:30', 1),
	(105, 'Iran', 'ir', 'IRN', '364', 'Iranian Rial', '364', 'IRR', '364', '2', '﷼', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(106, 'Iraq', 'iq', 'IRQ', '368', 'Iraqi Dinar', '368', 'IQD', '368', '3', 'ع.د', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(107, 'Ireland, Republic of', 'ie', 'IRL', '372', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(108, 'Isreal', 'il', 'ISR', '376', 'New Israeli Shequel', '376', 'ILS', '376', '2', '₪', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(109, 'Italy', 'it', 'ITA', '380', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(110, 'Jamaica', 'jm', 'JAM', '388', 'Jamaican Dollar', '388', 'JMD', '388', '2', 'J$', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(111, 'Japan', 'jp', 'JPN', '392', 'Yen', '392', 'JPY', '392', '0', '¥', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(112, 'Jordan', 'jo', 'JOR', '400', 'Jordanian Dinar', '400', 'JOD', '400', '3', 'د.ا', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(113, 'Kazakhstan', 'kz', 'KAZ', '398', 'Tenge', '398', 'KZT', '398', '2', 'лв', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(114, 'Kenya', 'ke', 'KEN', '404', 'Kenyan Shilling', '404', 'KES', '404', '2', 'KSh,', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(115, 'Kiribati', 'ki', 'KIR', '296', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(116, 'Korea, Democratic People\'s Republic of (North Korea)', 'kp', 'PRK', '408', 'North Korean Won', '408', 'KPW', '408', '2', '₩', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(117, 'Korea, Republic of', 'kr', 'KOR', '410', 'Won', '410', 'KRW', '410', '0', '₩', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(118, 'Kuwait', 'kw', 'KWT', '414', 'Kuwaiti Dinar', '414', 'KWD', '414', '3', 'د.ك', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(119, 'Kyrgyzstan', 'kg', 'KGZ', '417', 'Som', '417', 'KGS', '417', '2', 'лв', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(120, 'Laos', 'la', 'LAO', '418', 'Kip', '418', 'LAK', '418', '2', '₭', '1', '0', '2018-11-30 14:28:31', 1, '2018-11-30 14:28:31', 1),
	(121, 'Latvia', 'lv', 'LVA', '428', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(122, 'Lebanon', 'lb', 'LBN', '422', 'Lebanese Pound', '422', 'LBP', '422', '2', '£', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(123, 'Lesotho', 'ls', 'LSO', '426', 'Lesotho Loti ', '426', 'LSL', '426', '2', 'L', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(124, 'Lesotho', 'ls', 'LSO', '426', 'Rand', '710', 'ZAR', '710', '2', 'R', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(125, 'Liberia', 'lr', 'LBR', '430', 'Liberian Dollar', '430', 'LRD', '430', '2', '$', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(126, 'Libyan Arab Jamahiriya', 'ly', 'LBY', '434', 'Libyan Dinar', '434', 'LYD', '434', '3', 'ل.د', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(127, 'Liechtenstein', 'li', 'LIE', '438', 'Swiss Franc', '756', 'CHF', '756', '2', 'CHF', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(128, 'Lithuania', 'lt', 'LTU', '440', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(129, 'Luxembourg', 'lu', 'LUX', '442', 'Euro', '978', 'Euro', '978', '2', NULL, '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(130, 'Macau, China', 'mo', 'MAC', '446', 'Pataca', '446', 'MOP', '446', '2', NULL, '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(131, 'Macedonia, the Former Yugoslav Republic of', 'mk', 'MKD', '807', 'Denar', '807', 'MKD', '807', '2', 'ден', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(132, 'Madagascar', 'mg', 'MDG', '450', 'Malagasy Ariary', '969', 'MGA', '969', '2', 'Ar', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(133, 'Malawi', 'mw', 'MWI', '454', 'Kwacha', '454', 'MWK', '454', '2', 'MK', '1', '0', '2018-11-30 14:28:32', 1, '2018-11-30 14:28:32', 1),
	(134, 'Malaysia', 'my', 'MYS', '458', 'Malaysian Ringgit', '458', 'MYR', '458', '2', 'RM', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(135, 'Maldives', 'mv', 'MDV', '462', 'Rufiyaa', '462', 'MVR', '462', '2', 'Rf', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(136, 'Mali', 'ml', 'MLI', '466', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(137, 'Malta', 'mt', 'MLT', '470', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(138, 'Marshall Islands', 'mh', 'MHL', '584', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(139, 'Martinique', 'mq', 'MTQ', '474', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(140, 'Mauritania', 'mr', 'MRT', '478', 'Ouguiya', '478', 'MRO', '478', '2', 'UM', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(141, 'Mauritius', 'mu', 'MUS', '480', 'Mauritius Rupee', '480', 'MUR', '480', '2', '₨', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(142, 'Mayotte', 'yt', 'MYT', '175', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(143, 'Mexico', 'mx', 'MEX', '484', 'Mexican Peso', '484', 'MXN', '484', '2', '$', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(144, 'Micronesia', 'fm', 'FSM', '583', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(145, 'Moldova, Republic of', 'md', 'MDA', '498', 'Moldovan Leu', '498', 'MDL', '498', '2', 'L', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(146, 'Monaco', 'mc', 'MCO', '492', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(147, 'Mongolia', 'mn', 'MNG', '496', 'Tugrik', '496', 'MNT', '496', '2', '₮', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(148, 'Montenegro', 'me', 'MNE', '499', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(149, 'Montserrat', 'ms', 'MSR', '500', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(150, 'Morocco', 'ma', 'MAr', '504', 'Moroccan Dirham', '504', 'MAD', '504', '2', 'DH', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(151, 'Mozambique', 'mz', 'MOZ', '508', 'Mozambique Metical', '943', 'MZN', '943', '2', 'MT', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(152, 'Myanmar', 'mm', 'MMR', '104', 'Kyat', '104', 'MMK', '104', '2', 'K', '1', '0', '2018-11-30 14:28:33', 1, '2018-11-30 14:28:33', 1),
	(153, 'Namibia', 'na', 'NAM', '516', 'Namibia Dollar', '516', 'NAD', '516', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(154, 'Namibia', 'na', 'NAM', '516', 'Rand', '710', 'ZAR', '710', '2', 'R', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(155, 'Nauru', 'nr', 'NRU', '520', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(156, 'Nepal', 'nr', 'NPL', '524', 'Nepalese Rupee', '524', 'NPR', '524', '2', '₨', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(157, 'Netherlands', 'nl', 'NLD', '528', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(158, 'Netherlands Antilles', 'an', 'ANT', '530', 'Netherlands Antillean Guilder', '532', 'ANG', '532', '2', NULL, '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(159, 'New Caledonia', 'nc', 'NCL', '540', 'CFP Franc', '953', 'XPF', '953', '0', NULL, '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(160, 'New Zealand', 'nz', 'NZL', '554', 'New Zealand Dollar', '554', 'NZD', '554', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(161, 'Nicaragua', 'ni', 'NIC', '558', 'Cordoba Oro', '558', 'NIO', '558', '2', 'C$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(162, 'Niger', 'ne', 'NER', '562', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(163, 'Nigeria', 'ng', 'NGA', '566', 'Naira', '566', 'NGA', '566', '2', NULL, '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(164, 'Niue', 'nu', 'NIU', '570', 'New Zealand Dollar', '554', 'NZD', '554', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(165, 'Norfolk Is.', 'nf', 'NFK', '574', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(166, 'Northern Mariana Islands', 'mp', 'MNP', '580', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(167, 'Norway', 'no', 'NOR', '578', 'Norwegian Krone', '578', 'NOK', '578', '2', 'kr', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(168, 'Oman', 'om', 'OMN', '512', 'Rial Omani', '512', 'OMR', '512', '3', '﷼', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(169, 'Pakistan', 'pk', 'PAK', '586', 'Pakistan Rupee', '586', 'PKR', '586', '2', '₨', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(170, 'Palau', 'pw', 'PLW', '585', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(171, 'Palestinian Territory, Occupied', 'ps', 'PSE', '275', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(172, 'Panama', 'pa', 'PAN', '591', 'Balboa', '590', 'PAB', '590', '2', 'B/.', '1', '0', '2018-11-30 14:28:34', 1, '2018-11-30 14:28:34', 1),
	(173, 'Papua New Guinea', 'pg', 'PNG', '598', 'Kina', '598', 'PGK', '598', '2', 'K', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(174, 'Paraguay', 'py', 'PRY', '600', 'Guarani', '600', 'PYG', '600', '0', 'Gs', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(175, 'Peru', 'pe', 'PER', '604', 'Nuevo Sol', '604', 'PEN', '604', '2', 'S/.', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(176, 'Philippines', 'ph', 'PHL', '608', 'Philippine Peso', '608', 'PHP', '608', '2', '₱', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(177, 'Pitcairn', 'pn', 'PCN', '612', 'New Zealand Dollar', '554', 'NZD', '554', '2', '$', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(178, 'Poland', 'pl', 'POL', '616', 'Zloty', '985', 'PLN', '985', '2', 'zł', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(179, 'Portugal', 'pt', 'PRT', '620', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(180, 'Puerto Rico', 'pr', 'PRI', '630', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(181, 'Qatar', 'qa', 'QAT', '634', 'Qatari Rial', '634', 'QAR', '634', '2', '﷼', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(182, 'Reunion', 're', 'REU', '638', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(183, 'Romania', 'ro', 'ROM', '642', 'Leu', '946', 'RON', '946', '2', 'lei', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(184, 'Russian Federation', 'ru', 'RUS', '643', 'Russian Ruble', '643', 'RUB', '643', '2', '₽', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(185, 'Rwanda', 'rw', 'RWA', '646', 'Rwanda Franc', '646', 'RWF', '646', '0', 'FRw', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(186, 'Samoa', 'ws', 'WSM', '882', 'Tala', '882', 'WST', '882', '2', 'WS$', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(187, 'San Marino', 'sm', 'SMR', '674', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(188, 'Sao Tome and Principe', 'st', 'STP', '678', 'Dobra', '678', 'STD', '678', '2', 'Db', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(189, 'Saudi Arabia', 'sa', 'SAU', '682', 'Saudi Riyal', '682', 'SAR', '682', '2', '﷼', '1', '0', '2018-11-30 14:28:35', 1, '2018-11-30 14:28:35', 1),
	(190, 'Senegal', 'sn', 'SEN', '686', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(191, 'Serbia, Republic of', 'rs', 'SRB', '688', 'Serbian Dinar', '941', 'RSD', '941', '2', 'Дин.', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(192, 'Seychelles', 'sc', 'SYC', '690', 'Seychelles Rupee', '690', 'SCR', '690', '2', '₨', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(193, 'Sierra Leone', 'sl', 'SLE', '694', 'Leone', '694', 'SLL', '694', '2', 'Le', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(194, 'Singapore', 'sg', 'SGP', '702', 'Singapore Dollar', '702', 'SGD', '702', '2', '$', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(195, 'Slovakia', 'sk', 'SVK', '703', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(196, 'Slovenia', 'si', 'SVN', '705', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(197, 'Solomon Is.', 'sb', 'SLB', '090', 'Solomon Is. Dollar', '090', 'SBD', '090', '2', '$', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(198, 'Somalia', 'so', 'SOM', '706', 'Somali Shilling', '706', 'SOS', '706', '2', 'S', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(199, 'South Africa', 'za', 'ZAF', '710', 'Rand', '710', 'ZAF', '710', '2', NULL, '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(200, 'So. Georgia and So. Sandwich Is.', 'gs', 'SGS', '239', 'Pound Sterling', '826', 'GBP', '826', '2', '£', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(201, 'Spain', 'es', 'ESP', '724', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(202, 'Sri Lanka', 'lk', 'LKA', '144', 'Sri Lanka Rupee', '144', 'LKR', '144', '2', '₨', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(203, 'St. Helena', 'sh', 'SHN', '654', 'St. Helena Pound', '654', 'SHP', '654', '2', NULL, '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(204, 'St. Kitts-Nevis', 'kn', 'KNA', '659', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(205, 'St. Lucia', 'lc', 'LCA', '662', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(206, 'St Maarten', 'sx', 'SXM', '534', 'Netherlands Antillean Guilder', '532', 'ANG', '532', '2', NULL, '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(207, 'St. Pierre and Miquelon', 'pm', 'SPM', '666', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(208, 'St. Vincent and The Grenadines', 'vc', 'VCT', '670', 'E. Caribbean Dollar', '951', 'XCD', '951', '2', '$', '1', '0', '2018-11-30 14:28:36', 1, '2018-11-30 14:28:36', 1),
	(209, 'Sudan', 'sd', 'SDN', '729', 'Sudanese Pound', '938', 'SDG', '938', '2', NULL, '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(210, 'South Sudan', 'ss', 'SSD', '728', 'South Sudanese Pound', '728', 'SSP', '728', '2', '£', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(211, 'Suriname', 'sr', 'SUR', '740', 'Surinam Dollar', '968', 'SRD', '968', '2', '$', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(212, 'Svalbard and Jan Mayen Is.', 'sj', 'SJM', '744', 'Norwegian Krone', '578', 'NOK', '578', '2', 'kr', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(213, 'Swaziland', 'sz', 'SWZ', '748', 'Lilangeni', '748', 'SZL', '748', '2', 'E', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(214, 'Sweden', 'se', 'SWE', '752', 'Swedish Krona', '752', 'SEK', '752', '2', 'kr', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(215, 'Switzerland', 'ch', 'CHE', '756', 'Swiss Franc', '756', 'CHF', '756', '2', 'CHF', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(216, 'Syrian Arab Rep.', 'sy', 'SYR', '760', 'Syrian Pound', '760', 'SYP', '760', '2', '£', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(217, 'Taiwan', 'tw', 'TWN', '158', 'New Taiwan Dollar', '901', 'TWD', '901', '2', 'NT$', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(218, 'Tajikistan', 'tj', 'TJK', '762', 'Somoni', '972', 'TJS', '972', '2', 'ЅM', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(219, 'Tanzania, United Republic of', 'tz', 'TZA', '834', 'Tanzanian Shilling', '834', 'TZS', '834', '2', 'TSh', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(220, 'Thailand', 'th', 'THA', '764', 'Baht', '764', 'THB', '764', '2', '฿', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(221, 'Timor-Leste', 'tl', 'TLS', '626', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(222, 'Togo', 'tg', 'TGO', '768', 'CFA Franc BCEAO', '952', 'XOF', '952', '0', 'CFA', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(223, 'Tokelau', 'tk', 'TKL', '772', 'New Zealand Dollar', '554', 'NZD', '554', '2', '$', '1', '0', '2018-11-30 14:28:37', 1, '2018-11-30 14:28:37', 1),
	(224, 'Tonga', 'to', 'TON', '776', 'Pa\'anga', '776', 'TOP', '776', '2', 'T$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(225, 'Trinidad and Tobago', 'tt', 'TTO', '780', 'Trinidad and Tobago Dollar', '780', 'TTD', '780', '2', 'TT$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(226, 'Tunisia', 'tn', 'TUN', '788', 'Tunisian Dinar', '788', 'TND', '788', '3', 'د.ت', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(227, 'Turkey', 'tr', 'TUR', '792', 'Turkish Lira', '949', 'TRY', '949', '2', '₺', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(228, 'Turkmenistan', 'tm', 'TKM', '795', 'Manat', '934', 'TMT', '934', '2', NULL, '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(229, 'Turks and Caicos Is.', 'tc', 'TCA', '796', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(230, 'Tuvalu', 'tv', 'TUV', '798', 'Australian Dollar', '036', 'AUD', '036', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(231, 'Uganda', 'ug', 'UGA', '800', 'Uganda Shilling', '800', 'UGX', '800', '2', 'USh', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(232, 'Ukraine', 'ua', 'UKR', '804', 'Ukrainian Hryvnia', '980', 'UAH', '980', '2', '₴', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(233, 'United Arab Emirates', 'ae', 'ARE', '784', 'U.A.E. Dirham', '784', 'AED', '784', '2', 'د.إ', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(234, 'United Kingdom', 'gb', 'GBR', '826', 'Pound Sterling', '826', 'GBP', '826', '2', '£', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(235, 'United Nations Interim Administration Mission in Kosovo', 'qz', 'QZZ', '900', 'Euro', '978', 'EUR', '978', '2', '€', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(236, 'United States', 'us', 'USA', '840', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(237, 'US Minor Outlying Islands', 'um', 'UMI', '581', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(238, 'US Virgin Is.', 'vi', 'VIR', '850', 'US Dollar', '840', 'USD', '840', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(239, 'Uruguay', 'uy', 'URY', '858', 'Peso Uruguayo', '858', 'UYU', '858', '2', '$U', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(240, 'Uzbekistan', 'uz', 'UZB', '860', 'Uzbekistan Sum', '860', 'UZS', '860', '2', 'лв', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(241, 'Vanuatu', 'vu', 'VUT', '548', 'Vatu', '548', 'VUV', '548', '0', 'VT', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(242, 'Venezuela', 've', 'VEN', '862', 'Bolivar Fuerte', '937', 'VEF', '937', '2', NULL, '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(243, 'Vietnam', 'vn', 'VNM', '704', 'Dong', '704', 'VND', '704', '0', '₫', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(244, 'Wallis and Futuna Is.', 'wf', 'WLF', '876', 'CFP Franc', '953', 'XPF', '953', '0', NULL, '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(245, 'Western Sahara', 'eh', 'ESH', '732', 'Moroccan Dirham', '504', 'MAD', '504', '2', 'DH', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(246, 'Yemen', 'ye', 'YEM', '887', 'Yemeni Rial', '886', 'YER', '886', '2', '﷼', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(247, 'Zambia', 'zm', 'ZMB', '894', 'Zambian Kwacha', '967', 'ZMW', '967', '2', NULL, '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1),
	(248, 'Zimbabwe', 'zw', 'ZWE', '716', 'Zimbabwe Dollar', '716', 'ZWD', '716', '2', '$', '1', '0', '2018-11-30 14:28:38', 1, '2018-11-30 14:28:38', 1);
/*!40000 ALTER TABLE `m_currency` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_department
DROP TABLE IF EXISTS `m_department`;
CREATE TABLE IF NOT EXISTS `m_department` (
  `id` int(10) NOT NULL,
  `dep_code` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `dep_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dep_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(10) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_department: ~10 rows (approximately)
/*!40000 ALTER TABLE `m_department` DISABLE KEYS */;
INSERT INTO `m_department` (`id`, `dep_code`, `dep_name`, `dep_icon`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, '00001', 'Hội Đồng Quản Trị', 'weekend', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(2, '00002', 'Tài Chính Kế Toán', 'account_balance', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(3, '00003', 'Kinh Doanh', 'business_center', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(4, '00004', 'Mua Hàng', 'shopping_cart', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(5, '00005', 'Xuất Nhập Khẩu', 'import_export', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(6, '00006', 'Admin', 'folder_shared', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(7, '00007', 'Reception', 'question_answer', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(8, '00008', 'Kỹ Thuật', 'build', '0', '2019-01-02 17:17:34', 1, '2019-01-02 17:17:34', 1),
	(9, '00010', 'IT', 'laptop_mac', '0', '2019-01-02 17:17:35', 1, '2019-01-02 17:17:35', 1),
	(10, '00011', 'Tài xế', 'local_shipping', '0', '2019-01-02 17:17:35', 1, '2019-01-02 17:17:35', 1);
/*!40000 ALTER TABLE `m_department` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_function
DROP TABLE IF EXISTS `m_function`;
CREATE TABLE IF NOT EXISTS `m_function` (
  `fnc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fnc_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fnc_memo` text COLLATE utf8_unicode_ci,
  `fnc_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`fnc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_function: ~6 rows (approximately)
/*!40000 ALTER TABLE `m_function` DISABLE KEYS */;
INSERT INTO `m_function` (`fnc_id`, `fnc_name`, `fnc_memo`, `fnc_icon`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 'Tim kiem', NULL, 'search', '0', NULL, NULL, '2018-12-24 17:58:43', NULL),
	(2, 'Sap xep', NULL, 'sort', '0', NULL, NULL, '2018-12-24 17:58:51', NULL),
	(3, 'Them', NULL, 'add', '0', NULL, NULL, '2018-12-24 17:59:26', NULL),
	(4, 'Xoa', NULL, 'delete', '0', NULL, NULL, '2018-12-24 17:59:30', NULL),
	(5, 'Sua', NULL, 'edit', '0', NULL, NULL, '2018-12-24 17:59:36', NULL);
/*!40000 ALTER TABLE `m_function` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_permission_department
DROP TABLE IF EXISTS `m_permission_department`;
CREATE TABLE IF NOT EXISTS `m_permission_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_id` int(11) NOT NULL,
  `scr_id` int(11) NOT NULL,
  `fnc_id` int(11) NOT NULL,
  `dep_allow` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_permission_department: ~6 rows (approximately)
/*!40000 ALTER TABLE `m_permission_department` DISABLE KEYS */;
INSERT INTO `m_permission_department` (`id`, `dep_id`, `scr_id`, `fnc_id`, `dep_allow`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 1, 1, 1, '1', '0', NULL, NULL, '2018-12-24 18:19:47', NULL),
	(2, 1, 1, 2, '1', '0', NULL, NULL, '2018-12-24 18:20:23', NULL),
	(3, 1, 1, 3, '1', '0', NULL, NULL, '2018-12-24 18:20:40', NULL),
	(4, 1, 1, 4, '1', '0', NULL, NULL, '2018-12-24 18:20:53', NULL),
	(5, 1, 1, 5, '0', '0', NULL, NULL, '2018-12-24 18:21:40', NULL),
	(6, 1, 2, 5, '0', '0', NULL, NULL, '2018-12-24 18:21:53', NULL);
/*!40000 ALTER TABLE `m_permission_department` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_permission_user
DROP TABLE IF EXISTS `m_permission_user`;
CREATE TABLE IF NOT EXISTS `m_permission_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_id` int(11) NOT NULL,
  `scr_id` int(11) NOT NULL,
  `fnc_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `usr_allow` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_permission_user: ~6 rows (approximately)
/*!40000 ALTER TABLE `m_permission_user` DISABLE KEYS */;
INSERT INTO `m_permission_user` (`id`, `dep_id`, `scr_id`, `fnc_id`, `usr_id`, `usr_allow`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 1, 1, 1, 1, '1', '0', NULL, NULL, '2018-12-24 18:19:47', NULL),
	(2, 1, 1, 2, 1, '1', '0', NULL, NULL, '2018-12-24 18:20:23', NULL),
	(3, 1, 1, 3, 1, '0', '0', NULL, NULL, '2018-12-24 18:20:40', NULL),
	(4, 1, 1, 4, 1, '0', '0', NULL, NULL, '2018-12-24 18:20:53', NULL),
	(5, 1, 1, 5, 1, '0', '0', NULL, NULL, '2018-12-24 18:21:40', NULL),
	(6, 1, 2, 5, 1, '0', '0', NULL, NULL, '2018-12-24 18:21:53', NULL);
/*!40000 ALTER TABLE `m_permission_user` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_screen
DROP TABLE IF EXISTS `m_screen`;
CREATE TABLE IF NOT EXISTS `m_screen` (
  `scr_id` int(11) NOT NULL AUTO_INCREMENT,
  `scr_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scr_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`scr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_screen: ~2 rows (approximately)
/*!40000 ALTER TABLE `m_screen` DISABLE KEYS */;
INSERT INTO `m_screen` (`scr_id`, `scr_name`, `scr_icon`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 'Cong Ty', 'home', '0', '2018-12-25 00:40:46', 1, '2018-12-24 17:39:57', 1),
	(2, 'Phan Quyen', 'security', '0', '2018-12-25 00:40:51', 1, '2018-12-24 17:40:40', 1);
/*!40000 ALTER TABLE `m_screen` ENABLE KEYS */;

-- Dumping structure for table ubiz.m_screen_function
DROP TABLE IF EXISTS `m_screen_function`;
CREATE TABLE IF NOT EXISTS `m_screen_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fnc_id` int(11) NOT NULL,
  `scr_id` int(11) NOT NULL,
  `delete_flg` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `inp_date` datetime DEFAULT NULL,
  `inp_user` int(11) DEFAULT NULL,
  `upd_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ubiz.m_screen_function: ~6 rows (approximately)
/*!40000 ALTER TABLE `m_screen_function` DISABLE KEYS */;
INSERT INTO `m_screen_function` (`id`, `fnc_id`, `scr_id`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, 1, 1, '0', NULL, NULL, '2018-12-24 18:02:12', NULL),
	(2, 2, 1, '0', NULL, NULL, '2018-12-24 18:02:34', NULL),
	(3, 3, 1, '0', NULL, NULL, '2018-12-24 18:02:38', NULL),
	(4, 4, 1, '0', NULL, NULL, '2018-12-24 18:02:42', NULL),
	(5, 5, 1, '0', NULL, NULL, '2018-12-24 18:02:55', NULL),
	(6, 5, 2, '0', NULL, NULL, '2018-12-24 18:05:51', NULL);
/*!40000 ALTER TABLE `m_screen_function` ENABLE KEYS */;

-- Dumping structure for table ubiz.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ubiz.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for procedure ubiz.proc_getDepPermissions
DROP PROCEDURE IF EXISTS `proc_getDepPermissions`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getDepPermissions`(IN dep_id INT,
IN scr_id INT)
BEGIN
	SELECT
		IFNULL(`m_permission_department`.`dep_id`,dep_id) AS dep_id,
		IFNULL(`m_screen_function`.`scr_id`,scr_id) AS scr_id,
		`m_screen_function`.`fnc_id`,
		IFNULL(`m_permission_department`.`dep_allow`,0) AS dep_allow,
		`m_function`.`fnc_name`,
		`m_function`.`fnc_memo`,
		`m_function`.`fnc_icon`
	FROM
		`m_screen_function`
	LEFT JOIN `m_function` ON `m_function`.`fnc_id` = `m_screen_function`.`fnc_id`
	AND `m_function`.`delete_flg` = '0'
	LEFT JOIN `m_permission_department` ON `m_permission_department`.`fnc_id` = `m_function`.`fnc_id`
	AND `m_permission_department`.`delete_flg` = '0'
	AND `m_permission_department`.`scr_id` = scr_id
	AND `m_permission_department`.`dep_id` = dep_id
	WHERE `m_screen_function`.`scr_id` = scr_id AND `m_screen_function`.`delete_flg` = '0';
END//
DELIMITER ;

-- Dumping structure for procedure ubiz.proc_getUsrPermissions
DROP PROCEDURE IF EXISTS `proc_getUsrPermissions`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getUsrPermissions`(IN dep_id INT,
IN scr_id INT,
IN usr_id INT)
BEGIN
	SELECT `m`.*,
		IFNULL(`m_permission_user`.`usr_allow`,0) AS usr_allow,
		IFNULL(`m_permission_department`.`dep_allow`,0) AS dep_allow
	FROM
	(
		SELECT DISTINCT 
			 IFNULL(`m_permission_user`.`dep_id`,dep_id) AS dep_id,
			 IFNULL(`m_screen_function`.`scr_id`,scr_id) AS scr_id,
			 `m_screen_function`.`fnc_id`,
			 IFNULL(`m_permission_user`.`usr_id`,usr_id) AS usr_id,
			 `m_function`.`fnc_name`,
			 `m_function`.`fnc_memo`,
			 `m_function`.`fnc_icon`
		FROM `m_screen_function`
		LEFT JOIN `m_function` ON `m_function`.`fnc_id` = `m_screen_function`.`fnc_id`
		LEFT JOIN `m_permission_user` ON `m_permission_user`.`fnc_id` = `m_permission_user`.`fnc_id`
		AND m_permission_user.usr_id = usr_id AND m_permission_user.delete_flg = '0'
		LEFT JOIN `m_permission_department` ON `m_permission_department`.`fnc_id` = `m_function`.`fnc_id`
		AND `m_permission_department`.`scr_id` = scr_id
		AND `m_permission_department`.`dep_id` = dep_id
		AND `m_permission_department`.`delete_flg` = '0'
		WHERE m_screen_function.delete_flg = '0' 
		AND m_function.delete_flg = '0' 
		AND m_screen_function.scr_id = scr_id
	) AS m
	LEFT JOIN `m_permission_department` ON `m_permission_department`.`dep_id` = `m`.`dep_id`
	AND `m_permission_department`.`scr_id` = `m`.`scr_id`
	AND `m_permission_department`.`fnc_id` = `m`.`fnc_id`
	LEFT JOIN `m_permission_user` ON `m_permission_user`.`dep_id` = `m`.`dep_id`
	AND `m_permission_user`.`scr_id` = `m`.`scr_id`
	AND `m_permission_user`.`fnc_id` = `m`.`fnc_id`
	AND `m_permission_user`.`usr_id` = `m`.`usr_id`;
END//
DELIMITER ;

-- Dumping structure for table ubiz.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `bhxh` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `bhyt` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `com_id` int(11) DEFAULT '1',
  `dep_id` int(11) DEFAULT '1',
  `rank` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_flg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inp_user` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ubiz.users: ~21 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `code`, `name`, `avatar`, `password`, `phone`, `email`, `address`, `join_date`, `salary`, `bhxh`, `bhyt`, `com_id`, `dep_id`, `rank`, `remember_token`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
	(1, '00001', 'Nguyễn Văn Sang', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'nvsang@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 1, 'Giám Đốc', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(2, '00002', 'Nguyễn Thị Ngọc Dung', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'ngndung@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 2, 'Thủ Quỹ', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(3, '00003', 'Nguyễn Thị Nam', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'ntnam@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 2, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(4, '00004', 'Phan Nguyễn Thảo Vy', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'pntvy@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 2, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(5, '00005', 'Lê Thanh Tuấn', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'lttuan@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Trưởng phòng', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(6, '00006', 'Trần Nguyễn Anh Tuấn', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'tnatuan@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(7, '00007', 'Tô Công Thái', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'tcthai@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(8, '00008', 'Nguyễn Trọng Nghĩa', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'ntnghia@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(9, '00009', 'Huỳnh Thị Hương', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'hthuong@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(10, '00010', 'Võ Quang Nhân', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'vqnhan@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 3, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(11, '00011', 'Nguyễn Thị Thu Vân', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'nttvan@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 4, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(12, '00012', 'Châu Thị Hồng Vân', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'cthvan@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 5, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(13, '00013', 'Trần Đình Nhật Linh', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'tdnlinh@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 6, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(14, '00014', 'Trần Thị Ơn', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'tton@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 6, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(15, '00015', 'Nguyễn Thị Hồng Thanh', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'nththanh@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 7, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(16, '00016', 'Nguyễn Trương Anh Kiệt', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'ntakiet@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 8, 'Trưởng phòng', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(17, '00017', 'Võ Văn Mạnh', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'vvmanh@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 8, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(18, '00018', 'Trương Ánh Cảnh', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'tacanh@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 8, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(19, '00019', 'Nguyễn Đình Thắng', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'ndthang@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 8, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(20, '00020', 'Hoàng Đức Minh', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'hdminh@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 9, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1),
	(21, '00021', 'Nguyễn Văn Còn', NULL, '$2y$10$zqU.9Oml9dU/pTY8.zUipOm8RhVWFk5JNtNTzvGzLUxFiMxhzYaRO', NULL, 'nvcon@tkp.com', NULL, '2019-01-06', NULL, '1', '1', 1, 10, 'Nhân viên', NULL, '0', '2019-01-02 18:24:45', 1, '2019-01-02 18:24:45', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

CREATE TABLE `order` (
	`ord_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`ord_code` VARCHAR(10) NOT NULL COLLATE 'utf8_unicode_ci',
	`ord_date` TIMESTAMP NULL DEFAULT NULL,
	`pri_id` INT(11) NOT NULL,
	`cus_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`exp_date` TIMESTAMP NULL DEFAULT NULL,
	`delete_flg` CHAR(1) NOT NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
	`inp_date` TIMESTAMP NULL DEFAULT NULL,
	`inp_user` INT(11) NOT NULL,
	`upd_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`upd_user` INT(11) NOT NULL,
	PRIMARY KEY (`ord_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

CREATE TABLE `ord_detail` (
	`pro_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`pri_id` INT(11) NOT NULL,
	`model` VARCHAR(100) NULL DEFAULT NULL COLLATE ''utf8_unicode_ci'',
	`series` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`type` CHAR(1) NOT NULL COLLATE 'utf8_unicode_ci',
	`code` VARCHAR(5) NOT NULL COLLATE 'utf8_unicode_ci',
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8_unicode_ci',
	`price` INT(11) NOT NULL,
	`unit` VARCHAR(20) NOT NULL COLLATE 'utf8_unicode_ci',
	`amount` INT(11) NOT NULL,
	`specs` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`delivery_date` TIMESTAMP NULL DEFAULT NULL,
	`status` CHAR(1) NOT NULL COLLATE 'utf8_unicode_ci',
	`delete_flg` CHAR(1) NOT NULL DEFAULT '0' COLLATE 'utf8_unicode_ci',
	`inp_date` TIMESTAMP NULL DEFAULT NULL,
	`inp_user` INT(11) NOT NULL,
	`upd_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`upd_user` INT(11) NOT NULL,
	PRIMARY KEY (`pro_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;
