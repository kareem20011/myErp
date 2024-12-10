<div class="report-section">
    <h2>Sales Report</h2>
    <div id="sales-report-content">
        <div class="container-fluid mt-5">

            <div class="row g-3 align-items-end mb-3">
                <div class="col-auto">
                    <label for="status">Order Status:</label>
                </div>
                <div class="col-auto">
                    <select id="status" class="form-control" style="width: 150px;">
                        <option value="completed" selected>completed</option>
                        <option value="cancelled">cancelled</option>
                    </select>
                </div>
            </div>


            <div class="row g-3 align-items-end mb-3">
                <div class="col-auto">
                    <label for="report_type">Report Type:</label>
                </div>
                <div class="col-auto">
                    <select id="report_type" class="form-control" style="width: 150px;">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                <div class="col-auto row g-3 align-items-end" style="display: none;" id="year-container">
                    <div class="col-auto">
                        <label for="year">Year:</label>
                    </div>
                    <div class="col-auto" id="year-filter">
                        <select id="year" class="form-control">
                            @for ($i = date('Y'); $i >= 2022; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

            </div>

            <div>
                <button id="generate_report" class="btn btn-primary">Generate Report</button>
            </div>
            <hr>

            <div class="card mt-3">
                <div class="card-body" id="report_content" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('change', '#report_type', function() {
        const report_type = $(this).val();
        if (report_type === 'yearly') {
            $('#year-container').show();
        } else {
            $('#year-container').hide();
        }
    });

    $(document).on('click', '#generate_report', function() {
        let reportType = $('#report_type').find(":selected").val();
        let year = $('#year').find(":selected").val();
        let status = $('#status').find(":selected").val();
        $.ajax({
            url: '{{ route("pos.reports.sales_reports") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                type: reportType,
                year: year,
                status: status,
            },
            success: function(res) {
                $('#report_content').show();
                $('#report_content').html(res);
            },
            error: function(err) {
                toastr.error(err);
            }
        });
    });
</script>