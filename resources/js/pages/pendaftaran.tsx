import { useForm, Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { useEffect } from 'react';
import { toast } from 'sonner';

export default function Pendaftaran() {
  // pakai useForm dari inertia untuk handle form dan validasi
  const { data, setData, post, processing, errors, reset } = useForm({
    nama: '',
    alamat: '',
    tempat_lahir: '',
    tanggal_lahir: '',
    kelas: '',
    asal_sekolah: '',
    gender: 'L',
    contact: '',
    // kelompok_id: '',
  });

  // submit handler
  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/pendaftaran', {
      onSuccess: () => reset(),
    });
  };
 const { message } = usePage<{ message?: string }>().props;

  useEffect(() => {
    console.log('Flash message:', message);
    if (message) {
      toast.success(message);
    }
  }, [message]);

  return (
    <AppLayout>
      <Head title="Pendaftaran" />

      <div className="max-w-4xl w-full mx-auto p-6 bg-white dark:bg-neutral-900 rounded-lg shadow-md">
  <h1 className="text-2xl font-bold mb-6">Form Pendaftaran</h1>

        <form onSubmit={submit} className="space-y-4">
          <div>
            <label className="block mb-1 font-semibold">Nama</label>
            <input
              type="text"
              value={data.nama}
              onChange={(e) => setData('nama', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.nama && <div className="text-red-600 mt-1">{errors.nama}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Alamat</label>
            <input
              type="text"
              value={data.alamat}
              onChange={(e) => setData('alamat', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.alamat && <div className="text-red-600 mt-1">{errors.alamat}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Tempat Lahir</label>
            <input
              type="text"
              value={data.tempat_lahir}
              onChange={(e) => setData('tempat_lahir', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.tempat_lahir && <div className="text-red-600 mt-1">{errors.tempat_lahir}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Tanggal Lahir</label>
            <input
              type="date"
              value={data.tanggal_lahir}
              onChange={(e) => setData('tanggal_lahir', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.tanggal_lahir && <div className="text-red-600 mt-1">{errors.tanggal_lahir}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Kelas</label>
            <input
              type="text"
              value={data.kelas}
              onChange={(e) => setData('kelas', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.kelas && <div className="text-red-600 mt-1">{errors.kelas}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Asal Sekolah</label>
            <input
              type="text"
              value={data.asal_sekolah}
              onChange={(e) => setData('asal_sekolah', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.asal_sekolah && <div className="text-red-600 mt-1">{errors.asal_sekolah}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Gender</label>
            <select
              value={data.gender}
              onChange={(e) => setData('gender', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            >
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
            {errors.gender && <div className="text-red-600 mt-1">{errors.gender}</div>}
          </div>

          <div>
            <label className="block mb-1 font-semibold">Contact</label>
            <input
              type="text"
              value={data.contact}
              onChange={(e) => setData('contact', e.target.value)}
              className="w-full border px-3 py-2 rounded"
            />
            {errors.contact && <div className="text-red-600 mt-1">{errors.contact}</div>}
          </div>

          {/* <div>
            <label className="block mb-1 font-semibold">Kelompok</label>
            <input
              type="number"
              value={data.kelompok_id}
              onChange={(e) => setData('kelompok_id', e.target.value)}
              className="w-full border px-3 py-2 rounded"
              min={1}
            />
            {errors.kelompok_id && <div className="text-red-600 mt-1">{errors.kelompok_id}</div>}
          </div> */}

          <button
            type="submit"
            disabled={processing}
            className="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
          >
            {processing ? 'Menyimpan...' : 'Daftar'}
          </button>
        </form>
      </div>
    </AppLayout>
  );
}
