@extends('layouts.app')

@section('content')

<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script><!-- sweetalert2-->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script><!-- axios-->

@if(Session::has('success'))
<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'จ่ายยาเรียบร้อยแล้ว',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

<html>
<style>
    .dataTables_filter {
        float: right;
        margin-right: 25px;
    }

    .dataTables_info {
        float: left;
        margin-left: 25px;
    }

    .dataTables_paginate {
        float: right;
        margin-right: 20px;
    }
</style>

</html>
<meta http-equiv="refresh" content="30">
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <p id="demo" class="text-right"></p>
                <!-- Light table -->
                <div class="table-responsive">
                    <!-- <div class="card-header border-0">
                        <h3 class="mb-0">Light table</h3>
                    </div> -->
                    <table class="table align-items-center table-flush dtab">
                        <div class="card-header border-0">
                            <div class="text-left">
                                <h3 class="mb-0">ตารางคนไข้เตรียมจ่ายยา(กระดูก)&nbsp;</h3>
                            </div>
                        </div>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort text-center" data-sort="name">ลำดับ</th>
                                <th scope="col" class="sort text-center" data-sort="name">ชื่อ-นามสกุล</th>
                                <th scope="col" class="sort text-center" data-sort="nickname">ชื่อเล่น</th>
                                <th scope="col" class="sort text-center" data-sort="sex">เพศ</th>
                                <th scope="col" class="sort text-center" data-sort="tel">เบอร์โทร</th>
                                <th scope="col" class="sort text-center" data-sort="address">ที่อยู่</th>
                                <th scope="col" class="sort text-center" data-sort="lineid">ไลน์ไอดี</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($data['patientlog'] as $row)
                            <tr>
                                <td class="text-center">
                                    {{$loop->index+1}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> name}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> nickname}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> sexname -> sex_name}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> tel}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> address}}
                                </td>
                                <td class="text-center">
                                    {{$row -> patient_list -> line_id}}
                                </td>
                                <td class="text-right">
                                    <a href="#" data-target="#showdoneDetail" data-toggle="modal" data-patientId="{{ $row -> patient_id }}" title="รายละเอียด" class="btn btn-primary btnDetail"><i class="fa-solid fa-prescription"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showdoneDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดการรักษา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('dispenseBone')}}" id="form1" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> รหัสคนไข้ </label>
                            <input type="text" name="patientid" id="patientid" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label> ชื่อ </label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> วันที่ตรวจ </label>
                            <input type="text" name="dateHitsoryInModal" id="dateHitsoryInModal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>

                        </div>
                        <div class="form-group col-md-6">
                            <label> วันที่นัดครั้งถัดไป </label>
                            <input type="text" name="nextDateInModal" id="nextDateInModal" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                    <label> อาการ </label>
                    <textarea class="form-control" id="patientSymptomsInModal" name="patientSymptomsInModal" rows="3" readonly></textarea>
                    <input type="text" name="patientSymptomsInModal" id="patientSymptomsInModal" class="form-control">
                </div> -->

                    <label> รายการยา </label>
                    <div class="table-responsive">
                        <table id="drugTab" class="table table-bordered table-sm align-items-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort text-center" style="width: 20%">ลำดับ</th>
                                    <th scope="col" class="sort text-center" style="width: 60%">ชื่อยา</th>
                                    <th scope="col" class="sort text-center" style="width: 20%">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody class="list">

                            </tbody>
                        </table>
                        <input type="hidden" id="drug_id" name="drug_id">
                        <input type="hidden" id="drug_qty" name="drug_qty">
                        <input type="hidden" id="stock_id" name="stock_id">
                        <input type="hidden" id="order_id" name="order_id">
                    </div>
                    <div class="form-group row">
                        <label>ราคายา :</label>
                        <div class="col-sm-2"><input type="text" name="grandtotal" id="grandtotal" class="form-control" value="" readonly></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-primary' id="genStockId" title="จ่ายยา" onclick='dispenseBoneSwal()'>จ่ายยา</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </form>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button> -->
            </div>
        </div>
    </div>
</div>


<!-- Argon Scripts -->
<!-- Core -->
<script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/js-cookie/js.cookie.js"></script>
<script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>

