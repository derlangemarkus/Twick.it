-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Erstellungszeit: 17. Mai 2011 um 07:46
-- Server Version: 5.0.51
-- PHP-Version: 5.2.6
-- 
-- Datenbank: `twickit`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_blocked_mails`
-- 

CREATE TABLE `tbl_blocked_mails` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mail` varchar(255) NOT NULL,
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_blocked_users`
-- 

CREATE TABLE `tbl_blocked_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `my_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `my_user_id` (`my_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_messages`
-- 

CREATE TABLE `tbl_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `send_date` datetime NOT NULL,
  `read_date` datetime default NULL,
  `sender_id` int(11) default NULL,
  `receiver_id` int(11) NOT NULL,
  `deleted_sender` int(11) default '0',
  `deleted_receiver` int(11) default '0',
  `subject` varchar(255) NOT NULL,
  `message` text,
  `type` enum('USER_MESSAGE','NEWSLETTER','BADGE','NOTIFICATION','TWICKIT', 'WALL') default NULL,
  `meta` varchar(255) default NULL,
  `spam` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2067 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2067 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_no_words`
-- 

CREATE TABLE `tbl_no_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `word` varchar(255) default NULL,
  `reason` int(11) default '0',
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=502 DEFAULT CHARSET=utf8 AUTO_INCREMENT=502 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_tags`
-- 

CREATE TABLE `tbl_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `entity` varchar(255) NOT NULL,
  `foreign_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `stemming` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `stemming` (`stemming`)
) ENGINE=MyISAM AUTO_INCREMENT=598315 DEFAULT CHARSET=utf8 AUTO_INCREMENT=598315 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_topics`
-- 

CREATE TABLE `tbl_topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `core_title` varchar(255) NOT NULL,
  `stemming` varchar(255) NOT NULL,
  `url_id` varchar(255) NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `longitude` float default NULL,
  `latitude` float default NULL,
  `geo_date` datetime default NULL,
  `no_geo` int(11) default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=12294 DEFAULT CHARSET=utf8 AUTO_INCREMENT=12294 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_twick_favorites`
-- 

