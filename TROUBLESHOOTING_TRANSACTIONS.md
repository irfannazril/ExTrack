# 🔧 Troubleshooting - Transactions

## 🚨 Error: Foreign Key Constraint Violation

### Error Message:
```
SQLSTATE[23000]: Integrity constraint violation: 1452 
Cannot add or update a child row: a foreign key constraint fails 
(`extrack`.`transactions`, CONSTRAINT `transactions_ibfk_3` 
FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE)
```

### Penyebab:
- Field `asset_id` di tabel `transactions` tidak boleh NULL
- Ketika edit transaction tipe **transfer**, `asset_id` tidak diisi dengan benar
- Foreign key constraint memerlukan `asset_id` yang valid

### Solusi:
✅ **Sudah diperbaiki!** Update handler untuk mengisi `asset_id` dengan `from_asset_id` pada transaction tipe transfer.

---

## 🐛 Error Lainnya

### "Saldo asset tidak mencukupi!"

**Penyebab:**
- Balance asset kurang dari amount yang akan di-expense
- Balance from_asset kurang dari amount yang akan di-transfer

**Solusi:**
1. Cek balance asset di halaman Assets
2. Tambah balance asset terlebih dahulu
3. Atau kurangi amount transaction

---

### "Asset asal dan tujuan tidak boleh sama!"

**Penyebab:**
- Memilih asset yang sama untuk from_asset dan to_asset pada transfer

**Solusi:**
- Pilih asset yang berbeda untuk transfer

---

### "Transaksi tidak ditemukan!"

**Penyebab:**
- Transaction ID tidak valid
- Transaction sudah dihapus
- Transaction bukan milik user yang login

**Solusi:**
- Refresh halaman
- Cek apakah transaction masih ada

---

### Balance Tidak Sesuai Setelah Edit/Delete

**Penyebab:**
- Error saat revert balance
- Transaction tidak di-commit dengan benar

**Solusi:**
1. **Manual Fix Balance:**
   ```sql
   -- Hitung ulang balance untuk asset tertentu
   UPDATE assets a
   SET balance = (
       SELECT COALESCE(SUM(
           CASE 
               WHEN t.transaction_type = 'income' THEN t.amount
               WHEN t.transaction_type = 'expense' THEN -t.amount
               ELSE 0
           END
       ), 0)
       FROM transactions t
       WHERE t.asset_id = a.asset_id
   )
   WHERE a.asset_id = [ASSET_ID];
   ```

2. **Atau reset balance ke 0 dan input ulang:**
   - Edit asset → set balance = 0
   - Tambah transaction income untuk set balance awal

---

### Transaction Date Tidak Bisa Diubah

**Penyebab:**
- Field date readonly atau disabled

**Solusi:**
- Pastikan field date tidak disabled
- Cek JavaScript yang mungkin block input

---

### Category/Asset Dropdown Kosong

**Penyebab:**
- Belum ada category/asset yang dibuat
- Category/asset sudah dihapus

**Solusi:**
1. Buat category terlebih dahulu di halaman Statistics
2. Buat asset terlebih dahulu di halaman Assets

---

### Filter Transaction Tidak Berfungsi

**Penyebab:**
- URL parameter tidak terbaca
- Query SQL error

**Solusi:**
- Cek URL: `?filter=all`, `?filter=income`, `?filter=expense`, `?filter=transfer`
- Refresh halaman
- Clear browser cache

---

## 📊 Validasi Transaction

### Income
- ✅ Amount > 0
- ✅ Asset dipilih
- ✅ Category dipilih (opsional)
- ✅ Balance asset akan bertambah

### Expense
- ✅ Amount > 0
- ✅ Asset dipilih
- ✅ Category dipilih (opsional)
- ✅ Balance asset cukup
- ✅ Balance asset akan berkurang

### Transfer
- ✅ Amount > 0
- ✅ From Asset dipilih
- ✅ To Asset dipilih
- ✅ From Asset ≠ To Asset
- ✅ Balance from_asset cukup
- ✅ Balance from_asset akan berkurang
- ✅ Balance to_asset akan bertambah

---

## 🔍 Debug Transaction

### Cek Balance Asset
```sql
SELECT asset_id, asset_name, balance 
FROM assets 
WHERE user_id = [USER_ID];
```

### Cek Transaction History
```sql
SELECT 
    t.transaction_id,
    t.transaction_type,
    t.amount,
    t.transaction_date,
    a.asset_name,
    c.category_name
FROM transactions t
LEFT JOIN assets a ON t.asset_id = a.asset_id
LEFT JOIN categories c ON t.category_id = c.category_id
WHERE t.user_id = [USER_ID]
ORDER BY t.transaction_date DESC;
```

### Cek Transfer Transactions
```sql
SELECT 
    t.transaction_id,
    t.amount,
    t.transaction_date,
    fa.asset_name as from_asset,
    ta.asset_name as to_asset
FROM transactions t
LEFT JOIN assets fa ON t.from_asset_id = fa.asset_id
LEFT JOIN assets ta ON t.to_asset_id = ta.asset_id
WHERE t.user_id = [USER_ID] 
AND t.transaction_type = 'transfer'
ORDER BY t.transaction_date DESC;
```

### Recalculate All Balances
```sql
-- Backup dulu!
-- Hitung ulang balance semua asset berdasarkan transactions

UPDATE assets a
SET balance = (
    SELECT COALESCE(
        -- Income
        (SELECT SUM(amount) FROM transactions 
         WHERE asset_id = a.asset_id 
         AND transaction_type = 'income'),
        0
    ) - COALESCE(
        -- Expense
        (SELECT SUM(amount) FROM transactions 
         WHERE asset_id = a.asset_id 
         AND transaction_type = 'expense'),
        0
    ) + COALESCE(
        -- Transfer IN (to_asset)
        (SELECT SUM(amount) FROM transactions 
         WHERE to_asset_id = a.asset_id 
         AND transaction_type = 'transfer'),
        0
    ) - COALESCE(
        -- Transfer OUT (from_asset)
        (SELECT SUM(amount) FROM transactions 
         WHERE from_asset_id = a.asset_id 
         AND transaction_type = 'transfer'),
        0
    )
)
WHERE a.user_id = [USER_ID];
```

---

## ✅ Best Practices

### 1. Backup Sebelum Edit/Delete
- Export database sebelum operasi besar
- Atau catat balance sebelum edit

### 2. Gunakan Transaction Date yang Benar
- Jangan ubah date transaction lama
- Bisa menyebabkan balance history tidak akurat

### 3. Jangan Edit Balance Asset Manual
- Gunakan transaction untuk adjust balance
- Manual edit bisa menyebabkan inconsistency

### 4. Cek Balance Setelah Edit/Delete
- Pastikan balance sesuai setelah operasi
- Jika tidak sesuai, gunakan recalculate query

---

## 📞 Need Help?

Jika masih ada masalah:

1. **Cek error log:**
   - PHP: `C:\xampp\php\logs\php_error_log`
   - Apache: `C:\xampp\apache\logs\error.log`

2. **Enable error display:**
   - Edit `php.ini` → `display_errors = On`
   - Restart Apache

3. **Test dengan data baru:**
   - Buat asset baru
   - Buat transaction baru
   - Lihat apakah error masih terjadi

4. **Contact:**
   - GitHub: [@irfannazril](https://github.com/irfannazril)
   - Email: irfannazrilasdf@gmail.com

---

**Last Updated:** 4 Desember 2025
