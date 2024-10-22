{{-- @extends('layouts.app') --}}
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="container" style="margin-top:10px; background-color: white; border: 1px solid #ccc; border-radius: 10px;">
            <div class="container">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h1>

                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('student.list') }}"> Back</a>
                </div>
                <form onsubmit="handleFormSubmit(event)">
                    @csrf
                    <div class="p-3">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="student_name">Student Name</label>
                                    <input type="text" name="student_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="class_teacher_id">Class Teacher</label>
                                    <select name="class_teacher_id" id="class_teacher_id" class="form-control">
                                        <option value="">Select a teacher</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <input type="text" name="class" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="admission_date">Admission Date</label>
                                    <input type="date" name="admission_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="yearly_fees">Yearly Fees</label>
                                    <input step="any" type="number" name="yearly_fees" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            function loadTeachers() {
                fetch('http://127.0.0.1:8000/api/student/teacher') // Replace with your API URL
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json(); // Convert response to JSON
                    })
                    .then(data => {
                        const teachersData = data.data
                        console.log("data", teachersData);
                        populateTeachesrDropdown(teachersData); // Call the function to populate the dropdown
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }

            function populateTeachesrDropdown(teachers) {
                // dropdown.innerHTML = '<option value="">Select a Teacher</option>';
                const dropdown = document.getElementById("class_teacher_id");

                teachers.forEach(teacher => {
                    const option = document.createElement('option');
                    option.value = teacher.id;
                    option.text = teacher.name;
                    dropdown.appendChild(option);
                });
            }

            const handleFetch = () => {
                $.ajax({
                    url: "{{ route('handle.get.student.update', ['id' => $id]) }}",
                    method: 'GET',
                    success: function(response) {
                        const data = response.data;
                        document.querySelector('[name=student_name]').value = data.student_name;
                        document.querySelector('[name=class_teacher_id]').value = data.class_teacher_id;
                        document.querySelector('[name=class]').value = data.class;
                        document.querySelector('[name=admission_date]').value = data.admission_date;
                        document.querySelector('[name=yearly_fees]').value = data.yearly_fees;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            loadTeachers();
            setTimeout(() => {
                handleFetch();
            }, 500);

            const handleFormSubmit = (event) => {
                event.preventDefault();
                const form = new FormData(event.target);

                const data = {
                    _token: "{{ csrf_token() }}",
                    student_name: form.get('student_name'),
                    class_teacher_id: form.get('class_teacher_id'),
                    class: form.get('class'),
                    admission_date: form.get('admission_date'),
                    yearly_fees: form.get('yearly_fees')
                }

                $.ajax({
                    url: "{{ route('handle.student.update', ['id' => $id]) }}",
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        alert(response.message);
                        window.location = "{{ route('student.list') }}"
                    },
                    error: function(xhr, status, error) {
                        alert(response.message);
                    }
                });
            }
        </script>
    @endsection
</x-app-layout>
