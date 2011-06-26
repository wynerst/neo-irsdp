Lapor_Tabel_02:
Judul: IRSDP Fund Disburstment Progress Status per Contract

SELECT SUBSTR( p.pin, 1, 2 ), p.pin, p.nama, prs.nama AS 'Consultant Firm', kons.tahapan, pf.status,
 SUM( tb.nilai_rupiah ) AS 'Contract_IDR', SUM( tb.nilai_dollar ) AS 'Contract_USD',
 SUM( per.eq_rupiah) AS 'USD Equiv',
 SUM( per.nilai_disetujui_rupiah ) AS 'Appr_IDR', SUM( per.nilai_disetujui_dollar ) AS 'Appr_USD',
 kf.kegiatan, kf.status
FROM project_profile AS p
LEFT JOIN kontraktor AS kons ON p.idproject_profile = kons.idproject_profile
LEFT JOIN proj_flow AS pf ON p.idproject_profile = pf.idproject_profile
LEFT JOIN kontrak_flow AS kf ON pf.idproj_flow = kf.idproj_flow
LEFT JOIN perusahaan AS prs ON kons.idperusahaan = prs.idperusahaan
LEFT JOIN termin_bayar AS tb ON kf.idkontrak_flow = tb.kontrakflow_id
LEFT JOIN permohonan AS per ON tb.idtermin_bayar = per.idtermin_bayar
GROUP BY SUBSTR( p.pin, 1, 2 ), p.pin, p.nama
ORDER BY p.pin ASc, p.nama ASC, per.tgl_permohonan DESC

Lapor_Tabel_03:
Judul: Recapitulation of Disbursment Progress of IRSDP per Fund Source
Loan 2264-INO(SF) and Grant 0064-INO

SELECT l.catatan AS 'Project Component', l.category1 AS 'CAT', 
 SUM( tb.nilai_rupiah ) AS 'Contract_IDR', SUM( tb.nilai_dollar ) AS 'Contract_USD',
 SUM( per.eq_rupiah) AS 'USD Equiv',
 SUM( per.nilai_disetujui_rupiah ) AS 'Appr_IDR', SUM( per.nilai_disetujui_dollar ) AS 'Appr_USD',
 kf.kegiatan, kf.status
FROM project_profile AS p
LEFT JOIN kontraktor AS kons ON p.idproject_profile = kons.idproject_profile
LEFT JOIN proj_flow AS pf ON p.idproject_profile = pf.idproject_profile
LEFT JOIN kontrak_flow AS kf ON pf.idproj_flow = kf.idproj_flow
LEFT JOIN perusahaan AS prs ON kons.idperusahaan = prs.idperusahaan
LEFT JOIN termin_bayar AS tb ON kf.idkontrak_flow = tb.kontrakflow_id
LEFT JOIN permohonan AS per ON tb.idtermin_bayar = per.idtermin_bayar
LEFT JOIN loan AS l ON SUBSTR( p.pin, 1, 2 ) = l.kategori
GROUP BY l.category1
ORDER BY l.category1

Lapor_Tabel_04:
Judul: Status of Realization DIPA IRSDP

Lapor Format_D:
Judul: Progress Report of PDF - IRSDP Disbursment
