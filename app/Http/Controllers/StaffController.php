<?php

namespace App\Http\Controllers;

use App\Models\ApplicationA;
use App\Models\ApplicationG;
use App\Models\Department;
use App\Models\Gear;
use App\Models\Gear_Type;
use App\Models\HistoryG;
use App\Models\User_info;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{

    public function index()
    {
        //info
        $pc = Gear::where('type', 'Laptop')->get();
        $pro = Gear::where('type', 'Projektor')->get();
        $avil_pc = Gear::where(['type' => 'Laptop', 'status' => null])->get();
        $avil_pro = Gear::where(['type' => 'Projektor', 'status' => null])->get();
        $n_pc = Gear::where(['type' => 'Laptop', 'status' => 'N'])->get();
        $n_pro = Gear::where(['type' => 'Projektor', 'status' => 'N'])->get();
        $action1 = ApplicationG::where('status', 'M')->get();
        $action2 = ApplicationA::where('status', 'M')->get();
        $action = sizeof($action1) + sizeof($action2);
        $progress1 = ApplicationG::where('status', 'R')->get();
        $progress2 = ApplicationA::where('status', 'R')->get();
        $progress = sizeof($progress1) + sizeof($progress2);
        $over = [];
        $brrw = [];
        $get = ApplicationG::where('status', 'B')->get();
        foreach ($get as $item) {
            $end = DateTime::createFromFormat('Y-m-d', $item->end)->format('d-m-Y');
            $new = (new DateTime())->format('d-m-Y');
            if ($end < $new) {
                $over[] = $item;
            } else {
                $brrw[] = $item;
            }
        }
        return view('staff/dashboard', ['a' => $this->user(), 'a_pc' => $avil_pc, 'a_pro' => $avil_pro,
            'b_pc' => $n_pc, 'b_pro' => $n_pro, 'pc' => $pc, 'pro' => $pro, 'action' => $action, 'progres' => $progress,
            'brrw' => $brrw, 'over' => $over]);
    }

    public function application()
    {
        // application detail
        $loaner = ApplicationG::with('application', 'in_charge')->WhereIn('status',
            ['M', 'R', 'B', 'D'])->orderByRaw("FIELD(status, 'M', 'R', 'B', 'D')")->get();
        $history = DB::table('peralatan_history')->leftjoin('user_info', 'peralatan_history.user_id',
            '=', 'user_info.id')->select('peralatan_history.*',
            'user_info.name as name')->orderByRaw("FIELD(status, 'D', 'X')")->get();

        return view('staff/application', ['a' => $this->user(), 'loaner' => $loaner, 'history' => $history]);

    }


    public function user()
    {
        $id = Auth::user()->staff_id;
        return User_info::findOrFail($id);
    }

    public function list_g()
    {
        $type = Gear_Type::get();
        $list = Gear::orderByRaw("FIELD(status, 'N')")->get();
        return view('staff/gear', ['a' => $this->user(), 'list' => $list, 'type' => $type]);
    }

    public function borang()
    {
        return view('staff/brg_permohonan', ['a' => $this->user()]);
    }

    public function g_form() //gear form
    {
        $list = Gear_Type::get();
        return view('staff/form', ['a' => $this->user(), 'list' => $list]);
    }

    public function pic($id) //assign person in charge
{
    $current_month = date('Ym');
    $acc_num = 1; // Default to 1 if no valid record is found

    // Try to find the latest valid tiket in ApplicationG table
    $latest_application = ApplicationG::whereNotNull('tiket')->latest()->first();

    if ($latest_application) {
        $last_month = substr($latest_application->tiket, 4, 6); // Assuming format is PINJYYYYMMNNN

        if ($last_month === $current_month) {
            $acc_num = intval(substr($latest_application->tiket, -3)) + 1;
        }
    } else {
        // Try to find the latest valid tiket in HistoryG table if no valid record found in ApplicationG
        $latest_history = HistoryG::whereNotNull('tiket')->latest()->first();

        if ($latest_history) {
            $last_month = substr($latest_history->tiket, 4, 6);

            if ($last_month === $current_month) {
                $acc_num = intval(substr($latest_history->tiket, -3)) + 1;
            }
        }
    }

    // Generate the tiket string
    $tiket = 'PINJ' . $current_month . sprintf('%03d', $acc_num);

    // Set the new deadline
    $old = DateTime::createFromFormat('Y-m-d', (ApplicationG::whereId($id)->first())->end);
    $new = $old->modify('+1 day');

    // Update the record with the new tiket and other details
    ApplicationG::whereId($id)->update([
        'pic' => Auth::user()->staff_id,
        'status' => 'R',
        'tiket' => $tiket,
        'end' => $new
    ]);

    return redirect(route('staff.application'))->with('success', 'Anda telah menjadi pengawai yang menguruskan permohonan ini');
}

    public function tolak(Request $request, $id)//tolak permohonan
    {
        $result = ApplicationG::whereId($id)->update(['status' => 'X', 'gear_mssg' => 'STAFF : ' . $request->gear_mssg]);
        if ($result) {
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
                'gear_mssg' => $data->gear_mssg,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'verify_at' => $data->verify_at,
            ];
            HistoryG::create($history);
            return redirect(route('staff.application'))->with('success', 'Anda telah menolak permohonan');
        } else
            return redirect(route('staff.application'))->with('error', 'Berlaku ralat');
    }

    public function borrow($id) //borrow phase
    {
        //P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= GEAR RETURNED, X = REJECTED
        $result = ApplicationG::whereId($id)->update(['status' => 'B']);
        if ($result)
            return redirect(route('staff.detail', ['id' => $id]))->with('success', 'Pemohon telah mengambil peralatan');
        else
            return redirect(route('staff.detail', ['id' => $id]))->with('error', 'Ralat');
    }

    public function remove_gear($id) //padan peralatan
    {
        $result = Gear::whereId($id)->delete();
        if ($result)
            return redirect(route('staff.list_g', ['id' => $id]))->with('success', 'Peralatan telah dipadam.');
        else
            return redirect(route('staff.list_g', ['id' => $id]))->with('error', 'Berlaku ralat');
    }

    public function remove_ctgry($id) //padan peralatan
    {
        $result = Gear_Type::where('name', $id)->delete();
        if ($result)
            return redirect(route('staff.list_g', ['id' => $id]))->with('success', 'Kategori peralatan telah dipadam.');
        return redirect(route('staff.list_g', ['id' => $id]))->with('error', 'Berlaku ralat');
    }

    public function edit_gear(Request $request, $id) //padan peralatan
    {
        $data = [
            'type' => $request->type,
            'model' => $request->model,
            'tag' => $request->tag,
            'no_siri' => $request->no_siri,
        ];
        $result = Gear::whereId($id)->update($data);
        if ($result)
            return redirect(route('staff.list_g', ['id' => $id]))->with('success', 'Data berjaya diubah.');
        else
            return redirect(route('staff.list_g', ['id' => $id]))->with('error', 'Berlaku ralat');
    }

    public function pulangan($id) //return phase
    {
        //P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= GEAR RETURNED, X = REJECTED
        $result = ApplicationG::whereId($id)->update(['status' => 'D']);
        if ($result) {
            $data = ApplicationG::whereId($id)->first();
            $history = [
                'user_id' => $data->user_id,
                'tiket' => $data->tiket,
                'motive' => $data->motive,
                'gear' => $data->gear,
                'review' => $data->review,
                'location' => $data->location,
                'start' => $data->start,
                'end' => $data->end,
                'pic' => $data->pic,
                'status' => $data->status,
                'gear_id' => $data->gear_id,
                'gear_mssg' => $data->gear_mssg,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'verify_at' => $data->verify_at,
                'email_noti' => $data->email_noti,
            ];
            $gear = explode(', ', $data->gear_id);
            foreach ($gear as $g) {
                Gear::whereId($g)->update(['status' => null]);
            }
            HistoryG::create($history);
            //ApplicationG::whereId($id)->delete();
            return redirect(route('staff.application'))->with('success', 'Pemohon telah memulangkan peralatan');
        } else
            return redirect(route('staff.application'))->with('error', 'Ralat');
    }

    public function detail($id) //manage application
    {
        $loaner = ApplicationG::with('application', 'in_charge')->whereId($id)->first();
        if ($loaner) {
            //tengah process
            if (!is_null($loaner->gear_id)) {
                $g_id = explode(', ', $loaner->gear_id);
                $list = [];
                foreach ($g_id as $item) {
                    $list[] = Gear::whereId($item)->first();
                }
                return view('staff/detail', ['a' => $this->user(), 'loaner' => $loaner, 'list' => $list]);
            } else
                return view('staff/detail', ['a' => $this->user(), 'loaner' => $loaner, 'list' => null]);
        } else {
            $loaner = DB::table('peralatan_history')->where('user_id', $id)->leftJoin('user_info', 'peralatan_history.user_id', '=',
                'user_info.id')->select('peralatan_history.*', 'user_info.name as name', 'user_info.department as department')->first();
            //kena reject atau dah selesai
            if (!is_null($loaner->gear_id)) {
                $g_id = explode(', ', $loaner->gear_id);
                $list = [];
                foreach ($g_id as $item) {
                    $list[] = Gear::whereId($item)->first();
                }
                return view('staff/detail_history', ['a' => $this->user(), 'loaner' => $loaner, 'list' => $list]);
            } else
                return view('staff/detail_history', ['a' => $this->user(), 'loaner' => $loaner, 'list' => null]);
        }
    }

    public function set_gear($id) //manage application
    {
        $gear = Gear::where('status', null)->get();
        $loaner = ApplicationG::whereId($id)->first();
        return view('staff/set_gear', ['a' => $this->user(), 'loaner' => $loaner, 'list' => $gear]);
    }

    public function category() //manage jenis peralatan
    {
        $gear = Gear_Type::get();
        return view('staff/ctgry', ['a' => $this->user(), 'list' => $gear]);
    }

    public function category_p(Request $request) //manage jenis peralatan
    {
        $data = [
            'name' => $request->name
        ];
        $result = Gear_Type::create($data);
        if ($result)
            return redirect()->route('staff.category')->with('success', 'Berjaya Tambah Jenis Peralatan Baru');
        else
            return redirect()->route('staff.category')->with('error', 'Ralat berlaku');
    }

    public function pp(Request $request, $id) // assign gear kpd applicant
    {
        $gear = implode(', ', $request->selected_items);
        $result = ApplicationG::whereId($id)->update(['gear_id' => $gear, 'gear_mssg' => $request->gear_mssg]);
        if ($result) {
            foreach ($request->selected_items as $item) {
                Gear::whereId($item)->update(['status' => 'N']);
            }
            return redirect()->route('staff.application')->with('success', 'Bejaya menetapkan peralatan');
        } else
            return redirect()->route('staff.application')->with('error', 'Ralat berlaku');
//        dd($request);
    }

    public function g_form_p(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'model' => 'required',
            'tag' => 'required',
            'no_siri' => 'required',
        ]);
        $data = [
            'type' => $request->type,
            'model' => $request->model,
            'tag' => $request->tag,
            'no_siri' => $request->no_siri,
        ];
        $result = Gear::create($data);
        if ($result)
            return redirect()->route('staff.list_g')->with('success', 'Berjaya menambah peralatan ICT');
        else
            return redirect()->route('staff.list_g')->with('error', 'Berlaku ralat');
    }

    public function resit($id)
    {
        $data = HistoryG::whereId($id)->first();
        $user = User_info::whereId($data->user_id)->first();
        $dept = Department::where('name', $user->department)->first();
        $pdf = PDF::loadView('staff/borang', ['data' => $data, 'dept' => $dept, 'user' => $user]);
        return $pdf->stream('test.pdf');
//        return view('staff/borang');
    }

    public function test()
    {
        $old = ApplicationG::find(1);
        $end = DateTime::createFromFormat('Y-m-d', $old->end);
        $new = $end->modify('+1 day');
        dd($new);
    }

    public function brrw(Request $request) //borang permohonan
    {
        $gear = [];
        $data = [
            'user_id' => $request->id,
            'start' => $request->start,
            'end' => $request->end,
            'location' => $request->location,
            'motive' => $request->reason,
        ];
        if ($request->laptop > 0)
            $gear[] = 'Laptop - ' . $request->laptop;
        if ($request->projektor > 0)
            $gear[] = 'Projektor - ' . $request->projektor;
        if ($request->optional !== 'Tiada' && !is_null($request->optional))
            $gear[] = $request->optional;

        if (empty($gear))
            return redirect()->route('staff.borang')->with('error', 'Sila lakukan pemilihan peralatan');

        $data['gear'] = implode(', ', $gear);
        $result = ApplicationG::create($data);
        if ($result) {
            $update = ApplicationG::where(['user_id' => $request->id, 'motive' => $request->reason])->update(['status' => 'P']); // P = Pending
            if ($update)
                return redirect()->route('staff.borang')->with('success', 'Permohonan telah dihantar');

            ApplicationG::where('user_id', $request->id)->delete();
            return redirect()->route('staff.borang')->with('error', 'Mengalami ralat, sila cuba lagi');
        } else
            return redirect()->route('staff.borang')->with('error', 'Mengalami ralat, sila cuba lagi');
    }

}
