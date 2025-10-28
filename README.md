# Tugas Pemrograman Basis Data


## Cara menjalakan aplikasi

1. clone repository
    ```
    git clone https://github.com/hadigun007-projects/411241111_Hadi-Gunawan.git
    cd 411241111_Hadi-Gunawan
    ```
2. install depedensi
    ```
    composer install
    ```
3. copy dan update .env
    ```
    cp .env.example .env
    # update konfigurasi database
    ```
4. jalankan migrasi dan seed
    ```
    php artisan migrate --seed
    ```
5. jalankan aplikasi
    ```
    php artisan serve
    ```


## 1. Table query

1. `411241111_hadi`.t_pelanggan definition
```
-- `411241111_hadi`.t_pelanggan definition

CREATE TABLE `t_pelanggan` (
  `id_pelanggan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

2. `411241111_hadi`.t_pelanggan definition

```
-- `411241111_hadi`.t_transaksi definition

CREATE TABLE `t_transaksi` (
  `id_transaksi` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pelanggan` bigint unsigned NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_transaksi` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `t_transaksi_id_pelanggan_foreign` (`id_pelanggan`),
  CONSTRAINT `t_transaksi_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `t_pelanggan` (`id_pelanggan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```


## 2. Table query
1. `411241111_hadi`.t_pelanggan insert query
```sql
INSERT INTO `411241111_hadi`.t_pelanggan (nama_pelanggan,email,no_hp,alamat,created_at,updated_at) VALUES
	 ('Diana ','rmarpaung@example.org','08945480622','Jr. Bawal No. 773, Bima 83940, Kalbar','2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 ('Natalia Shania Hassanah S.H.','nlailasari@example.org','08260021368','Ki. Rajiman No. 492, Probolinggo 98553, Sulbar','2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 ('ucup','pratama.gangsa@example.com','08300306415','Dk. Sugiyopranoto No. 12, Tual 26922, DKI','2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 ('Ina Laksita','mulya28@example.org','08930760130','Jr. Abdul Rahmat No. 516, Palangka Raya 95614, Sulut','2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 ('Maya Gawati Laksmiwati S.E.I','eka22@example.org','08885627366','Kpg. Basmol Raya No. 925, Bandung 35105, Jabar','2025-10-23 15:39:39','2025-10-23 15:39:39');
```

1. `411241111_hadi`.t_transaksi insert query
```sql
INSERT INTO `411241111_hadi`.t_transaksi (id_pelanggan,tanggal_transaksi,total_transaksi,created_at,updated_at) VALUES
	 (1,'2025-01-11',1531438,'2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 (2,'2025-05-16',2442279,'2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 (2,'2025-09-13',3795469,'2025-10-23 15:39:39','2025-10-23 15:39:39'),
	 (3,'2025-10-03',8888,NULL,NULL),
	 (4,'2025-10-03',1234567,NULL,NULL),
	 (4,'2025-10-28',565656,NULL,NULL),
	 (1,'2025-10-04',2222,NULL,NULL),
	 (2,'2025-10-11',345678,NULL,NULL);
```

## 3. Join Data
```sql
SELECT 
    t.id_transaksi,
    t.id_pelanggan,
    t.tanggal_transaksi,
    t.total_transaksi,
    p.nama_pelanggan,
    p.email,
    p.no_hp
FROM t_transaksi AS t
INNER JOIN t_pelanggan AS p 
    ON p.id_pelanggan = t.id_pelanggan
ORDER BY t.id_pelanggan;
```

## 4. Pembaharuan Data
1. Update jumlah transaksi id = 2 menjadi 1.500.00
```sql
UPDATE t_transaksi
SET total_transaksi = 1500000
WHERE id_transaksi = 2;
```
2. Delete pelanggan yang belum punya tranksasi
```sql
DELETE p
FROM t_pelanggan AS p
LEFT JOIN t_transaksi AS t ON p.id_pelanggan = t.id_pelanggan
WHERE t.id_transaksi IS NULL;
```
