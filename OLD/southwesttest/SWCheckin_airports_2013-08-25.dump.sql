----
-- phpLiteAdmin database dump (http://phpliteadmin.googlecode.com)
-- phpLiteAdmin version: 1.9.4.1
-- Exported: 11:27pm on August 25, 2013 (EDT)
-- database file: ..\SWCheckin.sqlite3
----
BEGIN TRANSACTION;

----
-- Drop table for airports
----
DROP TABLE "airports";

----
-- Table structure for airports
----
CREATE TABLE airports (id INTEGER PRIMARY KEY,airport TEXT,utc_offset NUMERIC,dst NUMERIC, 'timezone' TEXT);

----
-- Data dump for airports, a total of 89 rows
----
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('1','CAK','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('2','ALB','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('3','ABQ','-7','1','America/Denver');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('4','AMA','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('5','ATL','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('6','AUS','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('7','BWI','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('8','BHM','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('9','BOI','-7','1','America/Denver');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('10','BOS','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('11','BKG','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('12','BUF','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('13','BUR','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('14','CHS','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('15','CLT','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('16','MDW','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('17','CLE','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('18','CMH','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('19','CRP','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('20','DAL','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('21','DAY','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('22','DEN','-7','1','America/Denver');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('23','DSM','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('24','DTW','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('25','ELP','-7','1','America/Denver');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('26','FNT','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('27','FLL','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('28','RSW','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('29','GRR','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('30','GSP','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('31','HRL','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('32','BDL','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('33','HOU','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('34','IND','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('35','JAN','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('36','JAX','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('37','MCI','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('38','EYW','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('39','LAS','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('40','LIT','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('41','ISP','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('42','LAX','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('43','SDF','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('44','LBB','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('45','MHT','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('46','MEM','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('47','MAF','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('48','MKE','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('49','MSP','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('50','BNA','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('51','MSY','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('52','LGA','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('53','EWR','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('54','ORF','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('55','OAK','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('56','OKC','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('57','OMA','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('58','ONT','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('59','SNA','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('60','MCO','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('61','ECP','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('62','PNS','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('63','PHL','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('64','PHX','-7','0','America/Phoenix');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('65','PIT','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('66','PDX','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('67','PWM','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('68','PVD','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('69','RDU','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('70','RNO','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('71','RIC','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('72','ROC','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('73','SMF','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('74','SLC','-7','1','America/Denver');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('75','SAT','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('76','SAN','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('77','SFO','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('78','SJC','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('79','SJU','-4','0','America/Puerto_Rico');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('80','SEA','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('81','GEG','-8','1','America/Los_Angeles');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('82','STL','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('83','TPA','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('84','TUS','-7','0','America/Phoenix');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('85','TUL','-6','1','America/Chicago');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('86','IAD','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('87','DCA','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('88','PBI','-5','1','America/New_York');
INSERT INTO "airports" ("id","airport","utc_offset","dst","timezone") VALUES ('89','ICT','-6','1','America/Chicago');
COMMIT;
