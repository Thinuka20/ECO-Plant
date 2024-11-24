function payOption() {
  var op = document.getElementById("paySelect");
  var combo = document.getElementById("pay_status").value;
  var combo2 = document.getElementById("pay_method");
  var op2 = document.getElementById("cnn");

  if (combo == "01") {
    op.className = "col-lg-3 d-block";
    combo2.className = "d-block";
    
  } else {
    op.className = "d-none";
    combo2.className = "d-none";
    op2.className = "d-none";
  }
}

function payMethod() {
  var op = document.getElementById("cnn");
  var text = document.getElementById("idn");
  var combo = document.getElementById("pay_method2").value;

  if (combo == "01" ) {
    op.className = "col-lg-3 d-block";
  } else {
    op.className = "d-none";
    text.value = "";
  }
}

function login() {
  var uname = document.getElementById("uname").value;
  var pw = document.getElementById("pw").value;

  var form = new FormData();

  form.append("un", uname);
  form.append("p", pw);

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "admin") {
        window.location.href = "dashboard.php";
      } else if (res == "user") {
        window.location.href = "stock.php";
      } else {
        alert(res);
      }
    }
  };
  req.open("POST", "loginProcess.php", true);
  req.send(form);
}

var bm;

function forgotPassword() {
  var username = document.getElementById("uname");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        var modal = document.getElementById("forgotpassword");
        bm = new bootstrap.Modal(modal);
        bm.show();
      } else {
        alert(t);
      }
    }
  };
  r.open("GET", "forgotPasswordProcess.php?u=" + username.value, true);
  r.send();
}

function resetPassword() {
  var username = document.getElementById("uname");
  var fp = document.getElementById("fp");
  var fp2 = document.getElementById("fp2");
  var vc = document.getElementById("vc");

  var f = new FormData();
  f.append("username", username.value);
  f.append("fp", fp.value);
  f.append("fp2", fp2.value);
  f.append("vc", vc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        bm.hide();
        alert("Your Password has been updated successfully");
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "resetPasswordProcess.php", true);
  r.send(f);
}

function showPassword4() {
  var up = document.getElementById("fp");
  var upb = document.getElementById("fpb");

  if (up.type == "password") {
    up.type = "text";
    upb.innerHTML = '<i class=""bi bi-eye-fill""></i>';
  } else {
    up.type = "password";
    upb.innerHTML = '<i class=""bi bi-eye-slash-fill""></i>';
  }
}

function showPassword5() {
  var up = document.getElementById("fp2");
  var upb = document.getElementById("fpb2");

  if (up.type == "password") {
    up.type = "text";
    upb.innerHTML = '<i class=""bi bi-eye-fill""></i>';
  } else {
    up.type = "password";
    upb.innerHTML = '<i class=""bi bi-eye-slash-fill""></i>';
  }
}

function signOut() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.href = "index.php";
      } else {
        alert(res);
      }
    }
  };
  req.open("GET", "signOutProcess.php", true);
  req.send();
}

var supid;

function supdetails(id) {
  supid = id;
  var mbody = document.getElementById("modal_body");
  var m = document.getElementById("sup_details");
  cam = new bootstrap.Modal(m);
  cam.show();

  mbody.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  mbody.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var txt = request.responseText;

      mbody.innerHTML = txt;
      mbody.className = "modal-body";
    }
  };

  request.open("GET", "supdetails.php?id=" + supid, true);
  request.send();
}

function memberDetails(memberid) {
  var memberid = memberid;
  var m = document.getElementById("view_c");
  cam = new bootstrap.Modal(m);
  cam.show();

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var txt = request.responseText;

      document.getElementById("modal_body").innerHTML = txt;
    }
  };

  request.open("GET", "teammember.php?id=" + memberid, true);
  request.send();
}

var customerid;

function customerDetails(id) {
  customerid = id;
  var m = document.getElementById("view_c");
  var modelbody = document.getElementById("modal_body");
  cam = new bootstrap.Modal(m);
  cam.show();

  modelbody.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";

  modelbody.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      var txt = request.responseText;
      modelbody.className = "modal-body";

      modelbody.innerHTML = txt;
    }
  };

  request.open("GET", "customerdetails.php?id=" + customerid, true);
  request.send();
}

function customerInvoice(){
  window.location.href = "customerinvoice.php?invoice_id=" + customerid;
}

var cam;
function openModelS() {
  var m = document.getElementById("add_supplier");
  cam = new bootstrap.Modal(m);
  cam.show();
}

function addNewSupplier() {
  var s_name = document.getElementById("s_name");
  var s_mobile = document.getElementById("s_mobile");
  var s_address = document.getElementById("s_address");
  var modalm = document.getElementById("add_new_sm");
  var mbody = document.getElementById("mbody");

  mbody.className = "d-none";

  modalm.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  modalm.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';

  var form = new FormData();

  form.append("sn", s_name.value);
  form.append("sm", s_mobile.value);
  form.append("sad", s_address.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.reload();
      } else {
        alert(res);
        modalm.className = "d-none";

        mbody.className = "modal-body";
      }
    }
  };
  req.open("POST", "insertNewSupplierProcess.php", true);
  req.send(form);
}

