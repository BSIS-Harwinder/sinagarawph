<form id="schedule-form" action="{{ route('view.engineer.schedule') }}" method="GET">
    @csrf
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="from">Select Start Date</label>
                <input type="date" class="form-control" id="from" name="from">
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="to">Select End</label>
                <input type="date" class="form-control" id="to" name="to">
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-4 text-center">
            <button type="submit" class="btn btn-secondary">Filter</button>
        </div>
    </div>
</form>
