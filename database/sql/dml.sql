USE db_gudang_bangunan;

INSERT INTO role (nama_role) VALUES
('Super Admin'),
('Admin Gudang'),
('Staf Pengadaan'),
('Kasir');

INSERT INTO user (username, password, idrole) VALUES
('admin',    SHA2('admin123', 256),   1),
('gudang01', SHA2('gudang123', 256),  2),
('gudang02', SHA2('gudang123', 256),  2),
('pengadaan01', SHA2('beli123', 256), 3),
('kasir01',  SHA2('kasir123', 256),   4),
('kasir02',  SHA2('kasir123', 256),   4);

INSERT INTO satuan (nama_satuan, status) VALUES
('Sak', 1),      -- 1
('Batang', 1),   -- 2
('Kaleng', 1),   -- 3
('Kg', 1),       -- 4
('Lembar', 1),   -- 5
('Pcs', 1),      -- 6
('Meter', 1),    -- 7
('Dus', 1),      -- 8
('Roll', 1),     -- 9
('Ikat', 0);     -- 10 (nonaktif)

INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES
('PT Semen Gresik','Y','A'),
('PT Krakatau Steel','Y', 'N'),
('PT Wahana Duta Jaya Rucika','Y', 'A'),
('PT Avia Avian', 'Y', 'A'),
('PT Trilliun','Y', 'A'),
('PT Arwana Citramulia', 'Y', 'A'),
('PT Jayaboard Industri', 'Y', 'A'),
('UD Sumber Bangunan','T', 'A');

INSERT INTO margin_penjualan (persen, status, iduser) VALUES
(5,  0, 1),
(10, 0, 1),
(15, 1, 1),
(20, 0, 1),
(25, 0, 1);

INSERT INTO barang (jenis, nama, idsatuan, status, harga) VALUES
-- S = material dasar
('S', 'Semen Gresik 50kg',               1, 1, 68000),
('S', 'Semen Instan Mortar 40kg',        1, 1, 85000),
('S', 'Pasir Pasang',                    4, 1, 500),
('S', 'Batu Bata Merah',                 6, 1, 900),
('S', 'Batako Press',                    6, 0, 2500),
-- B = besi & pipa
('B', 'Besi Beton 10mm',                 2, 1, 85000),
('B', 'Besi Beton 8mm',                  2, 1, 55000),
('B', 'Pipa PVC Rucika 3 inch',          2, 1, 95000),
('B', 'Pipa PVC Rucika 1/2 inch',        2, 1, 22000),
('B', 'Kawat Bendrat',                   4, 1, 18000),
-- C = cat & pelapis
('C', 'Cat Tembok Avian Putih 5kg',      3, 1, 120000),
('C', 'Cat Kayu Trilliun Cokelat 1kg',   3, 1, 55000),
('C', 'Cat Waterproofing 4kg',           3, 1, 135000),
-- P = perlengkapan
('P', 'Paku 5cm',                        4, 1, 18000),
('P', 'Engsel Pintu',                    6, 1, 15000),
('P', 'Kunci Pintu Tanam',               6, 1, 85000),
('P', 'Seal Tape',                       9, 1, 3500),
('P', 'Kabel Listrik NYM 2x1.5',         7, 1, 7000),
-- K = keramik & papan
('K', 'Triplek 9mm',                     5, 1, 95000),
('K', 'Papan Gypsum Jayaboard 9mm',      5, 1, 70000),
('K', 'Keramik Arwana 40x40',            8, 1, 65000);
