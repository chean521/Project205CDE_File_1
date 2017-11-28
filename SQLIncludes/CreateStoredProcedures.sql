/* Stored Procedure Codes */

use project205cde;

/* Procedure GetActivity_Result */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetActivity_Result`(IN `act_id` INT)
BEGIN

SELECT
    voteactivity.activity_id	as 'act_id',	
    voteactivity.activity_title	as 'act_ttl',
    voteactivity.creation_date	as 'act_create',
    voteactivity.description	as 'act_desc',
    voteactivity.start_date	as 'act_start',
    voteactivity.end_date	as 'act_end'

   FROM
       voteactivity

   WHERE
       voteactivity.activity_id = act_id;

END

/* Procedure GetCandDetails_Result */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCandDetails_Result`(IN `act_id` INT)
begin
   select
       usr.studentID	as 'std_id',
       usr.fullname	as 'std_name',
       usr.programme	as 'prog'

   from
       candidate as cd

   join
       user as usr on cd.cand_id = usr.studentID

   where
       cd.activity_id = act_id;
   
end

/* Procedure GetCandDetails_Vote */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCandDetails_Vote`(IN `act_id` INT)
BEGIN
SELECT
       cnd.cand_id,
       usr.fullname,
       cnd.cand_desc,
       cnd.photo_loc
      
   FROM
   	candidate as cnd
       
  JOIN
   	user as usr ON usr.studentID = cnd.cand_id
       
   WHERE
cnd.activity_id = act_id;

END

/* Procedure GetNoResult_All */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetNoResult_All`(IN `act_id` INT)
BEGIN

   select 
   	candidate_id, 
       count(*) as 'no_vote'
       
   from 
   	votes
       
   where 
   	activity_id=act_id
       
   group by
   	candidate_id
       
   order by 
   	count(*) DESC;

END

/* Procedure GetNoVote_Result */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetNoVote_Result`(IN `act_id` INT, IN `candidate` VARCHAR(50))
BEGIN

SELECT
       	COUNT(vs.candidate_id)	as 'no_of_cand'
           
       FROM
       	votes as vs
           
   	WHERE
       	vs.activity_id = act_id
       
       AND
       	vs.candidate_id = candidate;

END

/* Procedure GetUserStats */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserStats`(IN `stat` VARCHAR(50), IN `std_id` VARCHAR(50))
BEGIN
DECLARE con_id varchar(50);

IF(std_id = '') THEN
    SELECT
   	studentID as line_1,
        fullname as line_2,
       	programme as line_3,
       	roles as line_4
    FROM
   	user
    WHERE
   	status = stat;
ELSE
    SET con_id = concat(std_id, '%');
    SELECT
   	studentID as line_1,
        fullname as line_2,
       	programme as line_3,
       	roles as line_4
    FROM
   	user
    WHERE
       	status = stat
    AND
       	studentID LIKE con_id;
   END IF;

end

/* Procedure GetVoteActivity */
	
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVoteActivity`(IN `date_create` DATE)
   NO SQL
BEGIN
IF(date_create = '') THEN
       SELECT
           voteactivity.activity_id,
           voteactivity.activity_title,
           voteactivity.creation_date,
           voteactivity.start_date,
           voteactivity.end_date,
           voteactivity.category,
           voteactivity.restriction

       FROM
           voteactivity;
ELSE
       SELECT
           voteactivity.activity_id,
           voteactivity.activity_title,
           voteactivity.creation_date,
           voteactivity.start_date,
           voteactivity.end_date,
           voteactivity.category,
           voteactivity.restriction

       FROM
           voteactivity

       WHERE voteactivity.creation_date = date_create;
   END IF;
END

/*Procedure GetVoteCountBySingle */
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVoteCountBySingle`(IN `act_id` INT(10), IN `std_id` VARCHAR(50))
BEGIN
SELECT
   	COUNT(*) as 'result'
   FROM
   	votes
   WHERE
activity_id = act_id
   AND
   	studentID = std_id;
END

