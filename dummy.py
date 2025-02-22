import os

path = "uploads"

# Cek apakah folder sudah ada, jika tidak buat baru
if not os.path.exists(path):
    os.makedirs(path)

print(f"Folder '{path}' siap digunakan!")

