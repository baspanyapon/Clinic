@extends('layouts.app')

@section('content')
<style>
    .dataTables_paginate {
        float: right;
        margin-right: 20px;
    }
    .dataTables_info {
    float: left;
    margin-left: 25px;
  }
</style>
<div class="header bg-gradient-pinkblue pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">จำนวนผู้ใช้</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$data['countusers']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span> -->
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">จำนวนคนไข้ทั้งหมด</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$data['countpatient']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                                <span class="text-nowrap">Since last week</span> -->
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">จำนวนคนไข้วันนี้</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$data['countpatientnow']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fa-solid fa-users-line"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <!-- <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span class="text-nowrap">Since yesterday</span> -->
                            </p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                                    <span class="h2 font-weight-bold mb-0">49,65%</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<div class="row mt-12">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Stock Logs</h3>
                    </div>
                    <!-- <div class="col text-right">
                        <a href="#!" class="btn btn-sm btn-primary">See all</a>
                    </div> -->
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush sTab">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort text-center" data-sort="id">ลำดับ</th>
                            <th scope="col" class="sort text-center" data-sort="stock_id">รหัสสต๊อก</th>
                            <th scope="col" class="sort text-center" data-sort="status">สถานะ</th>
                            <th scope="col" class="sort text-center" data-sort="created_at">วันที่</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach($data['stocklog'] as $row)
                        <tr>
                            <td class="text-center">
                                {{$loop->index+1}}
                            </td>
                            <td class="text-center">
                                <a href="#" data-target="#showdetailStock" data-toggle="modal" data-stockid="{{ $row -> stock_id }}" data-status="{{ $row -> status }}" data-datestock="<?php echo date_format($row->created_at,"Y-m-d");?>">{{$row -> stock_id}}</a>
                            </td>
                            <td class="text-center">
                                <?php if ($row->status == 1) {
                                    echo "เพิ่มยา";
                                } else {
                                    echo "จ่ายยา";
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                echo date_format($row->created_at,"Y-m-d");
                                ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showdetailStock" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดสต๊อกยา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form1" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> รหัสสต๊อก </label>
                            <input type="text" name="stockid" id="stockid" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label> สถานะ </label>
                            <input type="text" name="status" id="status" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6" id="pname">
                            <label> ชื่อคนไข้</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label> วันที่</label>
                            <input type="text" name="date_stock" id="date_stock" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <label> รายละเอียด </label>
                    <div class="table-responsive">
                        <table id="StockTab" class="table table-bordered table-sm align-items-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort text-center" style="width: 10%">ลำดับ</th>
                                    <th scope="col" class="sort text-center" style="width: 60%">รหัสยา</th>
                                    <th scope="col" class="sort text-center" style="width: 10%">จำนวนเดิม</th>
                                    <th scope="col" class="sort text-center" style="width: 10%">จำนวน</th>
                                    <th scope="col" class="sort text-center" style="width: 10%">รวม</th>
                                </tr>
                            </thead>
                            <tbody class="list">

                            </tbody>
                        </table>
                        <input type="hidden" id="drug_id" name="drug_id">
                        <input type="hidden" id="drug_qty" name="drug_qty">
                    </div>
                </div>
                <div class="modal-footer">
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
    $(document).ready(function() {

        $(document).ready(function() {
            $(".sTab").DataTable({
                columnDefs: [{
                    defaultContent: "-",
                    targets: "_all",
                }, ],
                language: {
                    paginate: {
                        previous: "<",
                        next: ">",
                    },
                },
                lengthMenu: [10, 20, 50, 100],
                oLanguage: {
                    sSearch: "ค้นหา : ",
                    sLengthMenu: " แสดง _MENU_ รายการ/หน้า",
                    sInfo: "รายการที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    sInfoFiltered: "",
                    sZeroRecords: "ไม่พบข้อมูลในตาราง",
                    sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
                },
            });
            // $(".dataTables_info").hide();
            $(".dataTables_filter").hide();
            // $(".dataTables_paginate").hide();
            $(".dataTables_length").hide();
        });
        $('#StockTab').DataTable({
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
                },
                {
                    "targets": 3,
                    "className": "text-center",
                },
                {
                    "targets": 4,
                    "className": "text-center",
                }
            ]
        });
        $("#showdetailStock").on("show.bs.modal", function(e) {
            $("#StockTab").DataTable().clear().draw();
            var stockid = $(e.relatedTarget).data('stockid');
            var status = $(e.relatedTarget).data('status');
            var datestock = $(e.relatedTarget).data('datestock');
            $('#stockid').val(stockid);
            if (status == 1) {
                var status1 = "เพิ่มยา";
                $("#pname").prop('hidden', true);
            } else {
                var status1 = "จ่ายยา";
                $("#pname").prop('hidden', false);
            }
            $('#status').val(status1);
            $('#date_stock').val(datestock);
            // var idDrug = [];
            // var amountDrug = [];
            var _token = $('input[name="_token"').val();
            $.ajax({
                url: "{{route('fetchStockDetail')}}",
                method: "POST",
                data: {
                    stockid: stockid,
                    _token: _token
                },
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    // $('input[name="patient_name"]').val(result.data.name);
                    // $('input[name="nextDateInModal"]').val(result.data.next_check);
                    $('input[name="patient_name"]').val("");
                    $.each(result.data.order, function(i, item) {
                        $('input[name="patient_name"]').val(item.pname.name);
                    });
                    $.each(result.data.stocks_detail, function(i, item) {
                        $("#StockTab").DataTable().row.add([
                            i + 1,
                            item.drug_id,
                            item.amount_old,
                            item.amount,
                            item.amount_total
                        ]).draw();
                        // idDrug[i] = item.drug_id;
                        // amountDrug[i] = item.amount;
                        // $("input[name='drug_id']").val(idDrug);  
                    });
                }
            })
            $("#StockTab_info").hide();
            $("#StockTab_filter").hide();
            $("#StockTab_paginate").hide();
            $("#StockTab_length").hide();

        });
    });
</script>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush