/* Create Tables and Database Codes */

/* Create New Database Schemas */
create database project205cde;

/* Create New Table and Add keys */
CREATE TABLE `user` 
(
 `studentID` varchar(50) NOT NULL,
 `fullname` varchar(100) NOT NULL,
 `programme` varchar(20) NOT NULL,
 `roles` varchar(50) NOT NULL,
 `password` varchar(50) NOT NULL,
 `created_by` varchar(50) NOT NULL,
 `created_on` date NOT NULL,
 `status` varchar(50) NOT NULL,
 PRIMARY KEY (`studentID`)
);

CREATE TABLE `voteactivity`
(
 `activity_id` int(11) NOT NULL,
 `creation_date` date NOT NULL,
 `created_by` varchar(50) NOT NULL,
 `start_date` date DEFAULT NULL,
 `end_date` date DEFAULT NULL,
 `description` varchar(255) DEFAULT NULL,
 `category` varchar(50) DEFAULT NULL,
 `restriction` varchar(50) DEFAULT NULL,
 `activity_title` varchar(200) NOT NULL,
 PRIMARY KEY (`activity_id`)
);

	
CREATE TABLE `candidate` 
(
 `activity_id` int(11) NOT NULL,
 `cand_id` varchar(50) NOT NULL,
 `cand_desc` varchar(500) NOT NULL,
 `photo_loc` varchar(200) NOT NULL,
 `id` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`id`),
 KEY `activity_id` (`activity_id`),
 KEY `cand_id` (`cand_id`),
 CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `voteactivity` (`activity_id`),
 CONSTRAINT `candidate_ibfk_2` FOREIGN KEY (`cand_id`) REFERENCES `user` (`studentID`)
);

CREATE TABLE `votes` 
(
 `activity_id` int(11) NOT NULL,
 `studentID` varchar(50) NOT NULL,
 `candidate_id` varchar(50) NOT NULL,
 `choose_date` date NOT NULL,
 `id` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`id`),
 KEY `activity_id` (`activity_id`),
 KEY `studentID` (`studentID`),
 KEY `candidate_id` (`candidate_id`),
 CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `voteactivity` (`activity_id`),
 CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `user` (`studentID`),
 CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `user` (`studentID`)
);


