<?php

namespace App\Http\Controllers;

use App\Models\ApplicationA;
use App\Models\ApplicationG;
use App\Models\HistoryA;
use App\Models\HistoryG;
use App\Models\User;
use App\Models\User_info;
use Cassandra\Date;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KBController extends Controller
{
    public function user()
    {
        $id = Auth::user()->staff_id;
        return User_info::findOrFail($id);
    }

    public function dep()
    {
        return User_info::where('department', $this->user()->department)->get();
    }

    //    senarai pemohon hak capaian dri jbtn/bahagian sendiri
    public function loanerG()
    {
        $loanerG = [];
        foreach ($this->dep() as $item) {
            if (!($item->id === $this->user()->id)) {
                $user = ApplicationG::with('application')->where(['status' => 'P', 'user_id' => $item->id,
                    'review' => null])->first();
                if (!is_null($user))
                    $loanerG[] = $user;
            }
        }
        return $loanerG;
    }

    //    senarai pemohon peralatan dri jbtn/bahagian sendiri
    public function loanerA()
    {
        $loanerA = [];
        foreach ($this->dep() as $item) {
            if (!($item->id === $this->user()->id)) {
                $user = ApplicationA::with('application2')->where(['status' => 'P',
                    'user_id' => $item->id, 'review' => null])->first();
                if (!is_null($user))
                    $loanerA[] = $user;
            }
        }
        return $loanerA;
    }

    //    dashboard kb btm
    public function index()
    {
        //P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= GEAR RETURNED, X = REJECTED
        $loaner = ApplicationG::with('application', 'in_charge')->whereIn('status', ['P', 'R',
            'B'])->whereNotNull('review')->orderByRaw("FIELD(status, 'P', 'R', 'B')")->get();
        $loaner2 = ApplicationA::with('application2', 'in_charge2')->whereIn('status', ['P',
            'R'])->whereNotNull('review')->orderByRaw("FIELD(status, 'P', 'R')")->get();
        $A = $this->loanerA();
        $G = $this->loanerG();
        $list = [
            'Gear' => $loaner,
            'Hak' => $loaner2,
        ];
        $list2 = [
            'Hak' => $A,
            'Gear' => $G,
        ];
//        dd($list, $list2);
        if (!empty($loaner) || !empty($loaner2)) {
            if (!empty($A) || !empty($G))
                return view('kb_btm/dashboard', ['a' => $this->user(), 'loaner' => $list, 'self' => $list2]);
            return view('kb_btm/dashboard', ['a' => $this->user(), 'loaner' => $list, 'self' => null]);
        } elseif (!empty($A) || !empty($G))
            return view('kb_btm/dashboard', ['a' => $this->user(), 'loaner' => null, 'self' => $list2]);
        return view('kb_btm/dashboard', ['a' => $this->user(), 'loaner' => null, 'self' => null]);
    }

    //    dashboard kb lain
    public function index2()
    {
        $A = $this->loanerA();
        $G = $this->loanerG();
        $list = [
            'Hak' => $A,
            'Gear' => $G,
        ];
//        dd($list);
        if (!empty($A) || !empty($G))
            return view('kb_lain/dashboard', ['a' => $this->user(), 'loaner' => $list,]);
        return view('kb_lain/dashboard', ['a' => $this->user(), 'loaner' => null]);
    }

    // detail pinjaman - kb btm
    public function detail($id)
    {
        $loaner = ApplicationG::with('application')->whereId($id)->first();
        if (!is_null($loaner))
            return view('kb_btm/pinjaman_detail', ['a' => $this->user(), 'loaner' => $loaner,]);
        else {
            return view('kb_btm/pinjaman_detail', ['a' => $this->user(), 'loaner' => null]);

        }
    }

    // detail capaian - kb btm
    public function detail_c($id)
    {
        $loaner = ApplicationA::with('application2')->whereId($id)->first();
        if (!is_null($loaner))
            return view('kb_btm/capaian_detail', ['a' => $this->user(), 'loaner' => $loaner,]);
        else {
            return view('kb_btm/capaian_detail', ['a' => $this->user(), 'loaner' => null]);

        }
    }

    //detail pinjaman - kb lain
    public function detail2($id)
    {
        $loaner = ApplicationG::with('application')->whereId($id)->first();
        if (!is_null($loaner))
            return view('kb_lain/pinjaman_detail', ['a' => $this->user(), 'loaner' => $loaner,]);

        return redirect(route('kb_l.kbl_home'))->with('error', 'Ralat Berlaku');

    }

    // detail capaian - kb lain
    public function detail2_c($id)
    {
        $loaner = ApplicationA::with('application2')->whereId($id)->first();
        if (!is_null($loaner))
            return view('kb_lain/capaian_detail', ['a' => $this->user(), 'loaner' => $loaner,]);
        else {
            return view('kb_lain/capaian_detail', ['a' => $this->user(), 'loaner' => null]);

        }
    }

    // terima pinjaman  - kb btm
    public function sah($id)//KB BTM
    {
        $old = ApplicationG::whereId($id)->first();
        $verify = $old->verify_at . ', ' . (new DateTime())->format('Y-m-d H:i:s');
        $result = ApplicationG::whereId($id)->update(['status' => 'M', 'verify_at' => $verify]);
        //M= perlu diuruskan staff
        if ($result)
            return redirect(route('kb.kb_home'))->with('success', 'Anda telah berjaya mengesahkan permohonan');
        return redirect(route('kb.kb_home'))->with('error', 'Ralat Berlaku');
    }

    // terima pinjaman  - kb lain
    public function sah2(Request $request, $id)
    {
        $result = ApplicationG::where('id', $id)->update(['review' => $request->review,
            'verify_at' => (new DateTime())->format('Y-m-d H:i:s')]);
        if ($result)
            return redirect(route('kb_l.kbl_home'))->with('success', 'Anda telah berjaya mengesahkan permohonan');
        return redirect(route('kb_l.kbl_home'))->with('error', 'Ralat Berlaku');
    }

    // terima capaian  - kb btm
    public function sah_c($id)//KB BTM
    {
        $old = ApplicationA::whereId($id)->first();
        $verify = $old->verify_at . ', ' . (new DateTime())->format('Y-m-d H:i:s');
        $result = ApplicationA::whereId($id)->update(['status' => 'M', 'verify_at' => $verify]);
        //M= perlu diuruskan staff
        if ($result)
            return redirect(route('kb.kb_home'))->with('success', 'Anda telah berjaya mengesahkan permohonan');
        return redirect(route('kb.kb_home'))->with('error', 'Ralat Berlaku');
    }

    // terima capaian  - kb lain
    public function sah2_c(Request $request, $id)
    {
        $result = ApplicationA::where('id', $id)->update(['review' => $request->review,
            'verify_at' => (new DateTime())->format('Y-m-d H:i:s')]);
        if ($result)
            return redirect(route('kb_l.kbl_home'))->with('success', 'Anda telah berjaya mengesahkan permohonan');
        return redirect(route('kb_l.kbl_home'))->with('error', 'Ralat Berlaku');
    }

    public function historyG($id)
    {
        $data = ApplicationG::whereId($id)->first();
        $history = [
            'user_id' => $data->user_id,
            'motive' => $data->motive,
            'gear' => $data->gear,
            'review' => $data->review,
            'location' => $data->location,
            'start' => $data->start,
            'end' => $data->end,
            'status' => $data->status,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];
        return HistoryG::create($history);
    }

    public function historyA($id)
    {
        $data = ApplicationA::whereId($id)->first();
        $history = [
            'user_id' => $data->user_id,
            'reason' => $data->reason,
            'category' => $data->category,
            'review' => $data->review,
            'acct_name' => $data->acct_name,
            'status' => $data->status,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];
        return HistoryA::create($history);
    }

    //tolak pinjaman - kb btm
    public function tolak(Request $request, $id)
    {
        $result = ApplicationG::where('id', $id)->update(['status' => 'X', 'review' => 'ULASAN KB BTM : ' . $request->review]);
        if ($result) {
            $this->historyG($id);
            return redirect(route('kb.kb_home'))->with('success', 'Anda telah menolak permohonan');
        }
        return redirect(route('kb.kb_home'))->with('error', 'Berlaku ralat');
    }

    //tolak capaian - kb btm
    public function tolak_c(Request $request, $id)
    {
        $result = ApplicationA::where('id', $id)->update(['status' => 'X', 'review' => 'ULASAN KB BTM : ' . $request->review]);
        if ($result) {
            $this->historyA($id);
            return redirect(route('kb.kb_home'))->with('success', 'Anda telah menolak permohonan');
        }
        return redirect(route('kb.kb_home'))->with('error', 'Berlaku ralat');
    }

    //tolak pinjaman - kb lain
    public function tolak2(Request $request, $id)
    {
        $result = ApplicationG::whereId($id)->update(['status' => 'X', 'review' => 'ULASAN KB : ' . $request->review]);
        if ($result) {
            $this->historyG($id);
            return redirect(route('kb_l.kbl_home'))->with('success', 'Anda telah menolak permohonan');
        } else
            return redirect(route('kb_l.kbl_home'))->with('error', 'Berlaku ralat');
    }

    //tolak capaian - kb lain
    public function tolak2_c(Request $request, $id)
    {
        $result = ApplicationA::whereId($id)->update(['status' => 'X', 'review' => 'ULASAN KB : ' . $request->review]);
        if ($result) {
            $this->historyA($id);
            return redirect(route('kb_l.kbl_home'))->with('success', 'Anda telah menolak permohonan');
        }
        return redirect(route('kb_l.kbl_home'))->with('error', 'Berlaku ralat');
    }

    public function test()
    {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $time = new DateTime();
        echo $time->format('Y-m-d H:i:s');
    }

}
