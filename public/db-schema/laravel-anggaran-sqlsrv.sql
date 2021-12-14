CREATE TABLE [role] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [level] varchar(64) UNIQUE,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [divisi] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [nama_divisi] varchar(128) UNIQUE,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [user] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [role_id] bigint,
  [divisi_id] bigint,
  [username] varchar(128) UNIQUE,
  [password] nvarchar(255),
  [active] tinyint,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [profil] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [user_id] bigint,
  [avatar] varchar(128),
  [nama_lengkap] varchar(128),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [budget] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [divisi_id] bigint,
  [tahun_anggaran] year,
  [nominal] double,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [transaksi] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [user_id] bigint,
  [divisi_id] bigint,
  [kegiatan] varchar(128),
  [tanggal] date,
  [jumlah] double,
  [approval] varchar(128),
  [no_dokumen] varchar(64),
  [file_dokumen] varchar(200),
  [uraian] text,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

ALTER TABLE [user] ADD FOREIGN KEY ([role_id]) REFERENCES [role] ([id])
GO

ALTER TABLE [user] ADD FOREIGN KEY ([divisi_id]) REFERENCES [divisi] ([id])
GO

ALTER TABLE [profil] ADD FOREIGN KEY ([user_id]) REFERENCES [user] ([id])
GO

ALTER TABLE [budget] ADD FOREIGN KEY ([divisi_id]) REFERENCES [divisi] ([id])
GO

ALTER TABLE [transaksi] ADD FOREIGN KEY ([divisi_id]) REFERENCES [divisi] ([id])
GO

ALTER TABLE [transaksi] ADD FOREIGN KEY ([user_id]) REFERENCES [user] ([id])
GO
