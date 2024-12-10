<div class="report-section">
    <h2>customers</h2>
    <div id="top-products-content">
        <!-- Form for filtering by date -->
        <form id="filterCustomers">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <hr>
        <!-- Table to display top customers products -->
        <div class="card" style="display: none;" id="top-customers">
            <div class="card-body">
                <table class="table mt-3" id="topCustomers">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">email</th>
                            <th scope="col">total orders</th>
                            <th scope="col">total spent</th>
                        </tr>
                    </thead>
                    <tbody id="top-customers-body">
                        <!-- Data will be populated here via Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // Handle the form submit event
    const topCustomersContainer = $('#top-customers')
    const topCustomersTbody = $('#top-customers-body')
    $('#filterCustomers').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // Send the Ajax request
        $.ajax({
            url: "{{ route('pos.reports.top_customers') }}",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            success: function(response) {
                topCustomersContainer.show();
                topCustomersTbody.empty();
                response.topCustomers.forEach((item, index) => {
                    topCustomersTbody.append(`
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.name}</td>
                            <td>${item.email} EGP</td>
                            <td>${item.total_orders}</td>
                            <td>${item.total_spent}</td>
                        </tr>
                    `);
                });
            },
            error: function(error) {
                toastr.error(error);
            }
        });
    });
</script>