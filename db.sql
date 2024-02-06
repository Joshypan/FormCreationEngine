DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id int NOT NULL AUTO_INCREMENT,
    user_login text NOT NULL,
    user_pass text NOT NULL,
    PRIMARY KEY(user_id)
);

insert into users values
(1,'cmb','cmb'),
(2,'rmo','rmo'),
(3,'jpc','jpc');

DROP TABLE IF EXISTS surveys;

CREATE TABLE surveys (
    survey_id int NOT NULL AUTO_INCREMENT,
    survey_owner int NOT NULL,
    survey_name text NOT NULL,
    PRIMARY KEY(survey_id)
);

insert into surveys values
(1,1,"TBP interest Survey"),
(2,1,"ISP Final Exam"),
(3,2,"High School Outreach Form");

DROP TABLE IF EXISTS questions;

CREATE TABLE questions (
    question_surveyid int NOT NULL,
    question_number int NOT NULL,
    question_type text NOT NULL,
    question_name text,
    question_parameters text,
    PRIMARY KEY(question_surveyid,question_number)
);
insert into questions values
(1,1,"ER","E-mail",NULL),
(1,2,"ER","Name",NULL),
(1,3,"MC","Year","Freshman`Sophmore`Junior`Senior`Super Senior"),
(1,4,"CB","What interests you about TBP?","Academics`Community`Internships`Networking"),
(1,5,"D","Expected Graduation Date",NULL);

DROP TABLE IF EXISTS results;

CREATE TABLE results (
    result_id int NOT NULL AUTO_INCREMENT,
    result_survey int NOT NULL,
    result_question int NOT NULL,
    result_answer text NOT NULL,
    PRIMARY KEY(result_id)
);