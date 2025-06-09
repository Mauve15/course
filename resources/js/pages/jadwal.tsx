import { usePage, Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

interface Jadwal {
  id: number;
  kelompok: {
    nama_kelompok: string;
    hari: string;
    jam_mulai: number;   // ganti 'integer' ke 'number'
    jam_selesai: number; // ganti 'integer' ke 'number'
  } | null;
  pengajar_user: {      // sesuaikan ini dengan snake_case dari backend
    name: string;
  } | null;
  materi: string;
}



const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Jadwal',
    href: '/jadwal',
  },
];

export default function Jadwal() {
  const { jadwals } = usePage<{ jadwals: Jadwal[] }>().props;

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Data Jadwal" />

      <div className="p-6">
        <h1 className="text-2xl font-bold mb-4">Daftar Jadwal</h1>
        <div className="overflow-x-auto">
          <table className="min-w-full table-auto border border-gray-300 dark:border-neutral-700">
            <thead>
              <tr className="bg-gray-100 dark:bg-neutral-800 text-left">
                <th className="p-3 border">Kelompok</th>
                <th className="p-3 border">Materi</th>
                <th className="p-3 border">Guru</th>
                <th className="p-3 border">Hari</th>
                <th className="p-3 border">Jam Mulai</th>
                <th className="p-3 border">Jam Selesai</th>
              </tr>
            </thead>
            <tbody>
              {jadwals.map((jadwal) => (
                <tr key={jadwal.id} className="hover:bg-gray-50 dark:hover:bg-neutral-700">
                  <td className="p-3 border">{jadwal.kelompok?.nama_kelompok || '-'}</td>
                  <td className="p-3 border">{jadwal.materi || '-'}</td>
                  <td className="p-3 border">{jadwal.pengajar_user?.name || '-'}</td>
                  <td className="p-3 border">{jadwal.kelompok?.hari || '-'}</td>
                  <td className="p-3 border">{jadwal.kelompok?.jam_mulai || '-'}</td>
                  <td className="p-3 border">{jadwal.kelompok?.jam_selesai || '-'}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  );
}
