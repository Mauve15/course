import React from 'react';
import { useForm } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

interface Rekap {
  id: number;
  absen: number;
  score: number;
  keterangan: string;
  student: { id: number; nama: string };
  jadwal: { id: number; materi: string };
}

interface Student {
  id: number;
  nama: string;
}

interface Jadwal {
  id: number;
  materi: string;
}

interface Props {
  rekaps: Rekap[];
  students: Student[];
  jadwals: Jadwal[];
}

export default function RekapPage({ rekaps, students, jadwals }: Props) {
  const { data, setData, post, processing, errors, reset } = useForm({
    student_id: '',
    jadwal_id: '',
    absen: '',
    score: '',
    keterangan: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/rekap', {
      preserveScroll: true,
      onSuccess: () => reset(),
    });
  };

  return (
    <AppLayout>
    <div className="p-6 max-w-5xl mx-auto">
      <h1 className="text-2xl font-bold mb-6">Input & Daftar Rekap</h1>

      {/* Form Input */}
      <form onSubmit={handleSubmit} className="mb-10 space-y-4 max-w-xl">
        <div>
          <label className="block mb-1 font-semibold">Mahasiswa</label>
          <select
            value={data.student_id}
            onChange={(e) => setData('student_id', e.target.value)}
            className="w-full border px-3 py-2"
          >
            <option value="">Pilih Mahasiswa</option>
            {students.map((student) => (
              <option key={student.id} value={student.id}>
                {student.nama}
              </option>
            ))}
          </select>
          {errors.student_id && <p className="text-red-500">{errors.student_id}</p>}
        </div>

        <div>
          <label className="block mb-1 font-semibold">Jadwal</label>
          <select
            value={data.jadwal_id}
            onChange={(e) => setData('jadwal_id', e.target.value)}
            className="w-full border px-3 py-2"
          >
            <option value="">Pilih Jadwal</option>
            {jadwals.map((jadwal) => (
              <option key={jadwal.id} value={jadwal.id}>
                {jadwal.materi}
              </option>
            ))}
          </select>
          {errors.jadwal_id && <p className="text-red-500">{errors.jadwal_id}</p>}
        </div>

        <div>
          <label className="block mb-1 font-semibold">Absen</label>
          <input
            type="number"
            value={data.absen}
            onChange={(e) => setData('absen', e.target.value)}
            className="w-full border px-3 py-2"
          />
          {errors.absen && <p className="text-red-500">{errors.absen}</p>}
        </div>

        <div>
          <label className="block mb-1 font-semibold">Score</label>
          <input
            type="number"
            value={data.score}
            onChange={(e) => setData('score', e.target.value)}
            className="w-full border px-3 py-2"
          />
          {errors.score && <p className="text-red-500">{errors.score}</p>}
        </div>

        <div>
          <label className="block mb-1 font-semibold">Keterangan</label>
          <input
            type="text"
            value={data.keterangan}
            onChange={(e) => setData('keterangan', e.target.value)}
            className="w-full border px-3 py-2"
          />
          {errors.keterangan && <p className="text-red-500">{errors.keterangan}</p>}
        </div>

        <button
          type="submit"
          disabled={processing}
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
        >
          Simpan
        </button>
      </form>

      {/* Tabel Daftar Rekap */}
      <table className="w-full border border-gray-300">
        <thead>
          <tr className="bg-gray-200">
            <th className="p-2 border-b border-gray-300">Mahasiswa</th>
            <th className="p-2 border-b border-gray-300">Jadwal</th>
            <th className="p-2 border-b border-gray-300">Absen</th>
            <th className="p-2 border-b border-gray-300">Score</th>
            <th className="p-2 border-b border-gray-300">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          {rekaps.map((rekap) => (
            <tr key={rekap.id} className="border-t border-gray-300">
              <td className="p-2">{rekap.student.nama}</td>
              <td className="p-2">{rekap.jadwal.materi}</td>
              <td className="p-2">{rekap.absen}</td>
              <td className="p-2">{rekap.score}</td>
              <td className="p-2">{rekap.keterangan}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
    </AppLayout>
  );
}
