USE db_gudang_bangunan;

-- satuan aktif (simple view)
CREATE OR REPLACE VIEW v_satuan_aktif AS
SELECT idsatuan, nama_satuan, status
FROM satuan
WHERE status = 1
WITH CHECK OPTION;

-- user tanpa password (simple view)
CREATE OR REPLACE VIEW v_user_aman AS
SELECT iduser, username, idrole
FROM user;

-- vendor aktif (simple view)
CREATE OR REPLACE VIEW v_vendor_aktif (id_vendor, nama_vendor, badan_hukum, status) AS
SELECT idvendor, nama_vendor, badan_hukum, status
FROM vendor
WHERE status = 'A';

-- barang + satuan + label (complex view)
CREATE OR REPLACE VIEW v_barang_detail AS
SELECT b.idbarang,
       b.nama,
       b.jenis,
       CASE b.jenis
            WHEN 'S' THEN 'Material dasar'
            WHEN 'B' THEN 'Besi & pipa'
            WHEN 'C' THEN 'Cat & pelapis'
            WHEN 'P' THEN 'Perlengkapan'
            WHEN 'K' THEN 'Keramik & papan'
       END AS nama_jenis,
       s.idsatuan,
       s.nama_satuan,
       b.harga,
       b.status,
       IF(b.status = 1, 'Aktif', 'Nonaktif') AS status_text
FROM barang b
JOIN satuan s ON b.idsatuan = s.idsatuan;

-- user + role (complex view)
CREATE OR REPLACE VIEW v_user_role AS
SELECT u.iduser, u.username, r.idrole, r.nama_role
FROM user u
JOIN role r ON u.idrole = r.idrole;

-- margin + user pembuat (complex view)
CREATE OR REPLACE VIEW v_margin_detail AS
SELECT m.idmargin_penjualan,
       m.persen,
       m.status,
       IF(m.status = 1, 'Aktif', 'Nonaktif') AS status_text,
       u.username AS dibuat_oleh,
       m.created_at,
       m.updated_at
FROM margin_penjualan m
JOIN user u ON m.iduser = u.iduser;

-- Complex view dengan fungsi group
CREATE OR REPLACE VIEW v_ringkasan_satuan
    (nama_satuan, jumlah_barang, harga_min, harga_max, harga_rata) AS
SELECT s.nama_satuan,
       COUNT(b.idbarang),
       MIN(b.harga),
       MAX(b.harga),
       ROUND(AVG(b.harga))
FROM satuan s
LEFT JOIN barang b ON s.idsatuan = b.idsatuan
GROUP BY s.idsatuan, s.nama_satuan;

-- View
CREATE OR REPLACE VIEW v_barang_di_atas_rata AS
SELECT idbarang, nama, harga
FROM barang
WHERE harga > (SELECT AVG(harga) FROM barang);
