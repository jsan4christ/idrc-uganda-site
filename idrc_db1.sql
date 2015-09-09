-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2013 at 09:28 AM
-- Server version: 5.6.12
-- PHP Version: 5.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `idrc_db1`
--
CREATE DATABASE IF NOT EXISTS `idrc_db1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `idrc_db1`;

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_categories`
--

CREATE TABLE IF NOT EXISTS `sionapros_categories` (
  `id` tinyint(3) NOT NULL,
  `value` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sionapros_categories`
--

INSERT INTO `sionapros_categories` (`id`, `value`) VALUES
(6, 'GENERAL'),
(12, 'NEWS'),
(14, 'JOBS');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_faqs`
--

CREATE TABLE IF NOT EXISTS `sionapros_faqs` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `category` tinyint(4) NOT NULL,
  `faq_qn` text,
  `faq_ans` text,
  `done_by` varchar(30) DEFAULT NULL,
  `reg_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 PACK_KEYS=1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sionapros_faqs`
--

INSERT INTO `sionapros_faqs` (`id`, `category`, `faq_qn`, `faq_ans`, `done_by`, `reg_date`) VALUES
(1, 6, '<p>What is Francis and Mathias?</p>', '<p>Francis and Mathias is a limited liability company and partnership formed in 2007 by Francis Katende and Mathias Nyombi.</p>', 'SADMIN', '2009-02-27'),
(2, 6, '<p>How can I get involved?</p>', '<p>You can send a donation to our account on the help page or contact us by email and we will get back to you as soon as possible.</p>', 'SADMIN', '2009-09-12');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_main_orga_info1`
--

CREATE TABLE IF NOT EXISTS `sionapros_main_orga_info1` (
  `org_no` mediumint(5) NOT NULL DEFAULT '0',
  `reg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `reg_status` text COLLATE latin1_general_ci NOT NULL,
  `org_type` set('PLC','NGO','CBO') COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `reg_country` tinyint(3) NOT NULL DEFAULT '0',
  `phy_address` text COLLATE latin1_general_ci,
  `post_address` text COLLATE latin1_general_ci,
  `phone` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `fax` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `url` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `spoc` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `logo` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `done_by` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `main_org` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`org_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `sionapros_main_orga_info1`
--

INSERT INTO `sionapros_main_orga_info1` (`org_no`, `reg_date`, `name`, `reg_status`, `org_type`, `reg_country`, `phy_address`, `post_address`, `phone`, `fax`, `email`, `url`, `spoc`, `logo`, `done_by`, `main_org`) VALUES
(3, '2008-06-03 13:40:01', 'MIFUMI', 'SionaPros was registered as a Charity under NGO act, Charity No. S.5914/1857. It is also registered as a limited company, limited by guarantee.', 'NGO', 127, 'Plot 1 Masaba Road, Tororo', 'P. O. Box 274, Tororo', '0751580071', '', 'simonndira@mifumi.org', 'http://www.mifumi.org', 'SADMIN', './images//9ad21112b393f882206931bb08cc59d0.gif', '', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_news`
--

CREATE TABLE IF NOT EXISTS `sionapros_news` (
  `news_no` mediumint(9) NOT NULL AUTO_INCREMENT,
  `category` tinyint(3) NOT NULL,
  `title` varchar(65) NOT NULL,
  `reg_date` date DEFAULT NULL,
  `summary` varchar(300) DEFAULT NULL,
  `details` text NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `photo_desc` varchar(30) NOT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `pub_date` date NOT NULL,
  PRIMARY KEY (`news_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `sionapros_news`
--

INSERT INTO `sionapros_news` (`news_no`, `category`, `title`, `reg_date`, `summary`, `details`, `username`, `photo_desc`, `photo`, `pub_date`) VALUES
(1, 6, 'You Convention', '2009-02-27', '<p>Ebenezer Gospel Ministries welcomes all youth, both local and internation to the third annual youth convention.</p>', '<p>&nbsp;</p>\r\n<!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:RelyOnVML /> <o:AllowPNG /> </o:OfficeDocumentSettings> </xml><![endif]-->\r\n<p>&nbsp;</p>\r\n<!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:TrackMoves /> <w:TrackFormatting /> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:DoNotPromoteQF /> <w:LidThemeOther>EN-US</w:LidThemeOther> <w:LidThemeAsian>X-NONE</w:LidThemeAsian> <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> <w:SplitPgBreakAndParaMark /> <w:DontVertAlignCellWithSp /> <w:DontBreakConstrainedForcedTables /> <w:DontVertAlignInTxbx /> <w:Word11KerningPairs /> <w:CachedColBalance /> </w:Compatibility> <m:mathPr> <m:mathFont m:val="Cambria Math" /> <m:brkBin m:val="before" /> <m:brkBinSub m:val="&#45;-" /> <m:smallFrac m:val="off" /> <m:dispDef /> <m:lMargin m:val="0" /> <m:rMargin m:val="0" /> <m:defJc m:val="centerGroup" /> <m:wrapIndent m:val="1440" /> <m:intLim m:val="subSup" /> <m:naryLim m:val="undOvr" /> </m:mathPr></w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true"   DefSemiHidden="true" DefQFormat="false" DefPriority="99"   LatentStyleCount="267"> <w:LsdException Locked="false" Priority="0" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Normal" /> <w:LsdException Locked="false" Priority="9" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="heading 1" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 2" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 3" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 4" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 5" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 6" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 7" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 8" /> <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 9" /> <w:LsdException Locked="false" Priority="39" Name="toc 1" /> <w:LsdException Locked="false" Priority="39" Name="toc 2" /> <w:LsdException Locked="false" Priority="39" Name="toc 3" /> <w:LsdException Locked="false" Priority="39" Name="toc 4" /> <w:LsdException Locked="false" Priority="39" Name="toc 5" /> <w:LsdException Locked="false" Priority="39" Name="toc 6" /> <w:LsdException Locked="false" Priority="39" Name="toc 7" /> <w:LsdException Locked="false" Priority="39" Name="toc 8" /> <w:LsdException Locked="false" Priority="39" Name="toc 9" /> <w:LsdException Locked="false" Priority="35" QFormat="true" Name="caption" /> <w:LsdException Locked="false" Priority="10" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Title" /> <w:LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /> <w:LsdException Locked="false" Priority="11" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtitle" /> <w:LsdException Locked="false" Priority="22" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Strong" /> <w:LsdException Locked="false" Priority="20" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Emphasis" /> <w:LsdException Locked="false" Priority="59" SemiHidden="false"    UnhideWhenUsed="false" Name="Table Grid" /> <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Placeholder Text" /> <w:LsdException Locked="false" Priority="1" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="No Spacing" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 1" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 1" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 1" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 1" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 1" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 1" /> <w:LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" /> <w:LsdException Locked="false" Priority="34" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /> <w:LsdException Locked="false" Priority="29" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Quote" /> <w:LsdException Locked="false" Priority="30" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Quote" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 1" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 1" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 1" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 1" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 1" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 1" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 1" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 1" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 2" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 2" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 2" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 2" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 2" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 2" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 2" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 2" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 2" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 2" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 2" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 2" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 2" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 2" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 3" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 3" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 3" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 3" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 3" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 3" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 3" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 3" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 3" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 3" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 3" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 3" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 3" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 3" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 4" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 4" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 4" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 4" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 4" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 4" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 4" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 4" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 4" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 4" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 4" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 4" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 4" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 4" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 5" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 5" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 5" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 5" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 5" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 5" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 5" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 5" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 5" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 5" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 5" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 5" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 5" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 5" /> <w:LsdException Locked="false" Priority="60" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Shading Accent 6" /> <w:LsdException Locked="false" Priority="61" SemiHidden="false"    UnhideWhenUsed="false" Name="Light List Accent 6" /> <w:LsdException Locked="false" Priority="62" SemiHidden="false"    UnhideWhenUsed="false" Name="Light Grid Accent 6" /> <w:LsdException Locked="false" Priority="63" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 1 Accent 6" /> <w:LsdException Locked="false" Priority="64" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Shading 2 Accent 6" /> <w:LsdException Locked="false" Priority="65" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 1 Accent 6" /> <w:LsdException Locked="false" Priority="66" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium List 2 Accent 6" /> <w:LsdException Locked="false" Priority="67" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 1 Accent 6" /> <w:LsdException Locked="false" Priority="68" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 2 Accent 6" /> <w:LsdException Locked="false" Priority="69" SemiHidden="false"    UnhideWhenUsed="false" Name="Medium Grid 3 Accent 6" /> <w:LsdException Locked="false" Priority="70" SemiHidden="false"    UnhideWhenUsed="false" Name="Dark List Accent 6" /> <w:LsdException Locked="false" Priority="71" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Shading Accent 6" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful List Accent 6" /> <w:LsdException Locked="false" Priority="73" SemiHidden="false"    UnhideWhenUsed="false" Name="Colorful Grid Accent 6" /> <w:LsdException Locked="false" Priority="19" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" /> <w:LsdException Locked="false" Priority="21" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" /> <w:LsdException Locked="false" Priority="31" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" /> <w:LsdException Locked="false" Priority="32" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Intense Reference" /> <w:LsdException Locked="false" Priority="33" SemiHidden="false"    UnhideWhenUsed="false" QFormat="true" Name="Book Title" /> <w:LsdException Locked="false" Priority="37" Name="Bibliography" /> <w:LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" /> </w:LatentStyles> </xml><![endif]-->\r\n<p>&lt;!--  /* Font Definitions */  @font-face 	{font-family:"Cambria Math"; 	panose-1:2 4 5 3 5 4 6 3 2 4; 	mso-font-charset:1; 	mso-generic-font-family:roman; 	mso-font-format:other; 	mso-font-pitch:variable; 	mso-font-signature:0 0 0 0 0 0;} @font-face 	{font-family:Calibri; 	panose-1:2 15 5 2 2 2 4 3 2 4; 	mso-font-charset:0; 	mso-generic-font-family:swiss; 	mso-font-pitch:variable; 	mso-font-signature:-1610611985 1073750139 0 0 159 0;}  /* Style Definitions */  p.MsoNormal, li.MsoNormal, div.MsoNormal 	{mso-style-unhide:no; 	mso-style-qformat:yes; 	mso-style-parent:""; 	margin-top:0in; 	margin-right:0in; 	margin-bottom:10.0pt; 	margin-left:0in; 	line-height:115%; 	mso-pagination:widow-orphan; 	font-size:11.0pt; 	font-family:"Calibri","sans-serif"; 	mso-ascii-font-family:Calibri; 	mso-ascii-theme-font:minor-latin; 	mso-fareast-font-family:Calibri; 	mso-fareast-theme-font:minor-latin; 	mso-hansi-font-family:Calibri; 	mso-hansi-theme-font:minor-latin; 	mso-bidi-font-family:"Times New Roman"; 	mso-bidi-theme-font:minor-bidi;} .MsoChpDefault 	{mso-style-type:export-only; 	mso-default-props:yes; 	mso-ascii-font-family:Calibri; 	mso-ascii-theme-font:minor-latin; 	mso-fareast-font-family:Calibri; 	mso-fareast-theme-font:minor-latin; 	mso-hansi-font-family:Calibri; 	mso-hansi-theme-font:minor-latin; 	mso-bidi-font-family:"Times New Roman"; 	mso-bidi-theme-font:minor-bidi;} .MsoPapDefault 	{mso-style-type:export-only; 	margin-bottom:10.0pt; 	line-height:115%;} @page Section1 	{size:8.5in 11.0in; 	margin:1.0in 1.0in 1.0in 1.0in; 	mso-header-margin:.5in; 	mso-footer-margin:.5in; 	mso-paper-source:0;} div.Section1 	{page:Section1;} --&gt;</p>\r\n<!--[if gte mso 10]>\r\n<style>\r\n /* Style Definitions */\r\n table.MsoNormalTable\r\n	{mso-style-name:"Table Normal";\r\n	mso-tstyle-rowband-size:0;\r\n	mso-tstyle-colband-size:0;\r\n	mso-style-noshow:yes;\r\n	mso-style-priority:99;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:"";\r\n	mso-padding-alt:0in 5.4pt 0in 5.4pt;\r\n	mso-para-margin-top:0in;\r\n	mso-para-margin-right:0in;\r\n	mso-para-margin-bottom:10.0pt;\r\n	mso-para-margin-left:0in;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:"Calibri","sans-serif";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:"Times New Roman";\r\n	mso-fareast-theme-font:minor-fareast;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;}\r\n</style>\r\n<![endif]-->\r\n<p class="MsoNormal">Our third Youth Convention will take place in December/3<sup>rd</sup>-4<sup>th</sup>/2009 at Ebenezer Gospel Centre and Invitation and registration will be open in November/2009.We shall keep on updating you on youth ministries as we progress.We would like to invite you to over and get involved in youth ministry and support us whenever you can.</p>', 'SADMIN', 'the man in charge', './photos/db2d4fb03a4a93ef09b6ba0e8f2a1f04.jpg', '2009-07-07'),
(2, 12, '2010 Annaul Confrence', '2009-09-07', '<p><!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:RelyOnVML /> <o:AllowPNG /> </o:OfficeDocumentSettings> </xml><![endif]--><!--[if gte mso 9]--> Ebenezer Gospel Ministries welcomes you to the internation Annual General Meeting.</p>', '<p>Ebenezer gospel Centre is getting ready for 2010 Annual Conference which will take place from January/6-8/2010 and you are invited to attend and expect<span>&nbsp; </span>your miracle from God.Registrations are in process and it is free for all.Preahers like Rev.Sylivia Evans from USA,Rev.Judith Gavars,Pastor Marie Macleod Scotland Pastor Moses and Betty Wodila Uganda and others will be Ministering.</p>', 'SADMIN', '', '', '2009-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_object_profile`
--

CREATE TABLE IF NOT EXISTS `sionapros_object_profile` (
  `object` varchar(250) NOT NULL,
  `profile_id` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object`,`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sionapros_object_profile`
--

INSERT INTO `sionapros_object_profile` (`object`, `profile_id`) VALUES
('./main/cs/cs.approve_cs.php', 2),
('./main/cs/cs.upload_thumb.php', 2),
('./main/faqs', 2),
('./main/news', 2),
('./main/pubs', 2),
('./main/security', 1),
('./main/staff', 1),
('./main/user/user.admin_panel.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_profiles`
--

CREATE TABLE IF NOT EXISTS `sionapros_profiles` (
  `profile_id` smallint(6) NOT NULL DEFAULT '0',
  `profile` varchar(20) NOT NULL DEFAULT '',
  `remarks` mediumtext NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sionapros_profiles`
--

INSERT INTO `sionapros_profiles` (`profile_id`, `profile`, `remarks`) VALUES
(1, 'IT', 'sys admins'),
(2, 'PR', 'Donna''s Section\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_pubs`
--

CREATE TABLE IF NOT EXISTS `sionapros_pubs` (
  `id` smallint(5) NOT NULL DEFAULT '0',
  `category` tinyint(3) NOT NULL,
  `title` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `doc` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `pub_date` date NOT NULL,
  PRIMARY KEY (`id`,`doc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `sionapros_pubs`
--

INSERT INTO `sionapros_pubs` (`id`, `category`, `title`, `doc`, `pub_date`) VALUES
(1, 6, 'Francis and Mathias Company Profile', './docs/1235724870FRANCIS,MATHIAS_&CO.pdf', '2009-02-09'),
(2, 6, '2010 Annaul Confrence', './docs/1252746018MDG3.pdf', '2009-05-13'),
(3, 6, 'Ebenezer Gospel Ministries Template', './docs/1252746201CRnM2006.jpg', '2009-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_users`
--

CREATE TABLE IF NOT EXISTS `sionapros_users` (
  `identifier` mediumint(6) NOT NULL DEFAULT '0',
  `reg_date` datetime DEFAULT '0000-00-00 00:00:00',
  `firstname` varchar(30) NOT NULL DEFAULT '',
  `lastname` varchar(30) NOT NULL DEFAULT '',
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(30) NOT NULL DEFAULT '',
  `change_password` enum('Yes','No') NOT NULL DEFAULT 'No',
  `account_status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
  PRIMARY KEY (`identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sionapros_users`
--

INSERT INTO `sionapros_users` (`identifier`, `reg_date`, `firstname`, `lastname`, `username`, `password`, `change_password`, `account_status`) VALUES
(1, '2006-04-30 15:35:50', 'San', 'James', 'SADMIN', 'yxZT/4DrLhOds', 'No', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `sionapros_user_profiles`
--

CREATE TABLE IF NOT EXISTS `sionapros_user_profiles` (
  `profile_id` smallint(6) NOT NULL DEFAULT '0',
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`profile_id`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `sionapros_user_profiles`
--

INSERT INTO `sionapros_user_profiles` (`profile_id`, `username`) VALUES
(1, 'jawaka'),
(2, 'dtara');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
