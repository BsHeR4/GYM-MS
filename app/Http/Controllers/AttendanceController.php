<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Attendance;
use App\Models\Session;

class AttendanceController extends Controller
{

    public function index($id)
    {
        $session = Session::all()->where('id',$id) ;
        $attendances = Attendance::with('appointment')->paginate(10);

        return view('new-dashboard.attendance.list_attendances', compact('attendances'));
    }

    public function update($id , $type)
    {
        $appointment = Appointment::findOrFail($id);

        $attendance = $appointment->attendances->first();

        if ($attendance) {
            if($type){
                if($type==1)
                   $attendance->update(['status' => 'present']);
                else
                    $attendance->update(['status' => 'nnconfirmed']);
            }
            else
              $attendance->update(['status' => 'absent']);

            return back()->with('success', 'Attendance updated successfully.');
        }
        return redirect()->route('attendance.index,$id')->with('error', 'No attendance record found to update.');
    }


    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $attendance = $appointment->attendances->first();
       
        if ($attendance) {
            $attendance->delete();
            return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully.');
        }

        return redirect()->route('attendance.index')->with('error', 'No attendance record found to delete.');
    }
}
