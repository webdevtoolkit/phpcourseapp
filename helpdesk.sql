
--
-- Table structure for table `appusers`
--

CREATE TABLE IF NOT EXISTS `appusers` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `accountStatus` enum('live','disabled') DEFAULT NULL,
  `hashkey` varchar(45) DEFAULT NULL,
  `userCatId` int(11) DEFAULT NULL,
  `dateAdded` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contactdetails`
--

CREATE TABLE IF NOT EXISTS `contactdetails` (
  `id` int(11) NOT NULL,
  `contactCategory` int(11) DEFAULT NULL,
  `contactId` int(11) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `lat` varchar(45) DEFAULT NULL,
  `lon` varchar(45) DEFAULT NULL,
  `dateAdded` timestamp NULL DEFAULT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `primaryContact` enum('y','n') NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_categories_lookup`
--

CREATE TABLE IF NOT EXISTS `request_categories_lookup` (
  `ID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `requestID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_categories`
--

CREATE TABLE IF NOT EXISTS `support_categories` (
  `ID` int(11) NOT NULL,
  `category` varchar(64) NOT NULL,
  `dateAdded` date NOT NULL,
  `lastUpdated` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_categories`
--

INSERT INTO `support_categories` (`ID`, `category`, `dateAdded`, `lastUpdated`) VALUES
(1, 'Installation', '2015-12-08', '0000-00-00'),
(2, 'Bug fix', '2015-12-08', '0000-00-00'),
(3, 'Licensing', '2015-12-08', '0000-00-00'),
(4, 'Community Version', '2015-12-08', '0000-00-00'),
(5, 'MSSP', '2015-12-08', '0000-00-00'),
(6, 'Enterprise', '2015-12-08', '0000-00-00'),
(7, 'Feature request', '2015-12-08', '0000-00-00'),
(8, 'Hardware', '2015-12-08', '0000-00-00');


-- --------------------------------------------------------

--
-- Table structure for table `usercategories`
--

CREATE TABLE IF NOT EXISTS `usercategories` (
  `id` int(11) NOT NULL,
  `category` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appusers`
--
ALTER TABLE `appusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactdetails`
--
ALTER TABLE `contactdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_categories_lookup`
--
ALTER TABLE `request_categories_lookup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `support_categories`
--
ALTER TABLE `support_categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `usercategories`
--
ALTER TABLE `usercategories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appusers`
--
ALTER TABLE `appusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contactdetails`
--
ALTER TABLE `contactdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `request_categories_lookup`
--
ALTER TABLE `request_categories_lookup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `support_categories`
--
ALTER TABLE `support_categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `support_queries`
--
ALTER TABLE `support_queries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usercategories`
--
ALTER TABLE `usercategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
