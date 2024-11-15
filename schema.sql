SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `blogcomments` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `parent_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `privacy_level` int(11) NOT NULL,
  `pinned` tinyint(1) NOT NULL default '0',
  `kudos` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bulletincomments`
--

CREATE TABLE IF NOT EXISTS `bulletincomments` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bulletins`
--

CREATE TABLE IF NOT EXISTS `bulletins` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `user_id` int(11) NOT NULL,
  `favorites` text,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL auto_increment,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL default 'PENDING',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groupcomments`
--

CREATE TABLE IF NOT EXISTS `groupcomments` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `members` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `layoutcomments`
--

CREATE TABLE IF NOT EXISTS `layoutcomments` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `layouts`
--

CREATE TABLE IF NOT EXISTS `layouts` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL auto_increment,
  `toid` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `content_type` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL auto_increment,
  `session_id` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `last_logon` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `last_activity` timestamp NOT NULL default '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `rank` tinyint(4) NOT NULL default '0',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `bio` varchar(500) NOT NULL default '',
  `interests` varchar(500) NOT NULL default ' ',
  `css` blob NOT NULL,
  `music` varchar(255) NOT NULL default 'default.mp3',
  `pfp` varchar(255) NOT NULL default 'default.jpg',
  `currentgroup` varchar(255) NOT NULL default 'None',
  `status` varchar(255) NOT NULL default '',
  `private` tinyint(1) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `lastactive` datetime NOT NULL,
  `lastlogon` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
