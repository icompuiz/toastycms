SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_content_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `home_page` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_templates`
--

CREATE TABLE IF NOT EXISTS `content_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_content_template_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `system_path` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_template_id` int(11) NOT NULL,
  `parent_content_type_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_type_properties`
--

CREATE TABLE IF NOT EXISTS `content_type_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_property_skel_id` int(11) NOT NULL,
  `value` text,
  `content_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_type_property_skels`
--

CREATE TABLE IF NOT EXISTS `content_type_property_skels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `input_format_id` int(11) NOT NULL,
  `output_format_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`, `type`) VALUES
(1, 'administrators', '2013-05-23 13:57:40', '2013-07-02 07:42:41', 'root'),
(2, 'disabled users', '2013-06-14 04:22:26', '2013-07-03 02:32:00', 'root');


-- --------------------------------------------------------

--
-- Table structure for table `javascripts`
--

CREATE TABLE IF NOT EXISTS `javascripts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `system_path` text,
  `type` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_directory_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `system_path` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `media_directories`
--

CREATE TABLE IF NOT EXISTS `media_directories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'directory',
  `system_path` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `parent_media_directory_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `output_formats`
--

CREATE TABLE IF NOT EXISTS `output_formats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `system_path` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `output_formats`
--

INSERT INTO `output_formats` (`id`, `name`, `system_path`, `type`, `created`, `modified`) VALUES
(1, 'Text Output', 'text_output', 1, '2013-05-23 14:04:13', '2013-05-23 19:40:36'),
(2, 'Image Input', 'image_input', 0, '2013-05-23 19:40:08', '2013-05-23 19:40:45'),
(3, 'Text Input', 'text_input', 0, '2013-05-23 19:41:19', '2013-05-23 19:41:19'),
(4, 'Image Output', 'image_output', 1, '2013-05-23 19:42:43', '2013-05-23 19:42:43'),
(5, 'String Input', 'string_input', 0, '2013-05-23 19:42:59', '2013-05-23 19:42:59'),
(6, 'String Output', 'string_output', 1, '2013-05-23 19:43:11', '2013-05-23 19:43:11'),
(7, 'HTML input', 'html_input', 0, '2013-06-22 21:35:55', '2013-06-22 21:36:54'),
(8, 'HTML output', 'html_output', 1, '2013-06-22 21:36:24', '2013-06-22 21:37:02'),
(9, 'Date Input', 'date_input', 0, '2013-06-28 02:30:37', '2013-06-28 02:30:50'),
(10, 'Date Range Input', 'date_range_input', 0, '2013-06-28 03:01:26', '2013-06-28 03:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'normal',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`, `created`, `modified`) VALUES
(1, 'site_name', 'ToastyCMS', 'root', NULL, '2013-07-10 08:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE IF NOT EXISTS `snippets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `system_path` text,
  `type` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `stylesheets`
--

CREATE TABLE IF NOT EXISTS `stylesheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `system_path` text,
  `type` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `type` varchar(255) NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group_id`, `created`, `modified`, `email`, `status`, `type`) VALUES
(1, 'root', '', 1, '2013-05-23 13:58:16', '2013-07-06 00:06:24', '', 'active', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `user_properties`
--

CREATE TABLE IF NOT EXISTS `user_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text,
  `user_id` int(11) NOT NULL,
  `user_property_skel_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_property_skels`
--

CREATE TABLE IF NOT EXISTS `user_property_skels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `input_format_id` int(11) NOT NULL,
  `output_format_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


alter table contents add column sort int(11);
alter table stylesheets add column editor_enabled tinyint(1);