CREATE TABLE `tbl_twick_favorites` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `twick_id` int(10) NOT NULL,
  `user_id` int(11) default NULL,
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `twick_id` (`twick_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=715 DEFAULT CHARSET=utf8 AUTO_INCREMENT=715 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_twick_ratings`
-- 

CREATE TABLE `tbl_twick_ratings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `twick_id` int(10) NOT NULL,
  `rating` int(11) NOT NULL,
  `user_id` int(11) default NULL,
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `twick_id` (`twick_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14870 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14870 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_twick_spam_ratings`
-- 

CREATE TABLE `tbl_twick_spam_ratings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `twick_id` int(10) NOT NULL,
  `user_id` int(11) default NULL,
  `type` int(11) NOT NULL,
  `creation_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `twick_id` (`twick_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8 AUTO_INCREMENT=183 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_twicks`
-- 

CREATE TABLE `tbl_twicks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topic_id` int(10) NOT NULL,
  `language` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `acronym` varchar(255) default NULL,
  `text` varchar(200) NOT NULL,
  `link` varchar(255) default NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `input_source` varchar(30) NOT NULL,
  `rating_sum` int(11) NOT NULL default '0',
  `rating_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14710 DEFAULT CHARSET=utf8 AUTO_INCREMENT=14710 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_twicks_of_the_day`
-- 

CREATE TABLE `tbl_twicks_of_the_day` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date` date NOT NULL,
  `twick_id` int(11) NOT NULL,
  `language_code` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `twick_id` (`twick_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_user_alerts`
-- 

CREATE TABLE `tbl_user_alerts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_users`
-- 

CREATE TABLE `tbl_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mail` varchar(255) NOT NULL,
  `register_mail` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) default NULL,
  `bio` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `location` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `twitter` varchar(255) default NULL,
  `newsletter` int(11) default '0',
  `enable_messages` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `register_language_code` varchar(255) default NULL,
  `approved` int(11) default '0',
  `admin` int(11) default '0',
  `thirdparty_id` varchar(255) default NULL,
  `deleted` int(11) NOT NULL default '0',
  `rating_sum_de` int(11) NOT NULL default '0',
  `rating_count_de` int(11) NOT NULL default '0',
  `rating_sum_en` int(11) NOT NULL default '0',
  `rating_count_en` int(11) NOT NULL default '0',
  `reminder` int(11) NOT NULL default '0',
  `alerts` int(11) NOT NULL default '0',
  `enable_wall` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1263 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1263 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tbl_wall_posts`
-- 

CREATE TABLE `tbl_wall_posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `deleted_sender` int(11) default '0',
  `deleted_receiver` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




CREATE TABLE `tbl_podcast` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `twick_id` int(11) NOT NULL,
  speaker varchar(255),
  `creation_date` datetime default NULL,
`publish_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`twick_id`) REFERENCES tbl_twicks(`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;INE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;



CREATE TABLE `tbl_deleted_twicks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `acronym` varchar(255) default NULL,
  `text` varchar(200) NOT NULL,
  `link` varchar(255) default NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `delete_date` datetime NOT NULL,
  `input_source` varchar(30) NOT NULL,
  `rating_sum` int(11) NOT NULL default '0',
  `rating_count` int(11) NOT NULL default '0',
  deleter_id int not null,
  PRIMARY KEY  (`id`),
  KEY `deleter_id` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM CHARSET=utf8;


CREATE TABLE `tbl_search_stats` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language` varchar(2) NOT NULL,
  `query` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int(11) NULL,
  `ip` varchar(255) NOT NULL,
  tag int default null,
  found int default null,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARSET=utf8;



CREATE TABLE `tbl_poll_answers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `creation_date` datetime NOT NULL,
  `user_id` int(11) NULL,
  `ip` varchar(255) NOT NULL,
  gewinnspiel int default null,
  cent int default null,
  weltreise int default null,
  seo int default null,
  tagesschau int default null,
  gadgets int default null,
  adminrechte int default null,
  vorschlag int default null,
  stars int default null,
  kinder int default null,
  mailing int default null,
  text text,
  mail varchar(50),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM CHARSET=utf8;



-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `view_twick_infos`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`db-twick`@`%` SQL SECURITY DEFINER VIEW `twickit`.`view_twick_infos` AS select `twickit`.`tbl_topics`.`title` AS `title`,`twickit`.`tbl_topics`.`language_code` AS `language_code`,`twickit`.`tbl_twicks`.`id` AS `id`,`twickit`.`tbl_twicks`.`topic_id` AS `topic_id`,`twickit`.`tbl_twicks`.`acronym` AS `acronym`,`twickit`.`tbl_twicks`.`text` AS `text`,`twickit`.`tbl_twicks`.`link` AS `link`,`twickit`.`tbl_twicks`.`user_id` AS `user_id`,`twickit`.`tbl_twicks`.`creation_date` AS `creation_date`,`twickit`.`tbl_users`.`login` AS `login`,`twickit`.`tbl_users`.`name` AS `name`,`twickit`.`tbl_users`.`mail` AS `mail`,`twickit`.`tbl_users`.`twitter` AS `twitter`,`twickit`.`tbl_users`.`deleted` AS `deleted`,`twickit`.`tbl_users`.`link` AS `user_link`,sum(ifnull(`twickit`.`tbl_twick_ratings`.`rating`,0)) AS `rating`,count(distinct `twickit`.`tbl_twick_ratings`.`id`) AS `rating_count` from (((`twickit`.`tbl_twicks` left join `twickit`.`tbl_topics` on((`twickit`.`tbl_topics`.`id` = `twickit`.`tbl_twicks`.`topic_id`))) left join `twickit`.`tbl_twick_ratings` on((`twickit`.`tbl_twick_ratings`.`twick_id` = `twickit`.`tbl_twicks`.`id`))) left join `twickit`.`tbl_users` on((`twickit`.`tbl_users`.`id` = `twickit`.`tbl_twicks`.`user_id`))) group by `twickit`.`tbl_twicks`.`id`,`twickit`.`tbl_topics`.`language_code` order by sum(ifnull(`twickit`.`tbl_twick_ratings`.`rating`,0)) desc;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `view_user_infos`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`db-twick`@`%` SQL SECURITY DEFINER VIEW `twickit`.`view_user_infos` AS select `twickit`.`tbl_users`.`id` AS `id`,`twickit`.`tbl_users`.`mail` AS `mail`,`twickit`.`tbl_users`.`login` AS `login`,`twickit`.`tbl_users`.`password` AS `password`,`twickit`.`tbl_users`.`name` AS `name`,`twickit`.`tbl_users`.`bio` AS `bio`,`twickit`.`tbl_users`.`country` AS `country`,`twickit`.`tbl_users`.`location` AS `location`,`twickit`.`tbl_users`.`link` AS `link`,`twickit`.`tbl_users`.`twitter` AS `twitter`,`twickit`.`tbl_users`.`newsletter` AS `newsletter`,`twickit`.`tbl_users`.`enable_messages` AS `enable_messages`,`twickit`.`tbl_users`.`creation_date` AS `creation_date`,`twickit`.`tbl_users`.`register_language_code` AS `register_language_code`,`twickit`.`tbl_users`.`approved` AS `approved`,`twickit`.`tbl_users`.`admin` AS `admin`,`twickit`.`tbl_users`.`deleted` AS `deleted`,`twickit`.`tbl_topics`.`language_code` AS `language_code`,sum(ifnull(`twickit`.`tbl_twick_ratings`.`rating`,0)) AS `rating_sum`,count(distinct `twickit`.`tbl_twick_ratings`.`id`) AS `rating_count`,count(distinct `twickit`.`tbl_twicks`.`id`) AS `twick_count` from (((`twickit`.`tbl_users` left join `twickit`.`tbl_twicks` on((`twickit`.`tbl_twicks`.`user_id` = `twickit`.`tbl_users`.`id`))) left join `twickit`.`tbl_topics` on((`twickit`.`tbl_topics`.`id` = `twickit`.`tbl_twicks`.`topic_id`))) left join `twickit`.`tbl_twick_ratings` on((`twickit`.`tbl_twick_ratings`.`twick_id` = `twickit`.`tbl_twicks`.`id`))) group by `twickit`.`tbl_users`.`mail`,`twickit`.`tbl_topics`.`language_code` order by sum(ifnull(`twickit`.`tbl_twick_ratings`.`rating`,0)) desc;
