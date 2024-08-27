<?php

namespace App\Http\Controllers;

use App\Models\ApplicationA;
use App\Models\ApplicationG;
use App\Models\Gear;
use App\Models\HistoryA;
use App\Models\HistoryG;
use App\Models\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowerController extends Controller
{
    public function detail()
    {
        $id = Auth::user()->staff_id;
        return User_info::findOrFail($id);
    }

    public function index()
    {
        $detail = ApplicationG::where('user_id', Auth::user()->staff_id)->first();
        if ($detail) {
            return redirect()->route('borrower.status');
        } else
            return redirect()->route('borrower.l_history');
    }

    public function home()
    {
        return view('e-borang', ['a' => $this->detail()]);
    }

    public function pilih_modul(Request $request)
    {
        if ($request->modul === 'PINJAMAN PERALATAN ICT') {
            return redirect()->route('borrower.e_brrw');
        }
        return redirect()->route('borrower.e_capaian');
    }

    //borang pinjaman
    public function e_brrw()
    {
        $detail = ApplicationG::where('user_id', Auth::user()->staff_id)->first();
        if ($detail) {
            if (!($detail->status === 'D'))
                return redirect()->route('borrower.status')->with('error', 'Anda hanya boleh membuat 1 modul  1 permohonan sahaja');
            else
                return redirect()->route('borrower.status');

        } else {
            $detail = User_info::with('department1')->where('id', Auth::user()->staff_id)->first();
            return view('pinjaman', ['a' => $detail,]);
        }
    }

    //borang hak capaian
    public function e_capaian()
    {
        $detail = ApplicationA::where('user_id', Auth::user()->staff_id)->first();
        if ($detail) {
            if (!($detail->status === 'D'))
                return redirect()->route('borrower.status')->with('error', 'Anda hanya boleh membuat 1 modul  1 permohonan sahaja');
            else
                return redirect()->route('borrower.status');

        } else {
            $detail = User_info::with('department1')->where('id', Auth::user()->staff_id)->first();
            return view('hak_capaian', ['a' => $detail,]);
        }
    }

    //status pinjaman
    public function status()
    {
        $borang = ApplicationG::where('user_id', Auth::user()->staff_id)->first();
        if ($borang)
            return view('status_pinjaman', ['a' => $this->detail(), 'brg' => $borang]);
        return view('status_pinjaman', ['a' => $this->detail(), 'brg' => null]);
    }

    //status capaian
    public function status2()
    {
        $borang = ApplicationA::where('user_id', Auth::user()->staff_id)->first();
        if ($borang)
            return view('status_capaian', ['a' => $this->detail(), 'brg' => $borang]);
        return view('status_capaian', ['a' => $this->detail(), 'brg' => null]);
    }


    //pengesahan pulangan peralatan
    public function remove($id)
    {
        $result = ApplicationG::whereId($id)->first();
        if ($result) {
            ApplicationG::whereId($id)->delete();
            return redirect()->route('borrower.borrower_home');
        } else {
            return redirect()->route('borrower.borrower_home')->with('error', 'Berlaku ralat');
        }

    }

    //pengesahan capaian
    public function remove2($id)
    {
        $result = ApplicationA::whereId($id)->first();
        if ($result) {
            ApplicationA::whereId($id)->delete();
            return redirect()->route('borrower.borrower_home');
        } else {
            return redirect()->route('borrower.borrower_home')->with('error', 'Berlaku ralat');
        }

    }

    //proses pinjaman
    public function borrow(Request $request)
    {

        $gear = [];
        $data = [
            'user_id' => $request->id,
            'start' => $request->start,
            'end' => $request->end,
            'motive' => $request->reason,
            'location' => $request->location,
        ];

        if ($request->laptop > 0)
            $gear[] = 'Laptop - ' . $request->laptop;
        if ($request->projektor > 0)
            $gear[] = 'Projektor - ' . $request->projektor;
        if ($request->optional !== 'Tiada' && !is_null($request->optional))
            $gear[] = $request->optional;

        if (empty($gear))
            return redirect()->route('borrower.borrower_home')->with('error', 'Sila lakukan pemilihan peralatan');

        $data['gear'] = implode(', ', $gear);
        $result = ApplicationG::create($data);
        if ($result) {
            $update = ApplicationG::where(['user_id' => $request->id, 'motive' => $request->reason])->update(['status' => 'P']); // P = Pending
            if ($update)
                return redirect()->route('borrower.status')->with('success', 'Permohonan telah dihantar');

            ApplicationG::where('user_id', $request->id)->delete();
            return redirect()->route('borrower.status')->with('error', 'Mengalami ralat, sila cuba lagi');
        } else
            return redirect()->route('borrower.borrower_home')->with('error', 'Mengalami ralat, sila cuba lagi');

    }

    //proses hak capaian
    public function access(Request $request)
    {
        $detail = $request->unit.', '.$request->jwtn;
        $data = [
            'user_id' => $request->id,
            'detail' => $detail,
            'category' => $request->category,
            'acct_name' => $request->acct,
            'reason' => $request->reason
        ];
        $result = ApplicationA::create($data);
        if ($result) {
            $update = ApplicationA::where(['user_id' => $request->id, 'category' => $request->category])->update(['status' => 'P']); // P = Pending
            if ($update)
                return redirect()->route('borrower.status2')->with('success', 'Permohonan telah dihantar');
            ApplicationA::where('user_id', $request->id)->delete();
            return redirect()->route('borrower.borrower_home')->with('error', 'Mengalami ralat, sila cuba lagi');
        }
        return redirect()->route('borrower.borrower_home')->with('error', 'Mengalami ralat, sila cuba lagi');

    }

    //senarai history
    public function list_h()
    {
        $detail = ApplicationG::where('user_id', Auth::user()->staff_id)->whereIn('status', ['X', 'D'])->first();
        if ($detail) { //pinjaman
            return redirect()->route('borrower.status')->with('success', 'Anda hanya boleh membuat 1 modul  1 permohonan sahaja');
        } else {
            $detail = ApplicationA::where('user_id', Auth::user()->staff_id)->whereIn('status', ['X', 'D'])->first();
            if ($detail) { //capaian
                return redirect()->route('borrower.status2');
            }

            $list = [];
            $r1 = ApplicationG::where('user_id', Auth::user()->staff_id)->get();
            $r2 = ApplicationA::where('user_id', Auth::user()->staff_id)->get();
            $p1 = HistoryG::where('user_id', Auth::user()->staff_id)->get();
            $p2 = HistoryA::where('user_id', Auth::user()->staff_id)->get();
            if (!$r1->isEmpty())
                $list['gear'] = $r1;
            if (!$r2->isEmpty())
                $list['hak'] = $r2;
            if (!$p1->isEmpty())
                $list['history_gear'] = $p1;
            if (!$p2->isEmpty())
                $list['history_hak'] = $p2;

//        dd($list);
            return view('list_history', ['loaner' => $list, 'a' => $this->detail()]);
        }
    }

    //butiran history
    public function detail_history($id, $modul) //detail history
    {
        if ($modul === 'gear') {
            $loaner = DB::table('peralatan_history')
                ->where('peralatan_history.id', $id)
                ->leftJoin('user_info', 'peralatan_history.user_id', '=', 'user_info.id')
                ->select('peralatan_history.*', 'user_info.name as name', 'user_info.department as department')
                ->first();
            if (!is_null($loaner->gear_id)) {
                $g_id = explode(', ', $loaner->gear_id);
                $list = [];
                foreach ($g_id as $item) {
                    $list[] = Gear::whereId($item)->first();
                }
                return view('pinjaman_history', ['a' => $this->detail(), 'loaner' => $loaner, 'list' => $list]);
            }
            return view('pinjaman_history', ['a' => $this->detail(), 'loaner' => $loaner, 'list' => null]);
        } elseif ($modul === 'hak') {
            $loaner = DB::table('capaian_history')
                ->where('capaian_history.id', $id)
                ->leftJoin('user_info', 'capaian_history.user_id', '=', 'user_info.id')
                ->select('capaian_history.*', 'user_info.name as name', 'user_info.department as department')
                ->first();
            return view('capaian_history', ['a' => $this->detail(), 'loaner' => $loaner]);
        }
        return redirect()->route('borrower.borrower_home')->with('error', 'Mengalami ralat, sila cuba lagi');
    }

    public function deleteHistory($id)
    {
        $record = ApplicationG::find($id);

        if ($record) {
            $record->delete();
            return redirect()->route('borrower.borrower_home')->with('success', 'History has been deleted successfully.');
        } else {
            return redirect()->route('borrower.borrower_home')->with('error', 'History not found.');
        }
    }



    public function test()
    {
        $old_id = ApplicationG::latest()->first();
        if ($old_id) {
            $acc_num = substr($old_id->Id, -3);
            $acc_num = intval($acc_num) + 1;
        } else {
            $acc_num = 111;
        }
        //id utk permohonan
        echo 'PINJ' . date('Ym') . sprintf('%03d', $acc_num);
    }
}
