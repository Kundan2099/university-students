@extends('pages.layouts.app')

@section('content')
    <div class="container" style="margin-top:10px;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Class Teacher</th>
                    <th>Class</th>
                    <th>Admission Date</th>
                    <th>Yearly Fees</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">

            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const fetchStudents = async () => {
            try {
                const response = await fetch('http://127.0.0.1:8000/api/student');
                const students = await response.json();

                console.log(students);


                students.data.forEach((student) => {
                    let tr = document.createElement('tr');

                    let td1 = document.createElement('td');
                    td1.innerHTML = student.student_name;
                    tr.appendChild(td1);

                    let td2 = document.createElement('td');
                    td2.innerHTML = student?.teacher?.name;
                    tr.appendChild(td2);

                    let td3 = document.createElement('td');
                    td3.innerHTML = student.class;
                    tr.appendChild(td3);

                    let td4 = document.createElement('td');
                    td4.innerHTML = student.admission_date;
                    tr.appendChild(td4);

                    let td5 = document.createElement('td');
                    td5.innerHTML = student.yearly_fees;
                    tr.appendChild(td5);

                    let td6 = document.createElement('td');
                    td6.innerHTML = `
                        <a href="/student/update/${student.id}" class="btn btn-primary edit-btn">Edit</a>
                        <button onclick="handleDelete('${student.id}')" class="btn btn-danger delete-btn">Delete</button>
                    `;
                    tr.appendChild(td6);

                    document.getElementById('table-body').appendChild(tr);
                });

                $('#example').DataTable();

            } catch (error) {
                console.error('Error fetching students:', error);
            }
        };

        const handleDelete = (id) => {
            if (confirm('Are you sure to delete this ?')) {
                $.ajax({
                    url: `{{ url('delete/student') }}/${id}`,
                    method: 'GET',
                    success: function(response) {
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert(error.message);
                    }
                });
            }
        }

        const editStudent = (id) => {
            // Logic to edit student data
            alert('Edit student with ID: ' + id);
        };

        const deleteStudent = (id) => {
            // Logic to delete student data
            alert('Delete student with ID: ' + id);
        };

        $(document).ready(function() {
            fetchStudents();
        });
    </script>
@endsection
