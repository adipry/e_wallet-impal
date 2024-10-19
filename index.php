<?php

require 'ewallet.php';

$ewallet = new EWallet();

while (true) {
    echo "\nMenu E-Wallet:\n";
    echo "1. Login\n";
    echo "2. Isi Saldo\n";
    echo "3. Cek Saldo Akhir\n";
    echo "4. Transfer Uang\n";
    echo "5. Pembayaran Pulsa\n";
    echo "6. Pembayaran Token Listrik\n";
    echo "7. Pembayaran Tagihan Air\n";
    echo "8. Pembelian Produk\n";
    echo "9. Pembelian Layanan\n";
    echo "10. Pengaturan PIN/Password Proses\n";
    echo "11. Cek Profil\n";
    echo "12. Logout\n";
    echo "13. Exit\n";
    echo "Pilih menu: ";

    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case 1:
            // Menu Login
            echo "Masukkan No Telepon: ";
            $phone = trim(fgets(STDIN));
            echo "Masukkan PIN: ";
            $pin = trim(fgets(STDIN));
            $ewallet->login($phone, $pin);
            break;
            
        case 2:
            // Isi Saldo
            echo "Masukkan jumlah saldo yang ingin diisi: ";
            $amount = trim(fgets(STDIN));
            $ewallet->topUp($amount);
            break;
            
        case 3:
            // Cek Saldo Akhir
            $ewallet->checkBalance();
            break;
            
        case 4:
            // Transfer Uang
            echo "Masukkan nomor telepon penerima: ";
            $recipientPhone = trim(fgets(STDIN));
            echo "Masukkan jumlah uang yang ingin ditransfer: ";
            $transferAmount = trim(fgets(STDIN));
            $ewallet->transfer($recipientPhone, $transferAmount);
            break;
            
        case 5:
            // Pembayaran Pulsa
            echo "Masukkan nomor telepon untuk pulsa: ";
            $phoneNumber = trim(fgets(STDIN));
            echo "Masukkan jumlah pulsa yang ingin dibayar: ";
            $pulsaAmount = trim(fgets(STDIN));
            $ewallet->payPulsa($phoneNumber, $pulsaAmount);
            break;
            
        case 6:
            // Pembayaran Token Listrik
            echo "Masukkan ID pelanggan: ";
            $customerId = trim(fgets(STDIN));
            echo "Masukkan jumlah tagihan: ";
            $tokenAmount = trim(fgets(STDIN));
            $ewallet->payElectricity($customerId, $tokenAmount);
            break;
            
        case 7:
            // Pembayaran Tagihan Air
            echo "Masukkan ID pelanggan: ";
            $customerId = trim(fgets(STDIN));
            echo "Masukkan jumlah tagihan: ";
            $waterBillAmount = trim(fgets(STDIN));
            $ewallet->payWater($customerId, $waterBillAmount);
            break;
            
        case 8:
            // Pembelian Produk
            echo "Masukkan layanan yang ingin dibeli: ";
            $serviceProduct = trim(fgets(STDIN));
            echo "Masukkan detail pembelian: ";
            $productDetails = trim(fgets(STDIN));
            echo "Masukkan jumlah yang harus dibayarkan: ";
            $productAmount = trim(fgets(STDIN));
            $ewallet->purchaseProduct($serviceProduct, $productDetails, $productAmount);
            break;
            
        case 9:
             // Pembelian Layanan
            echo "Masukkan layanan yang ingin dibeli: ";
            $servicePurchase = trim(fgets(STDIN));
            echo "Masukkan detail pembelian: ";
            $serviceDetails = trim(fgets(STDIN));
            echo "Masukkan jumlah yang harus dibayarkan: ";
            $serviceAmount = trim(fgets(STDIN));
            $ewallet->purchaseService($servicePurchase, $serviceDetails, $serviceAmount);
            break;
            
        case 10:
            // Pengaturan PIN/Password Proses
            echo "Masukkan PIN baru: ";
            $newPin = trim(fgets(STDIN));
            // Perlu implementasi untuk mengupdate PIN
            echo "Fitur ini belum diimplementasikan.\n";
            break;
            
        case 11:
            // Cek Profil
            $ewallet->checkProfile();
            break;
            
        case 12:
            // Logout
            $ewallet->logout();
            break;
            
        case 13:
            // Exit
            echo "Terima kasih telah menggunakan E-Wallet. Sampai jumpa!\n";
            exit();
            
            default:
            echo "Pilihan tidak valid. Silakan coba lagi.\n";
            break;
        }
    }
            