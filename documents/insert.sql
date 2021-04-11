# References types categories
INSERT INTO category (id_category, name) VALUES (1, 'High-Tech');
INSERT INTO category (id_category, name) VALUES (2, 'Nourriture');

# References types
INSERT INTO type (id_type, name, category) VALUES (1, 'Téléphone', 1);
INSERT INTO type (id_type, name, category) VALUES (2, 'Électroménager', 1);
INSERT INTO type (id_type, name, category) VALUES (3, 'Bonbons reconditionnés', 2);
INSERT INTO type (id_type, name, category) VALUES (4, 'Assistant intelligent', 1);

# Product references
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('1bd4157d-1c2c-4b99-9966-96b328da60db', 'Soumsoung', 'Galaxy S20', '720', 1);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('d4579987-00a1-4d9a-a7d9-810d1e6b0484', 'Brandt', 'Frigo2ouf', '550', 2);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('e776be49-9dca-4934-b8e9-32bdbcf35147', 'Seb', 'Cuiseur2ouf', '120', 2);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('c3a0711d-224e-457a-a613-220a92a6a014', 'Xiaomi', 'Poco F2 pro', '450', 1);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('e9afcd30-e260-4e8b-b650-cf579dfc6168', 'Appoul', 'Iphoune 12 PROU', '1200', 1);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('c7da9494-ddec-4962-af2a-aa6678c56db5', 'Nokia', '3310Maggle', '50', 1);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('6ae37645-f101-40ed-ba9d-2bf99b590b90', 'Haribo', 'Tagada', '2', 3);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('1e8c247f-660b-4919-8754-6e9b64edaa69', 'Lutti', 'Débonbon', '2', 3);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('0d2d6990-108e-4533-a594-2e95cc6f1b65', 'Amazon', 'Alexa', '30', 4);
INSERT INTO reference (uuid_reference, brand, name, value, type) VALUES ('dec38faa-2708-45b0-a21c-0b5e64ca3d1f', 'Huawei', 'Honor 10', '300', 1);

# Addresses
INSERT INTO address (id_address, country, owner_name, address_line1, city, postal_code) VALUES (1, 'France', 'Mathias', '64 rue Violet', 'Paris', '95350');

# Warehouses
INSERT INTO warehouse (name, address) VALUES ('Paris', 1);