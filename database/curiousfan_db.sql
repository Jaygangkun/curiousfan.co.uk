-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2021 at 12:26 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `curiousfan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banned`
--

CREATE TABLE `banned` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `icon`) VALUES
(1, 'Instagramer', NULL),
(2, 'Youtubers', NULL),
(3, 'Financial Tipper ', NULL),
(4, 'Others', NULL),
(6, 'Influencers', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creator_profiles`
--

CREATE TABLE `creator_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creating` text COLLATE utf8_unicode_ci,
  `profilePic` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coverPic` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isVerified` enum('No','Pending','Yes','Rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `isFeatured` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `fbUrl` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twUrl` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ytUrl` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitchUrl` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instaUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthlyFee` double(10,2) DEFAULT NULL,
  `discountedFee` double(10,2) DEFAULT NULL,
  `minTip` double(10,2) DEFAULT NULL,
  `user_meta` text COLLATE utf8_unicode_ci,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payout_gateway` enum('None','PayPal','Bank Transfer') COLLATE utf8_unicode_ci DEFAULT 'None',
  `payout_details` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `creator_profiles`
--

INSERT INTO `creator_profiles` (`id`, `user_id`, `category_id`, `username`, `name`, `creating`, `profilePic`, `coverPic`, `isVerified`, `isFeatured`, `fbUrl`, `twUrl`, `ytUrl`, `twitchUrl`, `instaUrl`, `monthlyFee`, `discountedFee`, `minTip`, `user_meta`, `popularity`, `created_at`, `updated_at`, `payout_gateway`, `payout_details`) VALUES
(10, 22, 4, 'theadmin', 'Site Admin', 'Patron of this website', 'profilePics/default-profile-pic.png', 'coverPics/default-cover.jpg', 'Yes', 'No', NULL, NULL, NULL, NULL, NULL, 10.00, NULL, 4.00, '{\"country\":\"United States\",\"city\":\"New York\",\"address\":\"NYC, New York\",\"id\":\"verification\\/gZbFPbF0sYuf312lbLkfO32Fk8dpy1tXI1BtZuzZ.png\"}', 2, '2020-12-04 08:49:47', '2021-03-18 07:12:50', 'None', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `payment_status` enum('Paid','Action Required','Created') COLLATE utf8_unicode_ci NOT NULL,
  `invoice_url` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'user_id',
  `likeable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `likeable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_id` int(10) UNSIGNED NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_media`
--

CREATE TABLE `message_media` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `media_content` varchar(255) DEFAULT 'Image',
  `media_type` enum('Image','Video','Audio','ZIP') DEFAULT NULL,
  `disk` varchar(255) DEFAULT NULL,
  `lock_type` enum('Free','Paid') DEFAULT 'Free',
  `lock_price` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_01_01_000000-create_options_table', 1),
(4, '2016_01_01_000000_add_voyager_user_fields', 2),
(5, '2016_01_01_000000_create_data_types_table', 2),
(6, '2016_05_19_173453_create_menu_table', 2),
(7, '2016_10_21_190000_create_roles_table', 2),
(8, '2016_10_21_190000_create_settings_table', 2),
(9, '2016_11_30_135954_create_permission_table', 2),
(10, '2016_11_30_141208_create_permission_role_table', 2),
(11, '2016_12_26_201236_data_types__add__server_side', 2),
(12, '2017_01_13_000000_add_route_to_menu_items_table', 2),
(13, '2017_01_14_005015_create_translations_table', 2),
(14, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 2),
(15, '2017_03_06_000000_add_controller_to_data_types_table', 2),
(16, '2017_04_21_000000_add_order_to_data_rows_table', 2),
(17, '2017_07_05_210000_add_policyname_to_data_types_table', 2),
(18, '2017_08_05_000000_add_group_to_settings_table', 2),
(19, '2017_11_26_013050_add_user_role_relationship', 2),
(20, '2017_11_26_015000_create_user_roles_table', 2),
(21, '2018_03_11_000000_add_user_settings', 2),
(22, '2018_03_14_000000_add_details_to_data_types_table', 2),
(23, '2018_03_16_000000_make_settings_value_nullable', 2),
(24, '2019_01_06_111055_create_contentblocks_table', 3),
(25, '2016_12_17_114551_create_categories_table', 4),
(26, '2016_12_17_119816_create_categorizables_table', 5),
(27, '2019_02_06_224423_create_creator_profiles', 6),
(28, '2020_11_03_134933_create_friendships_table', 7),
(29, '2020_11_03_134934_create_friendships_groups_table', 8),
(30, '2020_04_04_000000_create_user_follower_table', 9),
(31, '2018_12_14_000000_create_likes_table', 10),
(32, '2020_11_07_183413_create_comments_table', 11),
(33, '2014_10_28_175635_create_threads_table', 12),
(34, '2014_10_28_175710_create_messages_table', 12),
(35, '2014_10_28_180224_create_participants_table', 12),
(36, '2014_11_03_154831_add_soft_deletes_to_participants_table', 12),
(37, '2014_12_04_124531_add_softdeletes_to_threads_table', 12),
(38, '2017_03_30_152742_add_soft_deletes_to_messages_table', 12),
(39, '2020_11_19_145043_create_notifications_table', 13),
(40, '2019_05_03_000001_create_customer_columns', 14),
(41, '2019_05_03_000002_create_subscriptions_table', 15),
(42, '2019_05_03_000003_create_subscription_items_table', 15),
(43, '2021_01_11_165051_create_sessions_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options_table`
--

CREATE TABLE `options_table` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `options_table`
--

INSERT INTO `options_table` (`id`, `option_name`, `option_value`) VALUES
(13, 'payment-settings.currency_code', 'MXN'),
(14, 'payment-settings.currency_symbol', '$'),
(15, 'payment-settings.site_fee', '5'),
(16, 'STRIPE_PUBLIC_KEY', 'pk_'),
(17, 'STRIPE_SECRET_KEY', 'sk_'),
(18, 'stripeEnable', 'No'),
(19, 'paypalEnable', 'Yes'),
(20, 'STRIPE_WEBHOOK_SECRET', 'whsec_'),
(21, 'paypal_email', 'your@paypal.com'),
(22, 'admin_email', 'support@curiousfan.co.uk'),
(29, 'withdraw_min', '20'),
(30, 'minMembershipFee', '2.99'),
(31, 'maxMembershipFee', '1000'),
(32, 'commentsPerPost', '5'),
(33, 'homepage_creators_count', '6'),
(34, 'browse_creators_per_page', '15'),
(35, 'feedPerPage', '10'),
(36, 'followListPerPage', '10'),
(37, 'seo_title', 'CuriousFan - Paid Content Creators Platform'),
(38, 'seo_desc', 'REWARD YOUR FAVOURITE CREATORS HARD WORK WITH CURIOUSFAN'),
(39, 'seo_keys', 'fansonly, onlyfans clone script, php fansonly, php onlyfans, onlyfans clone'),
(40, 'site_title', 'CuriousFan'),
(46, 'homepage_headline', 'Reward your favourite creators hard work'),
(47, 'homepage_intro', 'The best platform where content creators meet their audience. Supporters can subscribe and support to their favourite creators and everyone\'s on win-win.'),
(51, 'home_callout', 'Are you a ##CONTENT CREATOR$$ looking for a way to let your fans support your hard work?\r\nWe will take care of the rest. An entire platform at your fingertips hasslefree.'),
(54, 'homepage_left_title', 'How it works for Creators'),
(55, 'home_left_content', 'Your supporters decide to reward you for your hard work by paying a monthly subscription. In exchange, you keep doing what you love & also offer them some perks. \r\n\r\nAlso, you can get a ton of tips from your most advocate fans.'),
(56, 'homepage_right_title', 'How it works for Supporters'),
(57, 'home_right_content', 'You love what someone does and it is useful to you. You would like to reward them by offering your well appreciated support! Now you have the means to do so by using our platform. \r\n\r\nFind their profile by their name or follow a link provided by the creator and join in.'),
(81, 'minTipAmount', '1.99'),
(82, 'maxTipAmount', '500'),
(83, 'admin_extra_CSS', NULL),
(84, 'admin_extra_JS', NULL),
(85, 'default_storage', 'public'),
(95, 'hgr_left', '#C04848'),
(96, 'hgr_right', '#480048'),
(97, 'header_fcolor', '#FFFFFF'),
(98, 'red_btn_bg', '#DC3545'),
(99, 'red_btn_font', '#FFFFFF'),
(101, 'site_entry_popup', 'No'),
(102, 'entry_popup_title', 'Entry popup title'),
(103, 'entry_popup_message', 'Entry popup message'),
(104, 'entry_popup_confirm_text', 'Continue'),
(105, 'entry_popup_cancel_text', 'Cancel'),
(106, 'entry_popup_awayurl', 'https://google.com'),
(108, 'hide_admin_creators', 'No'),
(109, 'card_gateway', 'None'),
(110, 'ccbill_clientAccnum', NULL),
(111, 'ccbill_Subacc', NULL),
(112, 'ccbill_flexid', NULL),
(113, 'ccbill_salt', NULL),
(118, 'enableMediaDownload', 'No'),
(130, 'laravel_short_pwa', 'FansApp'),
(131, 'PAYSTACK_PUBLIC_KEY', NULL),
(132, 'PAYSTACK_SECRET_KEY', NULL),
(134, 'allow_guest_profile_view', 'Yes'),
(135, 'allow_guest_creators_view', 'Yes'),
(136, 'lock_homepage', 'No'),
(138, 'hideEarningsSimulator', 'Show'),
(139, 'WAS_ACCESS_KEY_ID', NULL),
(140, 'WAS_SECRET_ACCESS_KEY', NULL),
(141, 'WAS_DEFAULT_REGION', NULL),
(142, 'WAS_BUCKET', NULL),
(143, 'DOS_ACCESS_KEY_ID', NULL),
(144, 'DOS_SECRET_ACCESS_KEY', NULL),
(145, 'DOS_DEFAULT_REGION', NULL),
(146, 'DOS_BUCKET', NULL),
(147, 'BACKBLAZE_ACCOUNT_ID', NULL),
(148, 'BACKBLAZE_APP_KEY', NULL),
(149, 'BACKBLAZE_BUCKET', NULL),
(150, 'BACKBLAZE_REGION', NULL),
(151, 'VULTR_ACCESS_KEY_ID', NULL),
(152, 'VULTR_SECRET_ACCESS_KEY', NULL),
(153, 'VULTR_DEFAULT_REGION', NULL),
(154, 'VULTR_BUCKET', NULL),
(155, 'AWS_ACCESS_KEY_ID', NULL),
(156, 'AWS_SECRET_ACCESS_KEY', NULL),
(157, 'AWS_DEFAULT_REGION', NULL),
(158, 'AWS_BUCKET', NULL),
(160, 'TransBank_ENV', 'Testing'),
(161, 'TransBank_CC', NULL),
(162, 'TransBank_Key', NULL),
(163, 'MERCADOPAGO_PUBLIC_KEY', NULL),
(164, 'MERCADOPAGO_SECRET_KEY', NULL),
(168, 'paystack-mode', 'DEFAULT'),
(169, 'lk', 'kljdsflksj lksj f');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_content` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_title`, `page_slug`, `page_content`, `created_at`, `updated_at`) VALUES
(1, 'Terms of Service', 'tos', '<p>Phasellus blandit leo ut odio. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Fusce a quam. Donec posuere vulputate arcu. Nullam tincidunt adipiscing enim.<br><br>Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui. Fusce risus nisl, viverra et, tempor et, pretium in, sapien. Maecenas vestibulum mollis diam. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Quisque malesuada placerat nisl.<br></p>', '2016-08-21 14:03:03', '2019-06-28 12:33:27'),
(3, 'Privacy Policy', 'privacy-policy', '<p>Aliquam eu nunc. Nullam vel sem. Curabitur at lacus ac velit ornare lobortis. Phasellus volutpat, metus eget egestas mollis, lacus lacus blandit dui, id egestas quam mauris ut lacus.<br><br>Sed hendrerit. Proin faucibus arcu quis ante. Cras id dui. Sed fringilla mauris sit amet nibh.<br></p>', '2016-08-28 03:46:04', '2016-08-28 03:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_meta` text COLLATE utf8_unicode_ci,
  `is_default` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `text_content` mediumtext COLLATE utf8mb4_unicode_ci,
  `media_type` enum('None','Image','Video','Audio','ZIP') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `media_content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lock_type` enum('Free','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Paid',
  `user_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_media`
--

CREATE TABLE `post_media` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `media_content` varchar(255) DEFAULT 'NULL',
  `disk` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reporter_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reported_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `report_message` text COLLATE utf8_unicode_ci,
  `reporter_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4nvVyMwOyXJEqyDwz0Xo0qyVHbjgnFcvZHWZZX67', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTnU4bVhncnhMOWxpWlZTd3pMWU5rNHZsVVoxV3lkdzVRcHExQmd5NSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9jdXJpb3VzZmFuLmxvY2FsLmNvbS92YWxpZGF0ZS1saWNlbnNlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToic3dlZXRfYWxlcnQiO2E6MDp7fX0=', 1629875830),
('CuLcXbEEcZ7GYl8HYoLzSdU1T3FGTaAuL3vy9K5e', 22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWnhxOEhtalRZOEhzS1plNzlYYlVsZlA2YlN1eTk2M3BUUFFaTXl3WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9jdXJpb3VzZmFuLmxvY2FsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTE6InN3ZWV0X2FsZXJ0IjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMjt9', 1629887189);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `creator_id` int(11) NOT NULL,
  `subscriber_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gateway` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subscription_expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('Active','Canceled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `subscription_price` double(10,2) NOT NULL,
  `creator_amount` double(10,2) NOT NULL,
  `admin_amount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

CREATE TABLE `tips` (
  `id` int(11) NOT NULL,
  `tipper_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `creator_amount` double(10,2) DEFAULT NULL,
  `admin_amount` double(10,2) DEFAULT NULL,
  `gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` enum('Paid','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paid',
  `intent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unlocks`
--

CREATE TABLE `unlocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipper_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `creator_amount` double(10,2) DEFAULT NULL,
  `admin_amount` double(10,2) DEFAULT NULL,
  `gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` enum('Paid','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Paid',
  `intent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8_unicode_ci,
  `balance` double(10,2) NOT NULL DEFAULT '0.00',
  `isAdmin` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isBanned` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `balance`, `isAdmin`, `ip`, `isBanned`, `created_at`, `updated_at`) VALUES
(22, 'Site Admin', 'support@curiousfan.co.uk', 'users/default.png', NULL, '$2y$10$CuFddg.6DFIfcH6UuaEvUehPZOILCkpV3ZWAQ5peSogrny/bizldC', NULL, NULL, 162.46, 'Yes', '127.0.0.1', 'No', '2020-12-04 08:49:47', '2021-08-25 05:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_follower`
--

CREATE TABLE `user_follower` (
  `id` int(10) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` enum('Pending','Paid','Canceled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`);

--
-- Indexes for table `creator_profiles`
--
ALTER TABLE `creator_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_profiles_user_id_foreign` (`user_id`),
  ADD KEY `creator_profiles_username_index` (`username`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  ADD KEY `likes_user_id_index` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_media`
--
ALTER TABLE `message_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `options_table`
--
ALTER TABLE `options_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `options_table_option_name_unique` (`option_name`),
  ADD KEY `options_table_option_name_index` (`option_name`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tips`
--
ALTER TABLE `tips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unlocks`
--
ALTER TABLE `unlocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_follower`
--
ALTER TABLE `user_follower`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_follower_following_id_index` (`following_id`),
  ADD KEY `user_follower_follower_id_index` (`follower_id`),
  ADD KEY `user_follower_accepted_at_index` (`accepted_at`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creator_profiles`
--
ALTER TABLE `creator_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_media`
--
ALTER TABLE `message_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `options_table`
--
ALTER TABLE `options_table`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tips`
--
ALTER TABLE `tips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unlocks`
--
ALTER TABLE `unlocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_follower`
--
ALTER TABLE `user_follower`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
