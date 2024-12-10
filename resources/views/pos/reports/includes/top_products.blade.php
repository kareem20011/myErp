<div class="report-section">
    <h2>Top Selling Products</h2>
    <div id="top-products-content">
        <!-- Form for filtering by date -->
        <form id="filterForm">
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
        <!-- Table to display top selling products -->
        <div class="card" style="display: none;" id="top-products-container">
            <div class="card-body">
                <table class="table mt-3" id="topSellingTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">price</th>
                            <th scope="col">total quantity</th>
                            <th scope="col">total sales amount</th>
                        </tr>
                    </thead>
                    <tbody id="top-selling">
                        <!-- Data will be populated here via Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // Handle the form submit event
    const topProductsContainer = $('#top-products-container')
    const topSellingTbody = $('#top-selling')
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // Send the Ajax request
        $.ajax({
            url: "{{ route('pos.reports.top_selling') }}",
            type: "post",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            success: function(response) {
                topProductsContainer.show();
                topSellingTbody.empty();
                response.topSellingProducts.forEach((item, index) => {
                    topSellingTbody.append(`
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${item.name}</td>
                            <td>${item.price} EGP</td>
                            <td>${item.total_quantity}</td>
                            <td>${item.total_sales_amount} EGP</td>
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