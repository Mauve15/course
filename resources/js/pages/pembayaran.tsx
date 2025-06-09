import { useState, useEffect } from 'react';
import { usePage, Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

interface Payment {
  id: number;
  bulan: string; // sudah nama bulan, contoh: 'Juni'
  status: string;
  nominal: string;
  student: {
    nama: string;
  };
  created_at: string;
  // keterangan: string | null;
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Pembayaran',
    href: '/pembayaran',
  },
];

export default function Payment() {
  const { pembayaran, bulanList, statusList } = usePage<{
    pembayaran: Payment[];
    bulanList: string[];
    statusList: string[];
  }>().props;

  const [filteredPayments, setFilteredPayments] = useState<Payment[]>(pembayaran);
  const [selectedBulan, setSelectedBulan] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('');

  useEffect(() => {
    let filtered = pembayaran;

    if (selectedBulan) {
      filtered = filtered.filter((payment) => payment.bulan === selectedBulan);
    }

    if (selectedStatus) {
      filtered = filtered.filter((payment) => payment.status === selectedStatus);
    }

    setFilteredPayments(filtered);
  }, [selectedBulan, selectedStatus, pembayaran]);

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Data Pembayaran" />

      <div className="p-6">
        <h1 className="text-2xl font-bold mb-4">Daftar Pembayaran</h1>

        {/* Filter */}
        <div className="flex gap-4 mb-4">
          <div>
            <label htmlFor="bulan" className="block text-sm font-medium">Bulan</label>
            <select
              id="bulan"
              value={selectedBulan}
              onChange={(e) => setSelectedBulan(e.target.value)}
              className="mt-1 block w-full"
            >
              <option value="">Pilih Bulan</option>
              {bulanList.map((bulan) => (
                <option key={bulan} value={bulan}>{bulan}</option>
              ))}
            </select>
          </div>

          <div>
            <label htmlFor="status" className="block text-sm font-medium">Status</label>
            <select
              id="status"
              value={selectedStatus}
              onChange={(e) => setSelectedStatus(e.target.value)}
              className="mt-1 block w-full"
            >
              <option value="">Pilih Status</option>
              {statusList.map((status) => (
                <option key={status} value={status}>{status === 'lunas' ? 'Lunas' : 'Belum Lunas'}</option>
              ))}
            </select>
          </div>
        </div>

        {/* Table */}
        <table className="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr>
              <th className="border border-gray-300 p-2">No</th>
              <th className="border border-gray-300 p-2">Siswa</th>
              <th className="border border-gray-300 p-2">Bulan</th>
              <th className="border border-gray-300 p-2">Nominal</th>
              <th className="border border-gray-300 p-2">Status</th>
              <th className="border border-gray-300 p-2">Tanggal Bayar</th>
              {/* <th className="border border-gray-300 p-2">Keterangan</th> */}
            </tr>
          </thead>
          <tbody>
            {filteredPayments.length === 0 && (
              <tr>
                <td colSpan={6} className="text-center p-4">Tidak ada data pembayaran.</td>
              </tr>
            )}
            {filteredPayments.map((p, i) => (
              <tr key={p.id} className="text-center">
                <td className="border border-gray-300 p-2">{i + 1}</td>
                <td className="border border-gray-300 p-2">{p.student.nama}</td>
                <td className="border border-gray-300 p-2">{p.bulan}</td>
                <td className="border border-gray-300 p-2">Rp{Number(p.nominal).toLocaleString('id-ID')}</td>
                <td className="border border-gray-300 p-2">{p.status === 'lunas' ? 'Lunas' : 'Belum Lunas'}</td>
                <td className="border border-gray-300 p-2">{new Date(p.created_at).toLocaleDateString()}</td>
                {/* <td className="border border-gray-300 p-2">{p.keterangan ?? '-'}</td> */}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </AppLayout>
  );
}
