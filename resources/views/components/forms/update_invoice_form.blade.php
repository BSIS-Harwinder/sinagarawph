@csrf
@method('PATCH')
{{-- 15 means updating invoice --}}
<input type="hidden" name="action_id" value="15">
<input type="hidden" name="sale_id" value="{{ $data['invoice']->sale_id }}">
<div class="modal-body">
    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="number" min="0" class="form-control" id="amount" name="amount" placeholder="100000" value="{{ $data['invoice']->amount }}">
    </div>
    <div class="form-group">
        <label for="transaction_type">Transaction Type</label>
        <select id="transaction_type" name="transaction_type" class="custom-select">
            <option value>Select Transaction Type</option>
            <option value="cash" {{ $data['invoice']->transaction_type == 'cash' ? 'selected' : '' }}>Cash Payment</option>
            <option value="online" {{ $data['invoice']->transaction_type == 'online' ? 'selected' : '' }}>Online Payment</option>
        </select>
    </div>
    <div class="custom-file my-3">
        <input type="file" class="custom-file-input" name="image" id="proof_of_payment" required>
        <label class="custom-file-label" for="proof_of_payment">Choose file...</label>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Update changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