function addSPayment() {
  // alert(supid);
  var due = document.getElementById("due");
  var dueAddNewPay = document.getElementById("due_02_add_pay");
  dueAddNewPay.innerHTML = due.innerHTML;
}
function addPay() {
  var amount = document.getElementById("amount_s").value;
  var modalm = document.getElementById("model_add_pay");
  var modello = document.getElementById("model_add_pay_lo");

  modalm.className = "d-none";
  modello.className =
    "modal-body d-block col-12 d-flex flex-column align-items-center justify-content-center";
  modello.innerHTML =
  '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';
  var form = new FormData();

  form.append("am", amount);
  form.append("sid", supid);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res = "done") {
        window.location.reload();
      } else {
        alert(res);
        modalm.className = "d-block modal-body";
        modello.className = "d-none";
      }
    }
  };
  req.open("POST", "addNewPaymentProcess.php", true);
  req.send(form);
}

function addinProduct() {
  var agent = document.getElementById("agent").value;
  var invoice_id = document.getElementById("invoiceno").value;
  var fName = document.getElementById("fname").value;
  var lName = document.getElementById("lname").value;
  var mobile = document.getElementById("mobile").value;
  var address = document.getElementById("address").value;
  // new
  var nic= document.getElementById("nic").value;
  var systemCap= document.getElementById("sc").value;
  var systemPrice= document.getElementById("sp").value;
  var pStatus= document.getElementById("pay_status").value;
  var paidAmount= document.getElementById("amount").value;
  var discount= document.getElementById("ds").value;
  var dPrice= document.getElementById("damount").value;
  var pMethod= document.getElementById("pay_method2").value;
  var idintifi= document.getElementById("idn").value;

  var f = new FormData();
  f.append("nic", nic);
  f.append("systemCap", systemCap);
  f.append("systemPrice", systemPrice);
  f.append("agent", agent);
  f.append("invoice_id", invoice_id);
  f.append("fName", fName);
  f.append("lName", lName);
  f.append("mobile", mobile);
  f.append("address", address);
  f.append("pStatus", pStatus);
  f.append("paidAmount", paidAmount);
  f.append("discount", discount);
  f.append("dPrice", dPrice);
  f.append("pMethod", pMethod);
  f.append("idintifi", idintifi);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;

      if (t == "success") {
        window.open("invoicepdf.php?invoiceno=" + invoice_id, '_blank');
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "addinvoice.php", true);
  r.send(f);
}

function updateTotal() {
  var discount = document.getElementById("ds").value;
  var subtotal = document.getElementById("sp").value;

  var total = subtotal - discount;
  document.getElementById("damount").value = total; // Assuming you want to display the total with two decimal places
}




function updatePayment() {
  var oTable = document.getElementById("intable");

  // Gets rows of table
  var rowLength = oTable.rows.length;
  var form = new FormData();
  form.append("rows", rowLength);
  // Loops through rows
  for (var i = 1; i < rowLength; i++) {
    // Gets cells of current row
    var oCells = oTable.rows.item(i).cells;

    // Gets the input element within the third cell of current row (if exists)
    var inputElement = oCells.item(2).querySelector("input");
    var pid = oCells.item(0).innerHTML;
    form.append("p"+i, pid);

    // Gets the value of the input element (if exists)
    var inputValue = inputElement ? inputElement.value : "";
    form.append("q" + i, inputValue);

    // Logs the value of the input element

  }

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {
      var res = req.responseText;

        alert(res);     

    }
  };

  req.open("POST", "printProcess2.php", true);
  req.send(form);


}



function addNewStock() {
  var product = document.getElementById("product");
  var supplier = document.getElementById("supplier");
  var price = document.getElementById("price");
  var qty = document.getElementById("qty");
  var nProduct = document.getElementById("newProduct");
  var dateS = document.getElementById("dateS");

  var model_add_s = document.getElementById("add_s_m");
  var lodingM = document.getElementById("loding_mo");

  lodingM.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  model_add_s.className = "d-none";

  var form = new FormData();
  form.append("p", product.value);
  form.append("s", supplier.value);
  form.append("pr", price.value);
  form.append("q", qty.value);
  form.append("d", dateS.value);
  form.append("n", nProduct.value);

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.reload();
      } else {
        lodingM.className = "d-none";
        model_add_s.className = "d-block modal-body";
        alert(res);
      }
    }
  };
  req.open("POST", "addStockProcess.php", true);
  req.send(form);
}

