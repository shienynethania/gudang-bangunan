CREATE DATABASE db_gudang_bangunan;
USE db_gudang_bangunan;

CREATE TABLE role (
  idrole INT AUTO_INCREMENT PRIMARY KEY,
  nama_role VARCHAR(100)
);

CREATE TABLE user (
  iduser INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(45),
  password VARCHAR(100),
  idrole INT NOT NULL,
  FOREIGN KEY (idrole) REFERENCES role(idrole)
);

CREATE TABLE satuan (
  idsatuan INT AUTO_INCREMENT PRIMARY KEY,
  nama_satuan VARCHAR(45),
  status TINYINT
);

CREATE TABLE vendor (
  idvendor INT AUTO_INCREMENT PRIMARY KEY,
  nama_vendor VARCHAR(100),
  badan_hukum CHAR(1),
  status CHAR(1)
);

CREATE TABLE barang (
  idbarang INT AUTO_INCREMENT PRIMARY KEY,
  jenis CHAR(1),
  nama VARCHAR(45),
  idsatuan INT NOT NULL,
  status TINYINT,
  harga INT,
  FOREIGN KEY (idsatuan) REFERENCES satuan(idsatuan)
);

CREATE TABLE margin_penjualan (
  idmargin_penjualan INT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  persen DOUBLE,
  status TINYINT,
  iduser INT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE pengadaan (
  idpengadaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  user_iduser INT NOT NULL,
  status CHAR(1),
  vendor_idvendor INT NOT NULL,
  subtotal_nilai INT,
  ppn INT,
  total_nilai INT,
  FOREIGN KEY (user_iduser) REFERENCES user(iduser),
  FOREIGN KEY (vendor_idvendor) REFERENCES vendor(idvendor)
);

CREATE TABLE detail_pengadaan (
  iddetail_pengadaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  harga_satuan INT,
  jumlah INT,
  sub_total INT,
  idbarang INT NOT NULL,
  idpengadaan BIGINT NOT NULL,
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang),
  FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan)
);

CREATE TABLE penerimaan (
  idpenerimaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status CHAR(1),
  idpengadaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan),
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_penerimaan (
  iddetail_penerimaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  idpenerimaan BIGINT NOT NULL,
  barang_idbarang INT NOT NULL,
  jumlah_terima INT,
  harga_satuan_terima INT,
  sub_total_terima INT,
  FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  FOREIGN KEY (barang_idbarang) REFERENCES barang(idbarang)
);

CREATE TABLE retur (
  idretur BIGINT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  idpenerimaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  FOREIGN KEY (iduser) REFERENCES user(iduser)
);

CREATE TABLE detail_retur (
  iddetail_retur INT AUTO_INCREMENT PRIMARY KEY,
  jumlah INT,
  alasan VARCHAR(200),
  idretur BIGINT NOT NULL,
  iddetail_penerimaan BIGINT NOT NULL,
  FOREIGN KEY (idretur) REFERENCES retur(idretur),
  FOREIGN KEY (iddetail_penerimaan) REFERENCES detail_penerimaan(iddetail_penerimaan)
);

CREATE TABLE penjualan (
  idpenjualan INT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  subtotal_nilai INT,
  ppn INT,
  total_nilai INT,
  iduser INT NOT NULL,
  idmargin_penjualan INT NOT NULL,
  FOREIGN KEY (iduser) REFERENCES user(iduser),
  FOREIGN KEY (idmargin_penjualan) REFERENCES margin_penjualan(idmargin_penjualan)
);


CREATE TABLE detail_penjualan (
  iddetail_penjualan BIGINT AUTO_INCREMENT PRIMARY KEY,
  harga_satuan INT,
  jumlah INT,
  subtotal INT,
  penjualan_idpenjualan INT NOT NULL,
  idbarang INT NOT NULL,
  FOREIGN KEY (penjualan_idpenjualan) REFERENCES penjualan(idpenjualan),
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
);


CREATE TABLE kartu_stok (
  idkartu_stok BIGINT AUTO_INCREMENT PRIMARY KEY,
  jenis_transaksi CHAR(1),  -- P=penerimaan, R=retur, J=penjualan
  masuk INT,
  keluar INT,
  stok INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  idtransaksi INT,
  idbarang INT NOT NULL,
  FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
);
