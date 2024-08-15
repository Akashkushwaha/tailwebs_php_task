<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentSubjectWiseScore;
use Stringable;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('dashboard');
    }

    public function get_student_records()
    {
        $return_array = array('status' => 0, 'data' => array(), 'message' => '');

        $conditions = ['record_active' => '1', 'record_deleted' => 0];
        $getRecords = StudentSubjectWiseScore::select('id', 'student_name as student', 'subject', 'marks')
            ->where($conditions)
            ->orderBy('updated_at', 'DESC')
            ->get()->toArray();

        if (!empty($getRecords)) {
            $return_array['status'] = 1;
            $return_array['data'] = $getRecords;
        }

        return response()->json($return_array);
    }

    public function edit_record(Request $request)
    {
        $return_array = array('status' => 0, 'data' => array(), 'message' => '');
        $request->validate([
            'student_name' => 'required',
            'subject' => 'required',
            'marks' => 'required|numeric'
        ]);

        $student_name = $request->student_name;
        $subject = $request->subject;
        $marks = $request->marks;

        $update_data = ['student_name' => $student_name, 'subject' => $subject, 'marks' => $marks, 'record_active' => 1, 'record_deleted' => 0];

        $conditions = ['student_name' => $student_name, 'subject' => $subject];

        $findRecord = StudentSubjectWiseScore::select('id')
            ->where($conditions)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->toArray();

        if (!empty($findRecord)) {
            $id = $findRecord[0]['id'];
            $update_record = StudentSubjectWiseScore::where('id', $id)->update($update_data);
        } else {
            $update_record = StudentSubjectWiseScore::create($update_data);
        }

        if ($update_record) {
            $return_array['status'] = 1;
        } else {
            $return_array['message'] = "Something went wrong. Try again later.";
        }
        return response()->json($return_array);
    }

    public function delete_record(Request $request)
    {
        $return_array = array('status' => 0, 'data' => array(), 'message' => '');
        $request->validate([
            'record_id' => 'required|numeric'
        ]);

        $record_id = $request->record_id;

        $update_data = ['record_active' => 0, 'record_deleted' => 1];

        $conditions = ['id' => $record_id, 'record_active' => 1, 'record_deleted' => 0];

        $findRecord = StudentSubjectWiseScore::select('id')
            ->where($conditions)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get()->toArray();

        if (!empty($findRecord)) {
            $id = $findRecord[0]['id'];
            $update_record = StudentSubjectWiseScore::where('id', $id)->update($update_data);
            if ($update_record) {
                $return_array['status'] = 1;
            } else {
                $return_array['message'] = "Something went wrong. Try again later.";
            }
        } else {
            $return_array['message'] = "Record not found";
        }

        return response()->json($return_array);
    }
}
