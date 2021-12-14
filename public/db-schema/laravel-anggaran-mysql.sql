CREATE TABLE `role` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `level` varchar(64) UNIQUE,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `divisi` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nama_divisi` varchar(128) UNIQUE,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `user` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `role_id` bigint,
  `divisi_id` bigint,
  `username` varchar(128) UNIQUE,
  `password` varchar(255),
  `active` tinyint,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `profil` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint,
  `avatar` varchar(128),
  `nama_lengkap` varchar(128),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `budget` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `divisi_id` bigint,
  `tahun_anggaran` year,
  `nominal` double,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `transaksi` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint,
  `divisi_id` bigint,
  `kegiatan` varchar(128),
  `tanggal` date,
  `jumlah` double,
  `approval` varchar(128),
  `no_dokumen` varchar(64),
  `file_dokumen` varchar(200),
  `uraian` text,
  `created_at` timestamp,
  `updated_at` timestamp
);

ALTER TABLE `user` ADD FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

ALTER TABLE `user` ADD FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

ALTER TABLE `profil` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `budget` ADD FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

ALTER TABLE `transaksi` ADD FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`);

ALTER TABLE `transaksi` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
