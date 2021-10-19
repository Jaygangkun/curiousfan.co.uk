-- -------------------------------------------------------------
-- TablePlus 3.6.2(322)
--
-- https://tableplus.com/
--
-- Database: patreon
-- Generation Time: 2021-03-21 08:47:24.7060
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `banned`;
CREATE TABLE `banned` (
  `id` int unsigned NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `commentable_type` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `creator_profiles`;
CREATE TABLE `creator_profiles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `category_id` int DEFAULT NULL,
  `username` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `creating` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `profilePic` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `coverPic` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `isVerified` enum('No','Pending','Yes','Rejected') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `isFeatured` enum('No','Yes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `fbUrl` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `twUrl` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ytUrl` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitchUrl` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `instaUrl` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthlyFee` double(10,2) DEFAULT NULL,
  `discountedFee` double(10,2) DEFAULT NULL,
  `minTip` double(10,2) DEFAULT NULL,
  `user_meta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `popularity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payout_gateway` enum('None','PayPal','Bank Transfer') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'None',
  `payout_details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `creator_profiles_user_id_foreign` (`user_id`),
  KEY `creator_profiles_username_index` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `subscription_id` int NOT NULL,
  `amount` double(10,2) NOT NULL,
  `payment_status` enum('Paid','Action Required','Created') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT 'user_id',
  `likeable_type` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `likeable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  KEY `likes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `message_media`;
CREATE TABLE `message_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_id` int NOT NULL,
  `media_content` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'Image',
  `media_type` enum('Image','Video','Audio','ZIP') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lock_type` enum('Free','Paid') COLLATE utf8mb4_general_ci DEFAULT 'Free',
  `lock_price` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int unsigned NOT NULL,
  `to_id` int NOT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` enum('No','Yes') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `options_table`;
CREATE TABLE `options_table` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `option_value` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `options_table_option_name_unique` (`option_name`),
  KEY `options_table_option_name_index` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `gateway` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_meta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `is_default` enum('No','Yes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `post_media`;
CREATE TABLE `post_media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `media_content` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'NULL',
  `disk` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `text_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `media_type` enum('None','Image','Video','Audio','ZIP') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `media_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lock_type` enum('Free','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Paid',
  `user_id` int NOT NULL,
  `profile_id` int NOT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reporter_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reporter_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reported_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `report_message` text COLLATE utf8_unicode_ci,
  `reporter_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `payload` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int NOT NULL,
  `subscriber_id` int unsigned NOT NULL,
  `subscription_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gateway` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subscription_expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('Active','Canceled') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `subscription_price` double(10,2) NOT NULL,
  `creator_amount` double(10,2) NOT NULL,
  `admin_amount` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tips`;
CREATE TABLE `tips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipper_id` int NOT NULL,
  `creator_id` int NOT NULL,
  `post_id` int NOT NULL,
  `amount` double(10,2) NOT NULL,
  `creator_amount` double(10,2) DEFAULT NULL,
  `admin_amount` double(10,2) DEFAULT NULL,
  `gateway` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` enum('Paid','Pending') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paid',
  `intent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `unlocks`;
CREATE TABLE `unlocks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tipper_id` int NOT NULL,
  `creator_id` int NOT NULL,
  `message_id` int NOT NULL,
  `amount` double(10,2) NOT NULL,
  `creator_amount` double(10,2) DEFAULT NULL,
  `admin_amount` double(10,2) DEFAULT NULL,
  `gateway` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` enum('Paid','Pending') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paid',
  `intent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `user_follower`;
CREATE TABLE `user_follower` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `following_id` bigint unsigned NOT NULL,
  `follower_id` bigint unsigned NOT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_follower_following_id_index` (`following_id`),
  KEY `user_follower_follower_id_index` (`follower_id`),
  KEY `user_follower_accepted_at_index` (`accepted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `settings` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `balance` double(10,2) NOT NULL DEFAULT '0.00',
  `isAdmin` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'No',
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `isBanned` enum('No','Yes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` enum('Pending','Paid','Canceled') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `category`, `icon`) VALUES
('1', 'Instagramer', NULL),
('2', 'Youtubers', NULL),
('3', 'Financial Tipper ', NULL),
('4', 'Others', NULL),
('6', 'Influencers', NULL);

INSERT INTO `creator_profiles` (`id`, `user_id`, `category_id`, `username`, `name`, `creating`, `profilePic`, `coverPic`, `isVerified`, `isFeatured`, `fbUrl`, `twUrl`, `ytUrl`, `twitchUrl`, `instaUrl`, `monthlyFee`, `discountedFee`, `minTip`, `user_meta`, `popularity`, `created_at`, `updated_at`, `payout_gateway`, `payout_details`) VALUES
('10', '22', '4', 'theadmin', 'Site Admin', 'Patron of this website', 'profilePics/default-profile-pic.png', 'coverPics/default-cover.jpg', 'Yes', 'No', NULL, NULL, NULL, NULL, NULL, '10.00', NULL, '4.00', '{\"country\":\"United States\",\"city\":\"New York\",\"address\":\"NYC, New York\",\"id\":\"verification\\/gZbFPbF0sYuf312lbLkfO32Fk8dpy1tXI1BtZuzZ.png\"}', '2', '2020-12-04 13:49:47', '2021-03-18 12:12:50', 'None', NULL);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
('1', '2014_10_12_000000_create_users_table', '1'),
('2', '2014_10_12_100000_create_password_resets_table', '1'),
('3', '2019_01_01_000000-create_options_table', '1'),
('4', '2016_01_01_000000_add_voyager_user_fields', '2'),
('5', '2016_01_01_000000_create_data_types_table', '2'),
('6', '2016_05_19_173453_create_menu_table', '2'),
('7', '2016_10_21_190000_create_roles_table', '2'),
('8', '2016_10_21_190000_create_settings_table', '2'),
('9', '2016_11_30_135954_create_permission_table', '2'),
('10', '2016_11_30_141208_create_permission_role_table', '2'),
('11', '2016_12_26_201236_data_types__add__server_side', '2'),
('12', '2017_01_13_000000_add_route_to_menu_items_table', '2'),
('13', '2017_01_14_005015_create_translations_table', '2'),
('14', '2017_01_15_000000_make_table_name_nullable_in_permissions_table', '2'),
('15', '2017_03_06_000000_add_controller_to_data_types_table', '2'),
('16', '2017_04_21_000000_add_order_to_data_rows_table', '2'),
('17', '2017_07_05_210000_add_policyname_to_data_types_table', '2'),
('18', '2017_08_05_000000_add_group_to_settings_table', '2'),
('19', '2017_11_26_013050_add_user_role_relationship', '2'),
('20', '2017_11_26_015000_create_user_roles_table', '2'),
('21', '2018_03_11_000000_add_user_settings', '2'),
('22', '2018_03_14_000000_add_details_to_data_types_table', '2'),
('23', '2018_03_16_000000_make_settings_value_nullable', '2'),
('24', '2019_01_06_111055_create_contentblocks_table', '3'),
('25', '2016_12_17_114551_create_categories_table', '4'),
('26', '2016_12_17_119816_create_categorizables_table', '5'),
('27', '2019_02_06_224423_create_creator_profiles', '6'),
('28', '2020_11_03_134933_create_friendships_table', '7'),
('29', '2020_11_03_134934_create_friendships_groups_table', '8'),
('30', '2020_04_04_000000_create_user_follower_table', '9'),
('31', '2018_12_14_000000_create_likes_table', '10'),
('32', '2020_11_07_183413_create_comments_table', '11'),
('33', '2014_10_28_175635_create_threads_table', '12'),
('34', '2014_10_28_175710_create_messages_table', '12'),
('35', '2014_10_28_180224_create_participants_table', '12'),
('36', '2014_11_03_154831_add_soft_deletes_to_participants_table', '12'),
('37', '2014_12_04_124531_add_softdeletes_to_threads_table', '12'),
('38', '2017_03_30_152742_add_soft_deletes_to_messages_table', '12'),
('39', '2020_11_19_145043_create_notifications_table', '13'),
('40', '2019_05_03_000001_create_customer_columns', '14'),
('41', '2019_05_03_000002_create_subscriptions_table', '15'),
('42', '2019_05_03_000003_create_subscription_items_table', '15'),
('43', '2021_01_11_165051_create_sessions_table', '16');

INSERT INTO `options_table` (`id`, `option_name`, `option_value`) VALUES
('13', 'payment-settings.currency_code', 'MXN'),
('14', 'payment-settings.currency_symbol', '$'),
('15', 'payment-settings.site_fee', '5'),
('16', 'STRIPE_PUBLIC_KEY', 'pk_'),
('17', 'STRIPE_SECRET_KEY', 'sk_'),
('18', 'stripeEnable', 'No'),
('19', 'paypalEnable', 'Yes'),
('20', 'STRIPE_WEBHOOK_SECRET', 'whsec_'),
('21', 'paypal_email', 'your@paypal.com'),
('22', 'admin_email', 'you@example.org'),
('29', 'withdraw_min', '20'),
('30', 'minMembershipFee', '2.99'),
('31', 'maxMembershipFee', '1000'),
('32', 'commentsPerPost', '5'),
('33', 'homepage_creators_count', '6'),
('34', 'browse_creators_per_page', '15'),
('35', 'feedPerPage', '10'),
('36', 'followListPerPage', '10'),
('37', 'seo_title', 'FansOnly - Paid Content Creators Platform'),
('38', 'seo_desc', 'REWARD YOUR FAVOURITE CREATORS HARD WORK WITH PHP PATRON CLONE SCRIPT'),
('39', 'seo_keys', 'fansonly, onlyfans clone script, php fansonly, php onlyfans, onlyfans clone'),
('40', 'site_title', 'PHP FansOnly'),
('46', 'homepage_headline', 'Reward your favourite creators hard work'),
('47', 'homepage_intro', 'The best platform where content creators meet their audience. Supporters can subscribe and support to their favourite creators and everyone\'s on win-win.'),
('51', 'home_callout', 'Are you a ##CONTENT CREATOR$$ looking for a way to let your fans support your hard work?\r\nWe will take care of the rest. An entire platform at your fingertips hasslefree.'),
('54', 'homepage_left_title', 'How it works for Creators'),
('55', 'home_left_content', 'Your supporters decide to reward you for your hard work by paying a monthly subscription. In exchange, you keep doing what you love & also offer them some perks. \r\n\r\nAlso, you can get a ton of tips from your most advocate fans.'),
('56', 'homepage_right_title', 'How it works for Supporters'),
('57', 'home_right_content', 'You love what someone does and it is useful to you. You would like to reward them by offering your well appreciated support! Now you have the means to do so by using our platform. \r\n\r\nFind their profile by their name or follow a link provided by the creator and join in.'),
('81', 'minTipAmount', '1.99'),
('82', 'maxTipAmount', '500'),
('83', 'admin_extra_CSS', NULL),
('84', 'admin_extra_JS', NULL),
('85', 'default_storage', 'public'),
('95', 'hgr_left', '#C04848'),
('96', 'hgr_right', '#480048'),
('97', 'header_fcolor', '#FFFFFF'),
('98', 'red_btn_bg', '#DC3545'),
('99', 'red_btn_font', '#FFFFFF'),
('101', 'site_entry_popup', 'No'),
('102', 'entry_popup_title', 'Entry popup title'),
('103', 'entry_popup_message', 'Entry popup message'),
('104', 'entry_popup_confirm_text', 'Continue'),
('105', 'entry_popup_cancel_text', 'Cancel'),
('106', 'entry_popup_awayurl', 'https://google.com'),
('108', 'hide_admin_creators', 'No'),
('109', 'card_gateway', 'None'),
('110', 'ccbill_clientAccnum', NULL),
('111', 'ccbill_Subacc', NULL),
('112', 'ccbill_flexid', NULL),
('113', 'ccbill_salt', NULL),
('118', 'enableMediaDownload', 'No'),
('130', 'laravel_short_pwa', 'FansApp'),
('131', 'PAYSTACK_PUBLIC_KEY', NULL),
('132', 'PAYSTACK_SECRET_KEY', NULL),
('134', 'allow_guest_profile_view', 'Yes'),
('135', 'allow_guest_creators_view', 'Yes'),
('136', 'lock_homepage', 'No'),
('138', 'hideEarningsSimulator', 'Show'),
('139', 'WAS_ACCESS_KEY_ID', NULL),
('140', 'WAS_SECRET_ACCESS_KEY', NULL),
('141', 'WAS_DEFAULT_REGION', NULL),
('142', 'WAS_BUCKET', NULL),
('143', 'DOS_ACCESS_KEY_ID', NULL),
('144', 'DOS_SECRET_ACCESS_KEY', NULL),
('145', 'DOS_DEFAULT_REGION', NULL),
('146', 'DOS_BUCKET', NULL),
('147', 'BACKBLAZE_ACCOUNT_ID', NULL),
('148', 'BACKBLAZE_APP_KEY', NULL),
('149', 'BACKBLAZE_BUCKET', NULL),
('150', 'BACKBLAZE_REGION', NULL),
('151', 'VULTR_ACCESS_KEY_ID', NULL),
('152', 'VULTR_SECRET_ACCESS_KEY', NULL),
('153', 'VULTR_DEFAULT_REGION', NULL),
('154', 'VULTR_BUCKET', NULL),
('155', 'AWS_ACCESS_KEY_ID', NULL),
('156', 'AWS_SECRET_ACCESS_KEY', NULL),
('157', 'AWS_DEFAULT_REGION', NULL),
('158', 'AWS_BUCKET', NULL),
('160', 'TransBank_ENV', 'Testing'),
('161', 'TransBank_CC', NULL),
('162', 'TransBank_Key', NULL),
('163', 'MERCADOPAGO_PUBLIC_KEY', NULL),
('164', 'MERCADOPAGO_SECRET_KEY', NULL),
('168', 'paystack-mode', 'DEFAULT');

INSERT INTO `pages` (`id`, `page_title`, `page_slug`, `page_content`, `created_at`, `updated_at`) VALUES
('1', 'Terms of Service', 'tos', '<p>Phasellus blandit leo ut odio. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Fusce a quam. Donec posuere vulputate arcu. Nullam tincidunt adipiscing enim.<br><br>Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui. Fusce risus nisl, viverra et, tempor et, pretium in, sapien. Maecenas vestibulum mollis diam. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Quisque malesuada placerat nisl.<br></p>', '2016-08-21 19:03:03', '2019-06-28 17:33:27'),
('3', 'Privacy Policy', 'privacy-policy', '<p>Aliquam eu nunc. Nullam vel sem. Curabitur at lacus ac velit ornare lobortis. Phasellus volutpat, metus eget egestas mollis, lacus lacus blandit dui, id egestas quam mauris ut lacus.<br><br>Sed hendrerit. Proin faucibus arcu quis ante. Cras id dui. Sed fringilla mauris sit amet nibh.<br></p>', '2016-08-28 08:46:04', '2016-08-28 08:46:04');

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `balance`, `isAdmin`, `ip`, `isBanned`, `created_at`, `updated_at`) VALUES
('22', 'Site Admin', 'admin@example.org', 'users/default.png', NULL, '$2y$10$W7J09QNB3MY5PlvUSyUNQOEssNDNGF9sQavauc0AUVtcpLleBf3.G', NULL, NULL, '162.46', 'Yes', '127.0.0.1', 'No', '2020-12-04 13:49:47', '2021-03-19 11:15:58');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;