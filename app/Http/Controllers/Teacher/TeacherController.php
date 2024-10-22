<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

interface TeacherInterface
{
    public function handleGetTeacher();
    public function handlePostTeacherCreate(Request $request);
    public function handleGetTeacherUpdate($id);
    public function handlePostTeacherUpdate(Request $request, $id);
    public function handleTeacherDelete($id);
}

class TeacherController extends Controller implements TeacherInterface
{
    /**
     * Handle Get Teacher
     *
     * @return Response
     */
    public function handleGetTeacher(): Response
    {
        try {
            $teacher = Teacher::all();

            return $this->sendResponseOk('Teacher successfully fetched', $teacher);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Post Teacher Create
     *
     * @return Response
     */
    public function handlePostTeacherCreate(Request $request): Response
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return $this->sendValidationError('Validation Error', $validation->errors());
                // return $this->sendValidationError($validation->errors()->first(), $validation->errors()->getMessages());
            }

            $teacher = new Teacher();
            $teacher->name = $request->input('name');
            $teacher->save();

            return $this->sendResponseCreated('Teacher created successfully', $teacher);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Get Teacher Update
     *
     * @return Response
     */
    public function handleGetTeacherUpdate($id): Response
    {
        try {
            $teacher = Teacher::find($id);

            return $this->sendResponseOk('Teacher successfully fetched', $teacher);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handle Post Teacher Update
     *
     * @return Response
     */
    public function handlePostTeacherUpdate(Request $request, $id): Response
    {
        try {

            $teacher = Teacher::find($id);

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validation->fails()) {
                return $this->sendValidationError('Validation Error', $validation->errors());
                // return $this->sendValidationError($validation->errors()->first(), $validation->errors()->getMessages());
            }

            $teacher->name = $request->input('name');
            $teacher->update();

            return $this->sendResponseOk('Teacher successfully updated', $teacher);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }

    /**
     * Handl Teacher Delete
     *
     * @return Response
     */
    public function handleTeacherDelete($id): Response
    {
        try {
            $teacher = Teacher::find($id);
            $teacher->delete();

            return $this->sendResponseOk('eacher successfully deleted', $teacher);
        } catch (Exception $exception) {
            return $this->sendExceptionError($exception);
        }
    }
}
