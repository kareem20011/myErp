<!--  create customer Modal -->
<div class="modal fade" id="customer" tabindex="-1" role="dialog" aria-labelledby="customerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pos.customer.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="customerLabel">New customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter phone">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  ./create customer Modal -->