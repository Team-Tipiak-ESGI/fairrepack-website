INSERT INTO category (id_category, name) VALUES (1, 'High-Tech');
INSERT INTO category (id_category, name) VALUES (2, 'Nourriture');

INSERT INTO type (id_type, name, category) VALUES (1, 'Téléphone', 1);
INSERT INTO type (id_type, name, category) VALUES (2, 'Électroménager', 1);
INSERT INTO type (id_type, name, category) VALUES (3, 'Bonbons reconditionnés', 2);
INSERT INTO type (id_type, name, category) VALUES (4, 'Assistant intelligent', 1);

INSERT INTO reference (brand, name, value, type) VALUES ('Soumsoung', 'Galaxy S20', '720', 1);
INSERT INTO reference (brand, name, value, type) VALUES ('Brandt', 'Frigo2ouf', '550', 2);
INSERT INTO reference (brand, name, value, type) VALUES ('Seb', 'Cuiseur2ouf', '120', 2);
INSERT INTO reference (brand, name, value, type) VALUES ('Xiaomi', 'Poco F2 pro', '450', 1);
INSERT INTO reference (brand, name, value, type) VALUES ('Appoul', 'Iphoune 12 PROU', '1200', 1);
INSERT INTO reference (brand, name, value, type) VALUES ('Nokia', '3310Maggle', '50', 1);
INSERT INTO reference (brand, name, value, type) VALUES ('Haribo', 'Tagada', '2', 3);
INSERT INTO reference (brand, name, value, type) VALUES ('Lutti', 'Débonbon', '2', 3);
INSERT INTO reference (brand, name, value, type) VALUES ('Amazon', 'Alexa', '30', 4);
INSERT INTO reference (brand, name, value, type) VALUES ('Huawei', 'Honor 10', '300', 1);