function addexpenses() {
  var expenses_type = document.getElementById("expenses_type");
  var amount = document.getElementById("amount");
  var date = document.getElementById("date_ex");

  var form = new FormData();
  form.append("e", expenses_type.value);
  form.append("a", amount.value);
  form.append("d", date.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if ((res = "sucess")) {
        window.location.reload();
      } else {
        alert(res);
      }
    }
  };
  req.open("POST", "addExpensesProcess.php", true);
  req.send(form);
}
function addNewPosition() {
  var newPostion = document.getElementById("newPostion");
  var spinner =
    '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>';
  var addbtn = document.getElementById("add");

  if (newPostion.value == "") {
  } else {
    addbtn.innerHTML = spinner + " Wait";
  }

  var form = new FormData();
  form.append("np", newPostion.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        $("#po").load(location.href + " #po");
        newPostion.value = "";
        addbtn.innerHTML = "Add";
      } else {
        addbtn.innerHTML = "Add";
        alert(res);
      }
    }
  };
  req.open("POST", "addNewPosition.php", true);
  req.send(form);
}

function addMember() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var address = document.getElementById("address");
  var position = document.getElementById("position");
  var nic = document.getElementById("nic");
  var status = document.getElementById("status");

  var lodingModel = document.getElementById("lodingModel");
  var formModel = document.getElementById("formModel");

  formModel.className = "d-none";
  lodingModel.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  lodingModel.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';

  var form = new FormData();
  form.append("fn", fname.value);
  form.append("ln", lname.value);
  form.append("ad", address.value);
  form.append("mo", mobile.value);
  form.append("po", position.value);
  form.append("ni", nic.value);
  form.append("st", status.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.reload();
        formModel.className = "d-block";
        lodingModel.className = "d-none";
      } else {
        alert(res);
        formModel.className = "d-block";
        lodingModel.className = "d-none";
      }
    }
  };
  req.open("POST", "addTeamMemberProcess.php", true);
  req.send(form);
}
var res1;
function memberDetails(id) {
  var tid = id;
  var viewm = document.getElementById("view_m");
  viewm.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  viewm.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      res1 = req.responseText;
      viewm.className = "modal-body";
      viewm.innerHTML = res1;
    }
  };
  req.open("GET", "viewTeamDetailProcess.php?id=" + tid, true);
  req.send();
}

function updateMember() {
  var fname = document.getElementById("fn");
  var lname = document.getElementById("ln");
  var mob = document.getElementById("mob");
  var add = document.getElementById("addr");
  var pos = document.getElementById("pos");
  var nic = document.getElementById("ni");
  var st = document.getElementById("st");
  var viewm = document.getElementById("view_m");
  viewm.className =
    "d-block col-12 d-flex flex-column align-items-center justify-content-center";
  viewm.innerHTML =
    '<div class="row"><div class="col-12"><div class="spinner2 ms-4 mt-5"><div></div><div></div><div></div><div></div><div></div><div></div></div><br><div><h5 class="textP mt-2 mb-5">Please Wait...</h5></div></div></div>';

  var form = new FormData();
  form.append("fn", fname.value);
  form.append("ln", lname.value);
  form.append("m", mob.value);
  form.append("add", add.value);
  form.append("st", st.value);
  form.append("p", pos.value);
  form.append("ni", nic.value);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "sucess") {
        viewm.className = "modal-body";
        viewm.innerHTML = res1;
        window.location.reload();
      } else {
        alert(res);
        viewm.className = "modal-body";
        viewm.innerHTML = res1;
        viewm.hide();
      }
    }
  };
  req.open("POST", "updateMemberProcess.php", true);
  req.send(form);
}

function searchTransactions() {
  var startDate = document.getElementById('startDate').value;
  var endDate = document.getElementById('endDate').value;
  var form = new FormData();
  form.append("startDate", startDate);
  form.append("endDate", endDate);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      var table = $('#example').DataTable();
      table.destroy();
      document.getElementById('sum_table').innerHTML = res;
      $('#example').DataTable({
        layout: {
          topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
          }
        }
      });
    }
  };
  req.open("POST", "searchSummary.php", true);
  req.send(form);
}

function searchSummary() {
  var startDate = document.getElementById('startDate').value;
  var endDate = document.getElementById('endDate').value;
  var form = new FormData();
  form.append("startDate", startDate);
  form.append("endDate", endDate);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      var table = $('#example').DataTable();
      table.destroy();
      document.getElementById('sum_table').innerHTML = res;
      $('#example').DataTable({
        layout: {
          topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
          }
        }
      });
    }
  };
  req.open("POST", "searchSummary2.php", true);
  req.send(form);
}

function updateSalary() {
  var amount = document.getElementById('amount').value;
  var nic = document.getElementById("ni").value;

  var form = new FormData();
  form.append("amount", amount);
  form.append("nic", nic);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.reload();
      }else{
        alert(res);
      }

    }
  };
  req.open("POST", "salaryUpdateProcess.php", true);
  req.send(form);

}