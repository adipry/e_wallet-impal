<?php

require 'db.php';

class EWallet {
    private $userId;

    public function login($phone, $pin) {
        $user = getUserByPhone($phone);
        if ($user && password_verify($pin, $user['pin'])) {
            $this->userId = $user['id'];
            echo "Login berhasil!\n";
            return true;
        }
        echo "Login gagal. Periksa nomor telepon dan PIN.\n";
        return false;
    }

    public function logout() {
        $this->userId = null;
        echo "Logout berhasil!\n";
    }

    public function topUp($amount) {
        if ($this->userId) {
            updateUserBalance($this->userId, $amount);
            addTransaction($this->userId, 'topup', $amount);
            echo "Isi saldo sebesar Rp. $amount berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan top-up.\n";
        }
    }

    public function checkBalance() {
        if ($this->userId) {
            $balance = getUserBalance($this->userId);
            echo "Saldo Anda saat ini: Rp. $balance\n";
        } else {
            echo "Anda harus login untuk mengecek saldo.\n";
        }
    }

    public function transfer($recipientPhone, $amount) {
        if ($this->userId) {
            $balance = getUserBalance($this->userId);
            if ($balance >= $amount) {
                if (transferMoney($this->userId, $recipientPhone, $amount)) {
                    echo "Transfer Rp. $amount ke $recipientPhone berhasil.\n";
                } else {
                    echo "Transfer gagal. Penerima tidak ditemukan.\n";
                }
            } else {
                echo "Saldo tidak cukup untuk transfer.\n";
            }
        } else {
            echo "Anda harus login untuk melakukan transfer.\n";
        }
    }

    public function payPulsa($phone, $amount) {
        if ($this->userId) {
            $this->topUp(-$amount); // Assuming payment reduces balance
            echo "Pembayaran pulsa Rp. $amount untuk nomor $phone berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan pembayaran pulsa.\n";
        }
    }

    public function payElectricity($customerId, $amount) {
        if ($this->userId) {
            $this->topUp(-$amount);
            echo "Pembayaran token listrik untuk ID pelanggan $customerId sebesar Rp. $amount berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan pembayaran.\n";
        }
    }

    public function payWater($customerId, $amount) {
        if ($this->userId) {
            $this->topUp(-$amount);
            echo "Pembayaran tagihan air untuk ID pelanggan $customerId sebesar Rp. $amount berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan pembayaran.\n";
        }
    }

    public function purchaseProduct($service, $details, $amount) {
        if ($this->userId) {
            $this->topUp(-$amount);
            echo "Pembelian produk ($service): $details sebesar Rp. $amount berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan pembelian.\n";
        }
    }

    public function purchaseService($service, $details, $amount) {
        if ($this->userId) {
            $this->topUp(-$amount);
            echo "Pembelian layanan ($service): $details sebesar Rp. $amount berhasil.\n";
        } else {
            echo "Anda harus login untuk melakukan pembelian.\n";
        }
    }

    public function checkProfile() {
        if ($this->userId) {
            $user = getUserByPhone($this->userId);
            echo "Profil Anda:\n";
            echo "No Telepon: {$user['phone']}\n";
            echo "Alamat: {$user['address']}\n";
            echo "Email: {$user['email']}\n";
        } else {
            echo "Anda harus login untuk melihat profil.\n";
        }
    }
}

?>
