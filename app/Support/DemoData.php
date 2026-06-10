<?php

namespace App\Support;

/**
 * Sumber data contoh untuk prototype Wimala Land.
 * Semua statis (tanpa database) supaya prototype langsung jalan.
 * Untuk versi produksi, ganti pemanggilan ini dengan query Model/Eloquent.
 */
class DemoData
{
    public static function units(): array
    {
        return [
            ['code'=>'A-01','cluster'=>'Grand Taman Sari','blok'=>'Blok A No. 01','tipe'=>'36 / 72','lt'=>72,'lb'=>36,'harga'=>520000000,'bayar'=>'-','status'=>'available'],
            ['code'=>'A-02','cluster'=>'Grand Taman Sari','blok'=>'Blok A No. 02','tipe'=>'36 / 72','lt'=>72,'lb'=>36,'harga'=>520000000,'bayar'=>'KPR','status'=>'sold'],
            ['code'=>'A-03','cluster'=>'Grand Taman Sari','blok'=>'Blok A No. 03','tipe'=>'45 / 90','lt'=>90,'lb'=>45,'harga'=>680000000,'bayar'=>'KPR','status'=>'booked'],
            ['code'=>'A-05','cluster'=>'Grand Taman Sari','blok'=>'Blok A No. 05','tipe'=>'45 / 90','lt'=>90,'lb'=>45,'harga'=>680000000,'bayar'=>'Cash','status'=>'done'],
            ['code'=>'A-08','cluster'=>'Grand Taman Sari','blok'=>'Blok A No. 08','tipe'=>'60 / 120','lt'=>120,'lb'=>60,'harga'=>910000000,'bayar'=>'KPR','status'=>'handed'],
            ['code'=>'B-02','cluster'=>'Grand Taman Sari','blok'=>'Blok B No. 02','tipe'=>'36 / 72','lt'=>72,'lb'=>36,'harga'=>495000000,'bayar'=>'-','status'=>'available'],
            ['code'=>'B-04','cluster'=>'Grand Taman Sari','blok'=>'Blok B No. 04','tipe'=>'36 / 72','lt'=>72,'lb'=>36,'harga'=>495000000,'bayar'=>'Cash','status'=>'sold'],
            ['code'=>'B-06','cluster'=>'Grand Taman Sari','blok'=>'Blok B No. 06','tipe'=>'45 / 90','lt'=>90,'lb'=>45,'harga'=>650000000,'bayar'=>'-','status'=>'available'],
            ['code'=>'B-09','cluster'=>'Grand Taman Sari','blok'=>'Blok B No. 09','tipe'=>'45 / 90','lt'=>90,'lb'=>45,'harga'=>650000000,'bayar'=>'KPR','status'=>'booked'],
            ['code'=>'B-11','cluster'=>'Grand Taman Sari','blok'=>'Blok B No. 11','tipe'=>'60 / 120','lt'=>120,'lb'=>60,'harga'=>880000000,'bayar'=>'KPR','status'=>'sold'],
            ['code'=>'C-01','cluster'=>'Puri Dharmawangsa','blok'=>'Blok C No. 01','tipe'=>'36 / 60','lt'=>60,'lb'=>36,'harga'=>430000000,'bayar'=>'-','status'=>'available'],
            ['code'=>'C-03','cluster'=>'Puri Dharmawangsa','blok'=>'Blok C No. 03','tipe'=>'36 / 60','lt'=>60,'lb'=>36,'harga'=>430000000,'bayar'=>'-','status'=>'available'],
            ['code'=>'C-04','cluster'=>'Puri Dharmawangsa','blok'=>'Blok C No. 04','tipe'=>'45 / 84','lt'=>84,'lb'=>45,'harga'=>590000000,'bayar'=>'Cash','status'=>'booked'],
            ['code'=>'C-07','cluster'=>'Puri Dharmawangsa','blok'=>'Blok C No. 07','tipe'=>'45 / 84','lt'=>84,'lb'=>45,'harga'=>590000000,'bayar'=>'KPR','status'=>'handed'],
            ['code'=>'C-10','cluster'=>'Puri Dharmawangsa','blok'=>'Blok C No. 10','tipe'=>'60 / 110','lt'=>110,'lb'=>60,'harga'=>810000000,'bayar'=>'KPR','status'=>'sold'],
        ];
    }

    public static function unit(string $code): ?array
    {
        foreach (self::units() as $u) if ($u['code'] === $code) return $u;
        return null;
    }

    /** Tahapan pipeline. tag: null = semua, kpr = hanya KPR, indent = hanya unit indent */
    public static function stages(): array
    {
        return [
            ['t'=>'Booking','tag'=>null],
            ['t'=>'Verifikasi','tag'=>null],
            ['t'=>'Pengajuan KPR','tag'=>'kpr'],
            ['t'=>'PPJB','tag'=>null],
            ['t'=>'Pembayaran','tag'=>null],
            ['t'=>'Konstruksi','tag'=>'indent'],
            ['t'=>'Serah terima','tag'=>null],
            ['t'=>'AJB','tag'=>null],
        ];
    }