<!-- Argon JS -->
<script src="../assets/js/argon.js?v=1.2.0"></script>
<script src="../assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Datatable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js|https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script type="text/javascript">
    var isSetTimmeoutRunning = false;
    function startCountdown() {
        if (isSetTimmeoutRunning == false) {
            var userInput = parseInt(30);
            if (userInput >= 1) {
                isSetTimmeoutRunning = true;
                var userMilliseconds = userInput * 1000;
                setTimeout(function() {
                    isSetTimmeoutRunning = false;
                }, userMilliseconds);
                var counter = userInput;
                document.getElementById("demo").innerHTML = "<b> ระบบจะรีเฟรชหน้านี้ในอีก " + counter + " วินาที </b>";
                var interval = setInterval(function() {
                    counter--;
                    document.getElementById("demo").innerHTML = "<b> ระบบจะรีเฟรชหน้านี้ในอีก " + counter + " วินาที </b>";
                    if (counter == 0) {
                        document.getElementById("demo").innerHTML = "";
                        clearInterval(interval);
                    }
                }, 1000);
            }
        }
    }
    $(document).ready(function() {
        startCountdown();
        setTimeout(function() {
            countLog();
            window.setTimeout(function() {
                window.location.reload();
                // alert("refresh !");
            }, 30000);
        }, 3000);
    });

    function countLog() {
        var _token = $('input[name="_token"').val();
        $.ajax({
            url: "{{route('countLog')}}",
            method: "POST",
            data: {
                type: 1,
                status: 2,
                _token: _token
            },
            dataType: "json",
            success: function(result) {
                console.log(result.count_data);
                var count_data = result.count_data;
                if (count_data > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'มีคนไข้รอคิวจ่ายยาจำนวน ' + count_data + ' คน',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        })
    }
    $(document).ready(function() {
        $('#drugTab').DataTable({
            columnDefs: [{
                    "targets": 0, // your case first column
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "className": "text-center",
                },
                {
                    "targets": 2,
                    "className": "text-center",
                }
            ]
        });
        $("#showdoneDetail").on("show.bs.modal", function(e) {

            $("#drugTab").DataTable().clear().draw();
            var patientid = $(e.relatedTarget).data('patientid');
            $('#patientid').val(patientid);
            var idDrug = [];
            var amountDrug = [];

            var _token = $('input[name="_token"').val();
            $.ajax({
                url: "{{route('fetchBoneDrugdoneDetail')}}",
                method: "POST",
                data: {
                    patientid: patientid,
                    _token: _token
                },
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    $('input[name="patient_name"]').val(result.data.name);
                    $('input[name="nextDateInModal"]').val(result.data.next_check);
                    $('input[name="grandtotal"]').val(result.data.grandtotal);
                    $.each(result.data.orders_detail, function(i, item) {
                        $("#drugTab").DataTable().row.add([
                            i + 1,
                            item.dname.drug_name,
                            item.amount
                        ]).draw();
                        idDrug[i] = item.drug_id;
                        amountDrug[i] = item.amount;
                        $("input[name='drug_id']").val(idDrug);
                        $('input[name="drug_qty"]').val(amountDrug);
                    });
                    $('input[name="order_id"]').val(result.data.orders_detail[0].order_id);
                }
            })
            $("#drugTab_info").hide();
            $("#drugTab_filter").hide();
            $("#drugTab_paginate").hide();
            $("#drugTab_length").hide();
            $(".dataTables_length").hide();
        });
    });

    function dispenseBoneSwal() {
        Swal.fire({
            title: 'คุณต้องการจ่ายยาใช่หรือไม่?',
            icon: 'warning',
            showLoaderOnConfirm: true,
            confirmButtonText: 'ตกลง',
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก',
            preConfirm: () => {
                $('#form1').submit()
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {

            } else if (result.isDenied) {
                Swal.fire('จ่ายยาไม่สำเร็จ', '', 'info')
            }
        });
    }
    $('#genStockId').on('click', function() {
        var date = new Date();
        var components = [
            "ST-D-",
            date.getYear(),
            date.getMonth(),
            date.getDate(),
            date.getHours(),
            date.getMinutes(),
            date.getSeconds()
        ];

        var id = components.join("");
        $("#stock_id").val(id);
    });
</script>
@endsection