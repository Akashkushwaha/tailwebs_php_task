const protocol = window.location.protocol;
const hostname = window.location.hostname;
const port = window.location.port ? ":" + window.location.port : "";

var main_url = protocol + "//" + hostname + port;

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isValidEmail = (email) => emailRegex.test(email);

function isNumeric(event) {
    var charCode = event.which || event.keyCode;

    if (charCode >= 48 && charCode <= 57) {
        return true;
    }

    // Disallow all other characters
    return false;
}

function isAlpha(event) {
    var charCode = event.which || event.keyCode;

    if (
        (charCode >= 65 && charCode <= 90) ||
        (charCode >= 97 && charCode <= 122) ||
        charCode == 32
    ) {
        return true;
    }

    return false;
}

function isAlphaNumeric(event) {
    var charCode = event.which || event.keyCode;

    if (
        (charCode >= 48 && charCode <= 57) ||
        (charCode >= 65 && charCode <= 90) ||
        (charCode >= 97 && charCode <= 122) ||
        charCode == 32
    ) {
        return true;
    }

    return false;
}

function check_validation(e, form_type) {
    e.preventDefault();

    var registration_type_master = [1, 2];

    var registration_form = document.getElementById("registration");
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    if (form_type == 1) {
        var registration_type =
            document.getElementById("registration_type").value;
        var username = document.getElementById("username").value.trim();

        if (
            registration_type_master.includes(parseInt(registration_type)) ===
            false
        ) {
            alert("Invalid Registration Type");
            return false;
        }

        if (username == "") {
            alert("Username cannot be empty");
            return false;
        }
    }

    if (email == "") {
        alert("Email cannot be empty");
        return false;
    }

    if (isValidEmail(email) === false) {
        alert("Invalid email format");
        return false;
    }

    if (password == "") {
        alert("Password cannot be empty");
        return false;
    }

    registration_form.submit();
}

function getAssessmentRecords() {
    var record = document.getElementById("records");

    const url = main_url + "/" + "get-student-records";

    const xhttp = new XMLHttpRequest();

    var html = "";
    xhttp.onload = function () {
        var result = JSON.parse(this.response);
        if (result.status == 0) {
            html +=
                "<div class='col-12 col-sm-12 px-3'><h3 class='text-danger'>No record found.</h3></div>";
        } else {
            var records = result.data;
            html += "<div class='col-12 col-sm-12'><div class='container'>";
            html +=
                "<div class='row'>" +
                "<div class='col col-4 col-sm-4 py-3 font-weight-bold'>Student Name</div>" +
                "<div class='col col-4 col-sm-4 py-3 font-weight-bold'>Subject</div>" +
                "<div class='col col-2 col-sm-2 py-3 font-weight-bold'>Marks</div>" +
                "<div class='col col-2 col-sm-2 py-3 font-weight-bold'>Action</div></div>";
            records.forEach((item) => {
                html += `
                <div class="row">
                <div class="col col-4 col-sm-4 py-3" id="student${item.id}">${item.student}</div>
                <div class="col col-4 col-sm-4 py-3" id="subject${item.id}">${item.subject}</div>
                <div class="col col-2 col-sm-2 py-3" id="marks${item.id}">${item.marks}</div>
                <div class="col col-2 col-sm-2 py-3">
                <span class="mx-2" onclick="showDialog(${item.id})"><img src="${main_url}/images/edit-icon.png" style="width:20px;height:20px"></span>
                <span onclick="deleteRecord(${item.id})"><img src="${main_url}/images/delete-icon.png" style="width:20px;height:20px"></span>
                </div>
                </div>
                `;
            });
            html += "</div></div>";
        }
        record.innerHTML = html;
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

if (["/dashboard"].includes(window.location.pathname)) {
    getAssessmentRecords();
}

function showDialog(edit_type = 0) {
    document.getElementById("student_name").value = "";
    document.getElementById("subject").value = "";
    document.getElementById("marks").value = "";

    if (edit_type > 0) {
        console.log(edit_type);
        var edit_student_name = document.getElementById(
            "student" + edit_type
        ).innerHTML;
        var edit_subject = document.getElementById(
            "subject" + edit_type
        ).innerHTML;
        var edit_marks = document.getElementById("marks" + edit_type).innerHTML;
        document.getElementById("student_name").value = edit_student_name;
        document.getElementById("subject").value = edit_subject;
        document.getElementById("marks").value = edit_marks;
        document.getElementById("addRecord").innerHTML = "Update Record";
        document.getElementById("dialog-heading").innerHTML = "Edit Record";
    }

    document.getElementById("myDialog").showModal();
}

function edit_record() {
    var student_name = document.getElementById("student_name").value.trim();
    var subject = document.getElementById("subject").value.trim();
    var marks = document.getElementById("marks").value.trim();
    var token = document.querySelector('input[name="_token"]').value.trim();

    if (student_name == "") {
        alert("Student name cannot be empty");
        return false;
    }

    if (subject == "") {
        alert("Subject cannot be empty");
        return false;
    }

    if (marks == "") {
        alert("Marks cannot be empty");
        return false;
    }

    if (marks > 100) {
        alert("Marks cannot be greater than 100");
        return false;
    }

    var requst_data = JSON.stringify({
        student_name: student_name,
        subject: subject,
        marks: marks,
    });

    const url = main_url + "/" + "edit-record";
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
        var result = JSON.parse(this.response);
        if (result.status == 1) {
            getAssessmentRecords();
            document.getElementById("myDialog").close();
        } else {
            alert(result.message);
        }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.setRequestHeader("X-CSRF-TOKEN", token);
    xhttp.send(requst_data);
}

function deleteRecord(record_id = 0) {
    var token = document.querySelector('input[name="_token"]').value.trim();

    if (record_id > 0) {
        if (confirm("Are you sure you want to delete this record?")) {
            var requst_data = JSON.stringify({
                record_id: record_id,
            });

            const url = main_url + "/" + "delete-record";
            const xhttp = new XMLHttpRequest();

            xhttp.onload = function () {
                var result = JSON.parse(this.response);
                if (result.status == 1) {
                    getAssessmentRecords();
                } else {
                    alert(result.message);
                }
            };
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/json");
            xhttp.setRequestHeader("X-CSRF-TOKEN", token);
            xhttp.send(requst_data);
        } else {
            return false;
        }
    }
}

function logout() {
    if(confirm("Are you sure you want to logout")) {
        document.getElementById("logout-form").submit();
    } else {
        return false;
    }
}