    /** Transaksi (kartu di papan tracking). id = indeks. stage = indeks tahap aktif. */
    public static function transactions(): array
    {
        $rows = [
            ['name'=>'Andi Wijaya','code'=>'A-12','stage'=>0,'pay'=>'KPR','indent'=>true],
            ['name'=>'Rina Hapsari','code'=>'B-15','stage'=>0,'pay'=>'Cash','indent'=>false],
            ['name'=>'Slamet Riyadi','code'=>'C-09','stage'=>1,'pay'=>'KPR','indent'=>false],
            ['name'=>'Dewi Lestari','code'=>'A-03','stage'=>2,'pay'=>'KPR','indent'=>true],
            ['name'=>'Bambang Pratama','code'=>'B-09','stage'=>2,'pay'=>'KPR','indent'=>false],
            ['name'=>'Hendra Gunawan','code'=>'C-12','stage'=>2,'pay'=>'KPR','indent'=>false],
            ['name'=>'Maya Sari','code'=>'A-02','stage'=>3,'pay'=>'KPR','indent'=>true],
            ['name'=>'Joko Susilo','code'=>'B-04','stage'=>4,'pay'=>'Cash','indent'=>false],
            ['name'=>'Putri Anjani','code'=>'C-10','stage'=>4,'pay'=>'KPR','indent'=>true],
            ['name'=>'Agus Salim','code'=>'A-08','stage'=>5,'pay'=>'KPR','indent'=>true],
            ['name'=>'Sri Wahyuni','code'=>'C-07','stage'=>6,'pay'=>'KPR','indent'=>false],
            ['name'=>'Teguh Saputra','code'=>'A-05','stage'=>7,'pay'=>'Cash','indent'=>false],
        ];
        foreach ($rows as $i => &$r) $r['id'] = $i;
        return $rows;
    }

    public static function transaction(int $id): ?array
    {
        $all = self::transactions();
        return $all[$id] ?? null;
    }

    public static function transactionForUnit(string $code): ?array
    {
        foreach (self::transactions() as $t) if ($t['code'] === $code) return $t;
        return null;
    }

    public static function invoices(): array
    {
        return [
            ['no'=>'INV-2406-018','unit'=>'A-02','pembeli'=>'Maya Sari','termin'=>'DP (20%)','jumlah'=>104000000,'jatuh'=>'05 Jun 2026','status'=>'paid'],
            ['no'=>'INV-2406-021','unit'=>'B-11','pembeli'=>'Bambang Pratama','termin'=>'DP (15%)','jumlah'=>132000000,'jatuh'=>'10 Jun 2026','status'=>'due'],
            ['no'=>'INV-2405-009','unit'=>'C-10','pembeli'=>'Putri Anjani','termin'=>'Cicilan ke-3','jumlah'=>45000000,'jatuh'=>'28 Mei 2026','status'=>'late'],
            ['no'=>'INV-2406-024','unit'=>'A-08','pembeli'=>'Agus Salim','termin'=>'Pencairan termin 2','jumlah'=>210000000,'jatuh'=>'12 Jun 2026','status'=>'due'],
            ['no'=>'INV-2406-011','unit'=>'B-04','pembeli'=>'Joko Susilo','termin'=>'Pelunasan','jumlah'=>371250000,'jatuh'=>'02 Jun 2026','status'=>'paid'],
            ['no'=>'INV-2405-016','unit'=>'C-07','pembeli'=>'Sri Wahyuni','termin'=>'DP (20%)','jumlah'=>118000000,'jatuh'=>'25 Mei 2026','status'=>'late'],
            ['no'=>'INV-2406-027','unit'=>'A-05','pembeli'=>'Teguh Saputra','termin'=>'Pelunasan','jumlah'=>476000000,'jatuh'=>'15 Jun 2026','status'=>'due'],
            ['no'=>'INV-2406-006','unit'=>'A-03','pembeli'=>'Dewi Lestari','termin'=>'Booking fee','jumlah'=>5000000,'jatuh'=>'01 Jun 2026','status'=>'paid'],
            ['no'=>'INV-2406-029','unit'=>'C-04','pembeli'=>'Rian Maulana','termin'=>'Cicilan ke-1','jumlah'=>29500000,'jatuh'=>'20 Jun 2026','status'=>'due'],
            ['no'=>'INV-2405-031','unit'=>'B-09','pembeli'=>'Hendra Gunawan','termin'=>'DP (10%)','jumlah'=>65000000,'jatuh'=>'30 Mei 2026','status'=>'late'],
        ];
    }

