<?php

namespace App\Http\Controllers\Musyawarah;

use App\Models\Anggota\Anggota;
use App\Models\Musyawarah\Notulensi;
use App\Models\Musyawarah\Kehadiran;
use App\Models\Musyawarah\Pekerjaan;
use App\Models\Musyawarah\Komentar;
use App\Models\Musyawarah\ProgressPekerjaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MusyawarahController extends Controller
{
    //CONSTANT VALUES FOR MEMBER JABATAN
    public const KETUA = 1;
    public const SEKRETARIS = 2;
    public const BENDAHARA = 3;
    public const TAKMIR = 4;
    public const REMAS = 5;
    public const AMIR = 6;

    //CONSTANT VALUES FOR MEMBER STATUS
    public const ACTIVE_MEMBER = 1;
    public const NON_ACTIVE_MEMBER = 2;
    public const UNVERIFIED_MEMBER = 3;

    public function index()
    {
        $authUser = Auth::user();
        //semua user, composite object
        $anggotaGroup = Anggota::get()->where('id_status', '!=', self::UNVERIFIED_MEMBER);
        
        $notulensiGroup = Notulensi::all();
        foreach ($notulensiGroup as $key => $value) {
            if ($value['status'] == "Menunggu Persetujuan"){
                $kehadiran = Kehadiran::get()->where('id_notulensi',$value->id)->where('id_anggota',$authUser->id);
                $value['user_role'] = $kehadiran;
            }            
        }

        //retval
        return view('musyawarah.index', ['anggotaGroup' => $anggotaGroup,'notulensiGroup' => $notulensiGroup]);
    }

    public function pekerjaan()
    {
        //semua user, composite object
        $anggotaGroup = Anggota::get()->where('id_status', '!=', self::UNVERIFIED_MEMBER);
        $pekerjaanGroup = Pekerjaan::all();

        //retval
        return view('musyawarah.pekerjaan', ['anggotaGroup' => $anggotaGroup,'pekerjaanGroup'=>$pekerjaanGroup]);
    }

    public function cariNotulensi()
    {
        //retval
        return view('musyawarah.cari_notulensi', []);
    }

    public function cariqueryNotulensi(Request $request)
    {
        $judul_musyawarah = $request->judul_musyawarah;
        $kata_kunci = $request->kata_kunci;
        $kata_kuncis = (explode(" ",$kata_kunci));

        $add_notulensi = array();
        $notulensis = Notulensi::whereRaw("UPPER(judul_musyawarah) LIKE '%". strtoupper($judul_musyawarah)."%'")
        ->orWhereRaw("UPPER(catatan) LIKE '%". strtoupper($judul_musyawarah)."%'")->get();
        // dd($notulensis);
        foreach ($notulensis as $key => $value) {
            $is_add = false;
            $notulensi = $value;
            $catatan = $notulensi->catatan;
            
            $len_kk = 0;
            $msg_pp = [];
            foreach ($kata_kuncis as $key => $kk) {
                $pps = ProgressPekerjaan::whereRaw("UPPER(keterangan) LIKE '%". strtoupper($kk)."%'")
                ->orWhereRaw("UPPER(masukkan) LIKE '%". strtoupper($kk)."%'")
                ->orWhereRaw("UPPER(keputusan) LIKE '%". strtoupper($kk)."%'")
                ->get();
                if (count($pps) > 0){
                    $len_kk += 1;
                    foreach ($pps as $key => $pp) {
                        array_push($msg_pp,$pp);
                    }
                    $notulensi['msg_pp'] = $msg_pp;
                }
            }
            if ($len_kk > 0){
                $is_add = true;
            }
            if ($is_add){
                array_push($add_notulensi,$notulensi);
            }
        }
        
        return $add_notulensi;
    }



    public function addNotulensi()
    {
        //semua user, composite object
        $anggotaGroup = Anggota::get()->where('id_status', '!=', self::UNVERIFIED_MEMBER);
        $pekerjaanGroup = Pekerjaan::all();

        //retval
        return view('musyawarah.add_notulensi', ['anggotaGroup' => $anggotaGroup,'pekerjaanGroup'=>$pekerjaanGroup]);
    }

    public function editNotulensi($id)
    {
        $notulensi = Notulensi::find($id);
        $anggotaGroup = Anggota::get()->where('id_status', '!=', self::UNVERIFIED_MEMBER);
        $pekerjaanGroup = Pekerjaan::all();

        //retval
        return view('musyawarah.add_notulensi', ['anggotaGroup' => $anggotaGroup,'pekerjaanGroup'=>$pekerjaanGroup,'notulensi'=>$notulensi]);
    }

    public function getNotulensi($id)
    {
        $result = ProgressPekerjaan::where('id_notulensi', $id)->get();
        foreach ($result as $key => $value) {
            $value['pekerjaan'] = $value->pekerjaan;
        }
        return $result;
    }

    public function approveNotulensi($id)
    {
        $notulensi = Notulensi::find($id);
        $notulensi->status = "Dikunci";
        $notulensi->save();
        return $notulensi;
    }

    public function getKomentarNotulensi($id)
    {
        $result = Komentar::where('id_notulensi', $id)->orderBy('id', 'desc')->get();
        foreach ($result as $key => $value) {
            $value['notulensi'] = $value->notulensi;
            $value['anggota'] = $value->anggota;
        }
        return $result;
    }

    public function storeKomentarNotulensi(Request $request)
    {
        $id_notulensi = $request->id_notulensi;
        $isi_komentar = $request->isi_komentar;
        $user_id = Auth::user()->id;

        $p = Komentar::create([
            'keterangan' => $isi_komentar,
            'id_notulensi' => $id_notulensi,
            'id_anggota' => $user_id
        ]);
        return $p;
    }

    public function storeNotulensi(Request $request)
    {
        // dd($request);
        //semua user, composite object
        $notulen = Auth::user()->id;
        $id_notulensi = $request->id_notulensi;
        $judul_musyawarah = $request->judul_musyawarah;
        
        $all_id_progress = $request->id_progress;
        $all_pekerjaan_id = $request->pekerjaan_id;
        $all_progress = $request->progress;
        $all_masukkan = $request->masukkan;
        $all_keputusan = $request->keputusan;

        if ($id_notulensi == null){
            $amir_musyawarah = $request->amir_musyawarah;
            $all_kehadiran_id = $request->all_kehadiran_id;
            $all_kehadiran_id = explode(",",$all_kehadiran_id);
            
            $notulensi = Notulensi::create([
                'judul_musyawarah' => $judul_musyawarah,
                'id_notulen' => $notulen
            ]);
            
            $kehadiran = Kehadiran::create([
                'id_notulensi' => $notulensi->id,
                'id_anggota' => $amir_musyawarah,
                'role' => 'Amir'
            ]);
    
            $kehadiran = Kehadiran::create([
                'id_notulensi' => $notulensi->id,
                'id_anggota' => $notulen,
                'role' => 'Notulen'
            ]);
            for ($i=0; $i < count($all_kehadiran_id); $i++) { 
                $id_kehadiran = $all_kehadiran_id[$i];
                $kehadiran = Kehadiran::create([
                    'id_notulensi' => $notulensi->id,
                    'id_anggota' => $id_kehadiran
                ]);
            }
            
            for ($i=0; $i < count($all_pekerjaan_id) ; $i++) { 
                $id_pekerjaan = $all_pekerjaan_id[$i];
                $pekerjaan = Pekerjaan::find($id_pekerjaan);
                $data_progress = $all_progress[$i];
                $data_masukkan = $all_masukkan[$i];
                $data_keputusan = $all_keputusan[$i];
                ProgressPekerjaan::create([
                    'id_pekerjaan' => $id_pekerjaan,
                    'keterangan' => $data_progress,
                    'masukkan' => $data_masukkan,
                    'keputusan' => $data_keputusan,
                    'id_anggota' => $pekerjaan->id_anggota,
                    'id_notulensi' => $notulensi->id,
                ]);
            }
        } else {
            foreach ($all_id_progress as $key => $value) {
                $pp = ProgressPekerjaan::find($value);
                $data = [
                    'keterangan' => $all_progress[$key],
                    'masukkan' => $all_masukkan[$key],
                    'keputusan' => $all_keputusan[$key],
                ];
                $pp->update($data);
            }
        }
        
        //retval
        return redirect(route('musyawarahIndex'));
    }

    public function addPekerjaan(Request $request)
    {
        //semua user, composite object
        $nama_pekerjaan = $request->nama_pekerjaan;
        $deskripsi_pekerjaan = $request->deskripsi_pekerjaan;
        $penanggung_jawab = $request->penanggung_jawab;

        Pekerjaan::create([
            'nama' => $nama_pekerjaan,
            'deskripsi' => $deskripsi_pekerjaan,
            'id_anggota' => $penanggung_jawab
        ]);

        //retval
        return redirect(route('musyawarahPekerjaan'));
    }

    public function storePekerjaan(Request $request)
    {
        //semua user, composite object
        $nama_pekerjaan = $request->nama_pekerjaan;
        $deskripsi_pekerjaan = $request->deskripsi_pekerjaan;
        $penanggung_jawab = Auth::user()->id;

        $p = Pekerjaan::create([
            'nama' => $nama_pekerjaan,
            'deskripsi' => $deskripsi_pekerjaan,
            'id_anggota' => $penanggung_jawab
        ]);

        //retval
        return $p;
    }

    public function addProgressPekerjaan(Request $request)
    {
        // dd($request);
        // //semua user, composite object
        $progress = $request->progress;
        $id_progress_pekerjaan = $request->id_progress_pekerjaan;
        $penanggung_jawab = Auth::user()->id;
        // $penanggung_jawab = $request->penanggung_jawab;

        ProgressPekerjaan::create([
            'keterangan' => $progress,
            'id_pekerjaan' => $id_progress_pekerjaan,
            'id_anggota' => $penanggung_jawab
        ]);

        // //retval
        return redirect(route('musyawarahPekerjaan'));
    }

    public function getDetailPekerjaan($id)
    {
        $pekerjaan = Pekerjaan::get()->where('id', $id)->first();
        $pp = ProgressPekerjaan::where('id_pekerjaan', $id)->get();
        for ($i=0; $i < count($pp); $i++) { 
            $p = $pp[$i];
            $p['creator'] = $p->pembuat_progress->nama;
        }
        $pekerjaan->progress = $pp;
        return $pekerjaan;
    }
    

    // public function getJabatan(Anggota $anggota)
    // {
    //     switch ($anggota->id_jabatan) {
    //         case (self::KETUA):
    //             return 'Ketua Takmir';
    //             break;
    //         case (self::SEKRETARIS):
    //             return 'Sekretaris Takmir';
    //             break;
    //         case (self::BENDAHARA):
    //             return 'Bendahara Takmir';
    //             break;
    //         case (self::TAKMIR):
    //             return 'Takmir Masjid';
    //             break;
    //         case (self::REMAS):
    //             return 'Remaja Masjid';
    //             break;
    //         default:
    //             return 'Anggota';
    //             break;
    //     }
    // }

    // public function getStatus(Anggota $anggota)
    // {
    //     switch ($anggota->id_status) {
    //         case (self::ACTIVE_MEMBER):
    //             return 'Aktif';
    //             break;
    //         case (self::NON_ACTIVE_MEMBER):
    //             return 'Non-Aktif';
    //             break;
    //         case (self::UNVERIFIED_MEMBER):
    //             return 'Belum Verifikasi';
    //             break;
    //         default:
    //             return 'Anggota';
    //             break;
    //     }
    // }

    // //check akses sekretaris
    // public function checkAksesSekretaris()
    // {
    //     //array berisi jabatan dengan akses sekretaris
    //     $sekretaris = array(self::KETUA, self::SEKRETARIS);

    //     //jika user terotentikasi statusnya aktif bisa lanjutkan, jika tidak return ke '/'
    //     $authUser = Auth::user();
    //     $insideSekretaris = in_array($authUser->id_jabatan, $sekretaris);
    //     if ($insideSekretaris) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // //mendapatkan detail anggota berdasarkan id, return objek anggota
    // public function getDetail($id)
    // {
    //     $anggota = Anggota::get()->where('id', $id)->first();
    //     $anggota->jabatan = $this->getJabatan($anggota);
    //     $anggota->status = $this->getStatus($anggota);
    //     $anggota->link_foto = $anggota->link_foto . '?=' . filemtime($anggota->link_foto);
    //     return $anggota;
    // }

    // //menghapus akun anggota, return list anggota terdaftar
    // public function delete(Request $request)
    // {
    //     //check akses sekretaris
    //     if ($this->checkAksesSekretaris() == false) {
    //         return redirect(route('home'));
    //     }
    //     $anggota = Anggota::get()->where('id', $request->id)->first();
    //     $anggota->delete();

    //     return redirect(route('anggotaIndex'));
    // }

    // //mengedit data akun anggota, return list anggota terdaftar
    // public function update(Request $request)
    // {
    //     //check akses sekretaris
    //     if ($this->checkAksesSekretaris() == false) {
    //         return redirect(route('home'));
    //     }
    //     //edited user
    //     $anggota = Anggota::get()->where('id', $request->id)->first();

    //     if ($request->username != $anggota->username) {
    //         $anggota->username = $request->username;
    //         $request->validate([
    //             'username' => 'unique:anggota',
    //         ]);
    //     }
    //     if ($request->email != $anggota->email) {
    //         $anggota->email = $request->email;
    //         $request->validate([
    //             'email' => 'unique:anggota|email'
    //         ]);
    //     }
    //     $request->validate([
    //         'nama' => 'required',
    //         'id_jabatan' => 'required',
    //         'id_status' => 'required',
    //     ]);
    //     $anggota->nama = $request->nama;
    //     $anggota->id_jabatan = $request->id_jabatan;
    //     $anggota->id_status = $request->id_status;
    //     $anggota->alamat = $request->alamat;
    //     $anggota->telp = $request->telp;
    //     $anggota->save();

    //     return redirect(route('anggotaIndex'));
    // }
}
