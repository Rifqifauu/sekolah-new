<x-filament-panels::page>
    @php
        // 1. Ekstrak nama komponen dan bobot persentasenya
        $allComponents = collect();
        foreach($subjectsData as $grades) {
            foreach($grades as $grade) {
                $componentName = $grade->gradeComponent->name;
                $componentWeight = $grade->gradeComponent->weight ?? 0;

                // Simpan dalam bentuk array asosiatif: ['Tugas' => 30, 'PTS' => 30, dst]
                if(!$allComponents->has($componentName)) {
                    $allComponents->put($componentName, $componentWeight);
                }
            }
        }

        // 2. Hitung Rata-Rata Keseluruhan (Tetap menggunakan nilai akhir / score)
        $totalKeseluruhanAkhir = 0;
        foreach($subjectsData as $grades) {
            $totalKeseluruhanAkhir += $grades->sum('score');
        }
        $jumlahMapel = $subjectsData->count();
        $rataRataTotal = $jumlahMapel > 0 ? ($totalKeseluruhanAkhir / $jumlahMapel) : 0;
    @endphp

    <style>
        /* Container Rapor - Standar Dokumen Resmi */
        .rapor-formal-container {
            background-color: #ffffff;
            color: #000000;
            padding: 40px;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            max-width: 100%;
            margin: 0 auto;
        }

        /* Header Dokumen */
        .rapor-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000000;
            padding-bottom: 15px;
        }
        .rapor-header h2 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
        }
        .rapor-header p {
            font-size: 12pt;
            margin: 0;
        }

        /* Identitas Peserta Didik */
        .identitas-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .identitas-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .label-identitas {
            width: 160px;
        }
        .titik-dua {
            width: 20px;
            text-align: center;
        }

        /* Tabel Nilai Utama */
        .rapor-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .rapor-table th,
        .rapor-table td {
            border: 1px solid #000000;
            padding: 8px 10px;
        }
        .rapor-table th {
            background-color: #e5e5e5;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10pt;
            vertical-align: middle;
        }

        /* Gaya khusus untuk persentase di header tabel */
        .persentase-label {
            font-size: 9pt;
            font-weight: normal;
            display: block;
            margin-top: 3px;
        }

        .rapor-table td {
            vertical-align: middle;
        }

        /* Baris Rata-Rata di Bawah */
        .rapor-table tfoot td {
            background-color: #e5e5e5;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }

        /* Container Bawah (Absensi & Peringkat) */
        .bottom-section {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .bottom-col {
            display: table-cell;
            vertical-align: top;
        }

        /* Tabel Absensi */
        .absensi-table {
            width: 350px;
            border-collapse: collapse;
        }
        .absensi-table th {
            background-color: #e5e5e5;
            border: 1px solid #000000;
            padding: 6px;
            text-align: left;
            font-size: 11pt;
        }
        .absensi-table td {
            border: 1px solid #000000;
            padding: 6px 10px;
            font-size: 11pt;
        }

        /* Kotak Peringkat */
        .rank-box {
            border: 1px solid #000000;
            text-align: center;
            padding: 15px;
            width: 200px;
            float: right;
        }
        .rank-box-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11pt;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .rank-box-value {
            font-size: 18pt;
            font-weight: bold;
        }
        .rank-box-desc {
            font-size: 10pt;
            margin-top: 5px;
        }

        /* Tanda Tangan */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 30px;
        }
        .signature-table td {
            width: 50%;
            vertical-align: bottom;
            padding-top: 20px;
        }
        .signature-date {
            margin-bottom: 10px;
        }
        .signature-space {
            height: 80px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Optimasi Cetak */
        @media print {
            .rapor-formal-container { padding: 0; }
            .rapor-table th,
            .rapor-table tfoot td,
            .absensi-table th {
                background-color: #e5e5e5 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="rapor-formal-container">

        <div class="rapor-header">
            <h2>Laporan Hasil Belajar Peserta Didik</h2>
            <p>Tahun Pelajaran {{ $report->academicPeriod->year }} - Semester {{ $report->academicPeriod->semester === 'odd' ? 'Ganjil' : 'Genap' }}</p>
        </div>

        <table class="identitas-table">
            <tr>
                <td class="label-identitas">Nama Peserta Didik</td>
                <td class="titik-dua">:</td>
                <td class="text-bold" style="text-transform: uppercase;">{{ $report->student->name }}</td>
            </tr>
            <tr>
            <td class="label-identitas">Wali Kelas</td>
            <td class="titik-dua">:</td>
            <td>{{ $report->teacher->name ?? '-' }}</td>
            </tr>
        </table>

        <table class="rapor-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%;">No</th>
                    <th rowspan="2" style="width: 25%;">Mata Pelajaran</th>

                    <th colspan="{{ $allComponents->count() }}">Rincian Komponen Nilai</th>

                    <th rowspan="2" style="width: 15%;">Nilai Akhir</th>
                </tr>
                <tr>
                    @foreach($allComponents as $componentName => $weight)
                        <th>
                            {{ $componentName }}
                            <span class="persentase-label">({{ $weight }}%)</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($subjectsData as $subjectName => $gradesCollection)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $subjectName }}</td>

                        @foreach($allComponents as $componentName => $weight)
                            @php
                                $gradeRecord = $gradesCollection->firstWhere('gradeComponent.name', $componentName);
                            @endphp
                            <td class="text-center">
                                {{ $gradeRecord ? $gradeRecord->original_score : '-' }}
                            </td>
                        @endforeach

                        <td class="text-center text-bold">
                            {{ number_format($gradesCollection->sum('score'), 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="{{ 2 + $allComponents->count() }}" class="text-right" style="padding-right: 15px;">
                        Rata-Rata Keseluruhan
                    </td>
                    <td class="text-center text-bold">
                        {{ number_format($rataRataTotal, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="bottom-section">
            <div class="bottom-col">
                <table class="absensi-table">
                    <thead>
                        <tr>
                            <th colspan="2">Ketidakhadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="width: 60%;">Sakit</td><td class="text-center">{{ $attendance['sick'] }} hari</td></tr>
                        <tr><td>Izin</td><td class="text-center">{{ $attendance['permission'] }} hari</td></tr>
                        <tr><td>Tanpa Keterangan</td><td class="text-center">{{ $attendance['absent'] }} hari</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="bottom-col">
                <div class="rank-box">
                    <div class="rank-box-title">Peringkat Kelas</div>
                    <div class="rank-box-value">Ke-{{ $rank }}</div>
                    <div class="rank-box-desc">dari {{ $totalStudents }} peserta didik</div>
                </div>
            </div>
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    <strong>Orang Tua/Wali</strong>
                    <div class="signature-space"></div>
                    <span class="signature-name">...................................................</span>
                </td>
                <td>
                    <strong>Wali Kelas</strong>
                    <div class="signature-space"></div>
                    <span class="signature-name">{{ $report->teacher->name ?? '.....................................' }}</span><br>
                    <span>NIP. ........................................</span>
                </td>
            </tr>
        </table>

    </div>
</x-filament-panels::page>
