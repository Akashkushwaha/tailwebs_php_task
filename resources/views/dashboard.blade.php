@extends("layouts.layout");

@section("content")
<div class="row p-3">
    <div class="col-12 col-sm-12 col-md-6">
        <button class="btn btn-crimson" onclick="showDialog(0)">Add Record</button>    
    </div>
    <dialog id="myDialog" style="margin: 100px auto">
        <div class="dialog-content">
            <h2 id="dialog-heading" class="text-danger py-4">Add record</h2>
            <div class="container">
                <div class="row">
                    @csrf
                    <div class="col-12 col-sm-12 py-2">
                        <input class="input-crimson" placeholder="e.g. John Doe" type="text" id="student_name" value="" onkeypress="return isAlpha(event)" name="student_name">
                    </div>
                    <div class="col-12 col-sm-12">
                        <input class="input-crimson" placeholder="e.g. Science" type="text" id="subject" value="" onkeypress="return isAlpha(event)" name="subject_name">
                    </div>
                    <div class="col-12 col-sm-12 py-2">
                        <input class="input-crimson" placeholder="Maximum 100" max="100" maxlength="3" minlength="1" min="0" type="text" id="marks" onkeypress="return isNumeric(event)" value="" name="marks">
                    </div>
                    <div class="col-12 col-sm-12">
                        <button class="btn btn-crimson" type="button" id="addRecord" onclick="edit_record()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dialog-buttons">
            <button class="btn btn-crimson" id="closeDialog" onclick="document.getElementById('myDialog').close()">Close</button>
        </div>
    </dialog>
</div>
<div class="row py-5" id="records"></div>
@endsection