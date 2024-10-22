<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

interface StudentInterface
{
    public function handleGetStudent();
    public function handleGetTeacher();
    public function handlePostStudentCreate(Request $request);
    public function handleGetStudentUpdate($id);
    public function handlePostStudentUpdate(Request $request, $id);
    public function handleStudentDelete($id);
}

class StudentController extends Controller implements StudentInterface
{
    /**
     * Handle Get Student
     *
     * @return Response
     */
    public function handleGetStudent(): Response
    {
        try {
            $students = Student::with('teacher')->get();

            return $this->sendResponseOk('Student successfully fetched', $students);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Get Teacher
     *
     * @return Response
     */
    public function handleGetTeacher(): Response
    {
        try {
            $teachers = Teacher::all();

            return $this->sendResponseOk('Teacher successfully fetched', $teachers);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Student Create
     *
     * @return Response
     */
    public function handlePostStudentCreate(Request $request): Response
    {
        try {
            $validation = Validator::make($request->all(), [
                'student_name' => ['required', 'string', 'max:255'],
                'class_teacher_id' => ['nullable', 'exists:teachers,id'],
                'class' => ['required', 'string', 'max:255'],
                'admission_date' => ['nullable', 'string'],
                'yearly_fees' => ['required', 'numeric'],
            ]);

            if ($validation->fails()) {
                return $this->sendValidationError('Validation Error', $validation->errors());
            }

            $student = new Student();
            $student->student_name = $request->input('student_name');
            $student->class_teacher_id = $request->input('class_teacher_id');
            $student->class = $request->input('class');
            $student->admission_date = $request->input('admission_date');
            $student->yearly_fees = $request->input('yearly_fees');
            $student->save();

            return $this->sendResponseCreated('Student created successfully', $student);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Get Student Update
     *
     * @return Response
     */
    public function handleGetStudentUpdate($id): Response
    {
        try {

            $student = Student::find($id);

            return $this->sendResponseOk('Student successfully fetched', $student);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Post Student Update
     *
     * @return Response
     */
    public function handlePostStudentUpdate(Request $request, $id): Response
    {
        try {

            $student = Student::find($id);

            $validation = Validator::make($request->all(), [
                'student_name' => ['required', 'string', 'max:255'],
                'class_teacher_id' => ['required', 'exists:teachers,id'],
                'class' => ['required', 'string', 'max:255'],
                'admission_date' => ['required', 'date'],
                'yearly_fees' => ['required', 'numeric'],
            ]);

            if ($validation->fails()) {
                return $this->sendValidationError('Validation Error', $validation->errors());
            }

            $student->student_name = $request->input('student_name');
            $student->class_teacher_id = $request->input('class_teacher_id');
            $student->class = $request->input('class');
            $student->admission_date = $request->input('admission_date');
            $student->yearly_fees = $request->input('yearly_fees');
            $student->update();

            return $this->sendResponseOk('Student successfully updated', $student);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handl Student Delete
     *
     * @return Response
     */
    public function handleStudentDelete($id): Response
    {
        try {
            $student = Student::find($id);

            $student->delete();

            return $this->sendResponseOk('Student successfully deleted', null);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }
}
