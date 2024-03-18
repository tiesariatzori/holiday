<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\VacationPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VacationPlanController extends Controller
{
    public function index(Request $request)
    {
        return view('panel.vacation.index', ['model' => new VacationPlan()]);
    }



    public function table(Request $request)
    {
        $search = $request->input('search');
        $export = $request->input('export', 0);
        $user = Auth::user();

        $query = VacationPlan::query()
            ->where('user_id', $user->id)
            ->select([
                'vacation_plan.*',
                DB::raw('date_format(vacation_plan.date_initial, "%m/%d/%Y %H:%i") AS date_initial_format'),
                DB::raw('date_format(vacation_plan.date_final, "%m/%d/%Y %H:%i") AS date_final_format')
            ]);

        if ($export) {
            return $this->export($query->get());
        }

        return DataTables::of($query)
            ->filter(
                function ($query) use ($search) {
                    $query->where(
                        function (Builder $query) use ($search) {
                            $query->orWhere('title', 'like', "%" . $search . "%");
                            $query->orWhere('description', 'like', "%" . $search . "%");
                            $query->orWhere('date_initial', 'like', "%" . $search . "%");
                            $query->orWhere('date_final', 'like', "%" . $search . "%");
                            $query->orWhere('location', 'like', "%" . $search . "%");
                            $query->orWhere('participant', 'like', "%" . $search . "%");
                        }
                    );
                },
                true
            )
            ->make();
    }


    public function export($query)
    {
        $pdf = Pdf::loadView('pdf.vacation', ['querys' => $query]);
        return $pdf->download('vacations.pdf');
        exit();
    }


    public function create(Request $request)
    {
        return view('panel.vacation.create', ['model' => new VacationPlan()]);
    }

    public function store(Request $request)
    {
        $erro = 0;
        $messagem = 'Plan saved successfully!';
        $vacationPlan = new VacationPlan();
        $user = Auth::user();

        $check = $this->formValidate($request);

        if (isset($check['error'])) {
            return $check;
        }

        $vacationPlan->fill($check);
        $vacationPlan->user_id = $user->id;
        $vacationPlan->setDate('date_initial', $check['date_initial']);
        $vacationPlan->setDate('date_final', $check['date_final']);

        if (!$vacationPlan->save()) {
            $erro = 1;
            $messagem = 'An error occurred while saving the vacation plan!';
        }

        if ($request->ajax()) {
            return ['error' => $erro, 'message' => $messagem];
        }

        session()->flash($erro ? 'error' : 'success', $messagem);

        return redirect()->back();
    }

    public function update(Request $request, VacationPlan $vacationPlan)
    {
        $erro = 0;
        $messagem = 'Plan updated successfully!';

        if (!$vacationPlan->verification()) {
            $erro = 1;
            $messagem = 'You do not have access to this plan!';

            if ($request->ajax()) {
                return ['error' => $erro, 'message' => $messagem];
            }

            session()->flash($erro ? 'error' : 'success', $messagem);

            return redirect()->back();
        }

        $user = Auth::user();

        $check = $this->formValidate($request);

        if (isset($check['error'])) {
            return $check;
        }

        $vacationPlan->fill($check);
        $vacationPlan->user_id = $user->id;
        $vacationPlan->setDate('date_initial', $check['date_initial']);
        $vacationPlan->setDate('date_final', $check['date_final']);

        if (!$vacationPlan->save()) {
            $erro = 1;
            $messagem = 'An error occurred while saving the vacation plan!';
        }

        if ($request->ajax()) {
            return ['error' => $erro, 'message' => $messagem];
        }

        session()->flash($erro ? 'error' : 'success', $messagem);

        return redirect()->back();
    }

    public function edit(Request $request, VacationPlan $vacationPlan)
    {
        if (!$vacationPlan->verification()) {
            $erro = 1;
            $messagem = 'You do not have access to this plan!';

            if ($request->ajax()) {
                return ['error' => $erro, 'message' => $messagem];
            }

            session()->flash($erro ? 'error' : 'success', $messagem);

            return redirect()->route('plan.index');
        }

        if ($request->ajax()) {
            return $vacationPlan->toArray();
        }
        $vacationPlan->date_initial = $vacationPlan->getdate('date_initial');
        $vacationPlan->date_final =  $vacationPlan->getdate('date_final');

        return view('panel.vacation.edit', ['model' => $vacationPlan]);
    }

    public function show(Request $request, VacationPlan $vacationPlan)
    {

        if (!$vacationPlan->verification()) {
            $erro = 1;
            $messagem = 'You do not have access to this plan!';

            if ($request->ajax()) {
                return ['error' => $erro, 'message' => $messagem];
            }

            session()->flash($erro ? 'error' : 'success', $messagem);

            return redirect()->route('plan.index');
        }

        return view('panel.vacation.show', ['model' => $vacationPlan, 'ajax' => $request->ajax()]);
    }

    public function destroy(Request $request, VacationPlan $vacationPlan)
    {

        $erro = 0;
        $messagem = 'Plan removed successfully!';

        if (!$vacationPlan->verification()) {
            $erro = 1;
            $messagem = 'You do not have access to this plan!';

            if ($request->ajax()) {
                return ['error' => $erro, 'message' => $messagem];
            }

            session()->flash($erro ? 'error' : 'success', $messagem);

            return redirect()->route('plan.index');
        }

        if (!$vacationPlan->delete()) {
            $erro = 1;
            $messagem = 'An error occurred while saving the vacation plan!';
        }

        if ($request->ajax()) {
            return ['error' => $erro, 'message' => $messagem];
        }

        session()->flash($erro ? 'error' : 'success', $messagem);

        return redirect()->back();
    }

    private function formValidate(Request $request)
    {
        $validador = Validator::make($request->all(),  [
            'title'        => "required",
            'description'  => 'required',
            'date_initial' => 'required|date',
            'date_final'   => 'required|date',
            'location'     => 'required',
            'participant'  => 'nullable',
        ]);

        if ($request->ajax() && $validador->errors()->count() > 0) {
            return ['error' => 1, 'message' => implode("\n", $validador->errors()->all())];
        }

        return $validador->validate();
    }
}
