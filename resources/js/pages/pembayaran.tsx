import { useState, useEffect } from 'react';
import { usePage, Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

interface Payment {
  id: number;
  bulan: string;
  status: string;
  nominal: string;
  student: {
    nama: string;
  };
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Pembayaran',
    href: '/pembayaran',
  },
];

export default function Payment() {
  const { pembayaran, bulanList, statusList } = usePage<{ 
    pembayaran: Payment[] 
    bulanList: string[] 
    statusList: string[] 
  }>().props;

  const [filteredPayments, setFilteredPayments] = useState<Payment[]>(pembayaran);
  const [selectedBulan, setSelectedBulan] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('');

  // Filter data berdasarkan bulan dan status
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
    <option key={status} value={status}>{status}</option>
  ))}
</select>

          </div>
        </div>

        {/* Tabel Pembayaran */}
        <div className="overflow-x-auto">
          <table className="min-w-full table-auto border border-gray-300 dark:border-neutral-700">
            <thead>
              <tr className="bg-gray-100 dark:bg-neutral-800 text-left">
                <th className="p-3 border">Nama Siswa</th>
                <th className="p-3 border">Bulan</th>
                <th className="p-3 border">Status</th>
                <th className="p-3 border">Nominal</th>
              </tr>
            </thead>
            <tbody>
              {filteredPayments.map((payment) => (
                <tr key={payment.id} className="hover:bg-gray-50 dark:hover:bg-neutral-700">
                  <td className="p-3 border">{payment.student.nama}</td>
                  <td className="p-3 border">{payment.bulan}</td>
                  <td className="p-3 border">{payment.status}</td>
                  <td className="p-3 border">{payment.nominal}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