    public static function tipe(): array
    {
        return [
            ['nama'=>'Tipe 36/72','lt'=>72,'lb'=>36,'kt'=>2,'km'=>1,'harga'=>520000000],
            ['nama'=>'Tipe 45/90','lt'=>90,'lb'=>45,'kt'=>2,'km'=>1,'harga'=>680000000],
            ['nama'=>'Tipe 60/120','lt'=>120,'lb'=>60,'kt'=>3,'km'=>2,'harga'=>910000000],
            ['nama'=>'Tipe 36/60','lt'=>60,'lb'=>36,'kt'=>2,'km'=>1,'harga'=>430000000],
            ['nama'=>'Tipe 45/84','lt'=>84,'lb'=>45,'kt'=>3,'km'=>1,'harga'=>590000000],
        ];
    }

    public static function statusMap(): array
    {
        return [
            'available'=>['Tersedia','bd-available'],
            'booked'   =>['Dibooking','bd-booked'],
            'sold'     =>['Terjual','bd-sold'],
            'handed'   =>['Serah terima','bd-handed'],
            'done'     =>['Selesai','bd-done'],
        ];
    }

    public static function invoiceStatusMap(): array
    {
        return [
            'paid'=>['Lunas','bd-paid'],
            'due' =>['Belum jatuh tempo','bd-due'],
            'late'=>['Terlambat','bd-late'],
        ];
    }

    public static function chart(): array
    {
        return [
            'salesLabels'   => ['Jan','Feb','Mar','Apr','Mei','Jun'],
            'terjual'       => [9,12,11,15,18,17],
            'dibooking'     => [6,8,7,10,9,12],
            'clusterLabels' => ['Grand Taman Sari','Puri Dharmawangsa'],
            'realisasi'     => [54,28],
            'target'        => [70,50],
        ];
    }

    public static function unitTimeline(string $status): array
    {
        $order = [['available','Tersedia'],['booked','Dibooking'],['sold','Terjual'],['handed','Serah terima'],['done','Selesai']];
        $cur = 0;
        foreach ($order as $i => $o) if ($o[0] === $status) $cur = $i;
        $out = [];
        foreach ($order as $i => $o) {
            $state = $i < $cur ? 'done' : ($i === $cur ? 'active' : 'pending');
            $out[] = ['label'=>$o[1],'state'=>$state];
        }
        return $out;
    }

    public static function pipelineStates(array $trx): array
    {
        $out = [];
        foreach (self::stages() as $i => $st) {
            $applicable = !($st['tag'] === 'kpr' && $trx['pay'] !== 'KPR')
                       && !($st['tag'] === 'indent' && ! $trx['indent']);
            if (! $applicable)            $state = 'skip';
            elseif ($i < $trx['stage'])   $state = 'done';
            elseif ($i === $trx['stage']) $state = 'active';
            else                          $state = 'pending';
            $out[] = ['no'=>$i + 1,'label'=>$st['t'],'state'=>$state];
        }
        return $out;
    }

    public static function unitDocs(string $status, string $bayar): array
    {
        $afterBooking = $status !== 'available';
        $afterPpjb    = in_array($status, ['sold','handed','done']);
        $afterBast    = in_array($status, ['handed','done']);
        return [
            ['Surat Pemesanan Rumah (SPR)', $afterBooking],
            ['Scan KTP & NPWP pembeli', $afterBooking],
            ['SP2K', $bayar === 'KPR' && $afterPpjb],
            ['PPJB', $afterPpjb],
            ['BAST', $afterBast],
        ];
    }

    public static function trxSchedule(array $trx): array
    {
        $paid = $trx['stage'] >= 4;
        $rows = [['Booking fee','Rp 5.000.000','Lunas','bd-done']];
        if ($trx['pay'] === 'KPR') {
            $rows[] = ['DP (15%)','Rp 102.000.000', $paid ? 'Lunas' : 'Belum bayar', $paid ? 'bd-done' : 'bd-due'];
            $rows[] = ['Pencairan bank','Rp 578.000.000', $trx['stage'] >= 5 ? 'Sebagian' : 'Menunggu','bd-due'];
        } else {
            $rows[] = ['DP (20%)','Rp 136.000.000', $paid ? 'Lunas' : 'Belum bayar', $paid ? 'bd-done' : 'bd-due'];
            $rows[] = ['Pelunasan','Rp 544.000.000', $paid ? 'Cicilan berjalan' : 'Menunggu','bd-due'];
        }
        return $rows;
    }

    public static function trxDocs(array $trx): array
    {
        return [
            ['SPR', true],
            ['SP2K', $trx['pay'] === 'KPR' && $trx['stage'] >= 3],
            ['PPJB', $trx['stage'] >= 4],
            ['BAST', $trx['stage'] >= 7],
        ];
    }

    public static function rupiah(int $n): string
    {
        return 'Rp ' . number_format($n, 0, ',', '.');
    }
}
