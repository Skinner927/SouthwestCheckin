----
-- phpLiteAdmin database dump (http://phpliteadmin.googlecode.com)
-- phpLiteAdmin version: 1.9.4.1
-- Exported: 8:45pm on August 24, 2013 (EDT)
-- database file: ..\southwesttest\Airports.sqlite3
----
BEGIN TRANSACTION;

----
-- Drop table for Airports
----
DROP TABLE "Airports";

----
-- Table structure for Airports
----
CREATE TABLE Airports (
    id INTEGER PRIMARY KEY, 
    airport TEXT, 
    utc_offset NUMERIC, 
    dst NUMERIC
    );

----
-- Data dump for Airports, a total of 89 rows
----
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('1','CAK','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('2','ALB','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('3','ABQ','-7','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('4','AMA','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('5','ATL','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('6','AUS','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('7','BWI','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('8','BHM','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('9','BOI','-7','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('10','BOS','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('11','BKG','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('12','BUF','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('13','BUR','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('14','CHS','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('15','CLT','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('16','MDW','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('17','CLE','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('18','CMH','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('19','CRP','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('20','DAL','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('21','DAY','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('22','DEN','-7','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('23','DSM','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('24','DTW','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('25','ELP','-7','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('26','FNT','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('27','FLL','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('28','RSW','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('29','GRR','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('30','GSP','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('31','HRL','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('32','BDL','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('33','HOU','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('34','IND','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('35','JAN','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('36','JAX','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('37','MCI','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('38','EYW','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('39','LAS','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('40','LIT','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('41','ISP','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('42','LAX','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('43','SDF','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('44','LBB','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('45','MHT','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('46','MEM','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('47','MAF','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('48','MKE','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('49','MSP','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('50','BNA','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('51','MSY','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('52','LGA','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('53','EWR','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('54','ORF','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('55','OAK','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('56','OKC','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('57','OMA','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('58','ONT','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('59','SNA','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('60','MCO','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('61','ECP','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('62','PNS','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('63','PHL','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('64','PHX','-7','0');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('65','PIT','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('66','PDX','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('67','PWM','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('68','PVD','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('69','RDU','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('70','RNO','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('71','RIC','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('72','ROC','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('73','SMF','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('74','SLC','-7','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('75','SAT','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('76','SAN','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('77','SFO','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('78','SJC','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('79','SJU','-4','0');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('80','SEA','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('81','GEG','-8','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('82','STL','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('83','TPA','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('84','TUS','-7','0');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('85','TUL','-6','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('86','IAD','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('87','DCA','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('88','PBI','-5','1');
INSERT INTO "Airports" ("id","airport","utc_offset","dst") VALUES ('89','ICT','-6','1');
COMMIT;
