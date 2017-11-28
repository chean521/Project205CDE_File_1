/* Insert Admin as first dummy data */

use project205cde;

Insert Into user(studentID,fullname,programme,roles,password,created_by,created_on,status)
Values ('admin','Administrator','admin','admin','admin12345','NULL',now(),'active');
