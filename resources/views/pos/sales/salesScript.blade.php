<script type="text/javascript">
    $(document).ready(() => {
        if ('{{session("statuse")}}') {
            toastr.success("{{ Session::get('statuse') }}");
        }
        // display amount
        updateTotalAmount();

        // Search by name or barcode
        let searchInput = $('#productSearch')
        let productList = $('#product-list')
        searchInput.on("input", () => {
            let inputData = searchInput.val()
            $.ajax({
                url: '{{ route("pos.sales.searchProduct") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    product: inputData
                },
                success: (res) => {
                    if (searchInput.length <= 0 || searchInput.val() === '') {
                        productList.hide()
                    } else {
                        productList.html('')
                        res.forEach(element => {
                            productList.append(`<li class="productItem" data-id="${element.id}">${element.name}</li>`)
                            productList.show()
                        });
                    }
                }
            })
        })
        // ./Search by name or barcode



        // choose product from list
        $(document).on('click', '.productItem', function() {
            let productId = $(this).data('id');
            let productName = $(this).text();
            $.ajax({
                url: '{{route("pos.sales.addToSession")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    productName: productName,
                    productId: productId,
                },
                success: (res) => {
                    updateTable(res);
                    updateTotalAmount();
                    searchInput.val('')
                    productList.hide()
                },
            })
        })
        // ./choose product from list





        // change of quantity
        $(document).on('input', '.quantity-input', function() {
            let quantity = $(this).val();
            let product_id = $(this).data('id');

            if (quantity < 1) {
                quantity = 1;
            }

            $.ajax({
                url: '{{ route("pos.sales.updateQuantity") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    product_id: product_id,
                    quantity: quantity
                },
                success: (res) => {
                    updateTable(res);
                    updateTotalAmount();
                },
                error: (err) => {
                    toastr.error(err);
                }
            });
        });
        // ./change of quantity




        // updateTable
        function updateTable(data) {
            let totalAmount = 0;
            $('#productData').empty(); // تفريغ الجدول قبل إضافة البيانات
            if (data.length === 0) {
                $('#productData').append(`
                <tr>
                    <td colspan="7" class="text-center">No products added yet</td>
                </tr>
            `);
            } else {
                data.forEach((item, index) => {
                    $('#productData').append(`
                    <tr class="data">
                        <td scope="col">${index + 1}</td>
                        <td scope="col">${item.product_name}</td>
                        <td scope="col">${item.product_description}</td>
                        <td scope="col">${item.product_price}</td>
                        <td scope="col">${item.product_barcode}</td>
                        <td scope="col"><input type="number" min="1" value="${item.quantity}" data-id="${item.product_id}" class="form-control quantity-input sales"></td>
                        <td><button data-id="${item.product_id}" class="delete-item btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></td>
                    </tr>
                `);
                });
            }
        }
        // ./updateTable



        // delete item from session
        $(document).on('click', '.delete-item', function() {
            let productId = $(this).data('id')
            $.ajax({
                url: '{{route("pos.sales.removeItemSession")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    productId: productId,
                },
                success: (res) => {
                    updateTable(res);
                    updateTotalAmount();
                },
                error: (err) => {
                    toastr.error(err);
                }
            })
        })
        // ./delete item from session





        // get total
        function updateTotalAmount() {
            let totalAmount = 0;

            if ($('.data').length < 1) {
                $('#total-amount').text('0.00');
            } else {
                $('#productData tr').each(function() {
                    let quantity = $(this).find('.quantity-input').val();
                    let price = parseFloat($(this).find('td:nth-child(4)').text());
                    totalAmount += quantity * price;
                });

                $('#total-amount').text(totalAmount.toFixed(2));
            }
        }

        // ./get total






        // Customer Search by name
        let CustomersearchInput = $('#customerSearch')
        let CustomerList = $('#customer-list')
        CustomersearchInput.on('input', () => {
            let inputData = CustomersearchInput.val()
            $.ajax({
                url: '{{ route("pos.customer.search") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    customer: inputData
                },
                success: (res) => {
                    if (CustomersearchInput.length <= 0 || CustomersearchInput.val() === '') {
                        CustomerList.hide()
                    } else {
                        CustomerList.html('')
                        res.forEach(element => {
                            CustomerList.append(`<li class="customerItem" data-id="${element.id}">${element.email}</li>`)
                            CustomerList.show()
                        });
                    }
                }
            })
        })
        // ./Customer Search by name




        // choose customer from list
        $(document).on('click', '.customerItem', function() {
            let customerId = $(this).data('id');
            let customerName = $(this).text();

            CustomersearchInput.val(customerName);

            CustomerList.hide()
        })
        // ./choose customer from list








        // check out
        $('#check-out').click(function() {
            $.ajax({
                url: '{{ route("pos.sales.checkout") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    total_amount: $('#total-amount').text(),
                    customer_email: $('#customerSearch').val(),
                    payment_method: $('#payment-method').val()
                },
                success: function(response) {
                    updateTable([]);
                    updateTotalAmount()
                    $('#customerSearch').val('')
                    toastr.success('Order placed successfully!');
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.error) {
                        toastr.error(error.responseJSON.error);
                    } else {
                        toastr.error('Error occurred while placing the order');
                    }
                }
            });
        });
        // ./check out
    })
</script>