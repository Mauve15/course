import { usePage, Head } from '@inertiajs/react';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

interface Student {
  id: number;
  nama: string;
  tempat: string;
  tanggal_lahir: string;
  kelas: string;
  asal_sekolah: string;
  kelompok: {
    nama_kelompok: string;
  } | null;
}

interface Props {
  students: Student[];
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Student',
    href: '/student',
  },
];

export default function Student() {
  // Pastikan tipe yang digunakan sesuai dengan Props yang diharapkan
  const { props } = usePage<{ students: Student[] }>();  // <-- Menggunakan tipe langsung pada usePage
  const { students } = props;

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Data Siswa" />

      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        {/* Placeholder Cards */}
        <div className="grid auto-rows-min gap-4 md:grid-cols-3">
          {[1, 2, 3].map((i) => (
            <div
              key={i}
              className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border"
            >
              <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
            </div>
          ))}
        </div>

        {/* Student Table */}
        <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
          <div className="p-6">
            <h1 className="text-2xl font-bold mb-4">Daftar Siswa</h1>
            <div className="overflow-x-auto">
              <table className="min-w-full table-auto border border-gray-300 dark:border-neutral-700">
                <thead>
                  <tr className="bg-gray-100 dark:bg-neutral-800 text-left">
                    <th className="p-3 border">Nama</th>
                    <th className="p-3 border">Tempat, Tanggal Lahir</th>
                    <th className="p-3 border">Kelas</th>
                    <th className="p-3 border">Kelompok</th>
                    <th className="p-3 border">Asal Sekolah</th>
                  </tr>
                </thead>
                <tbody>
                  {/* Mapping data siswa */}
                  {students.map((siswa) => (
                    <tr
                      key={siswa.id}
                      className="hover:bg-gray-50 dark:hover:bg-neutral-700"
                    >
                      <td className="p-3 border">{siswa.nama}</td>
                      <td className="p-3 border">
                        {siswa.tempat}, {siswa.tanggal_lahir}
                      </td>
                      <td className="p-3 border">{siswa.kelas}</td>
                      <td className="p-3 border">
                        {siswa.kelompok?.nama_kelompok || '-'}
                      </td>
                      <td className="p-3 border">{siswa.asal_sekolah}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
