<div class="container">

    <div class="row">


        <div id="total-records-holder" class="col-4 d-none" style="height: 20px;">
            <h3>Total Items: <span id="total_records"></span></h3>
        </div>

        <div class="col-4 form-group pt-3">
            <input type="text" name="search" id="item_list_search" class="form-control d-none" placeholder="Search Items" />
        </div>

    </div>
    <div class="row>">
            <table class="table table-bordered table-sm table-condensed table-striped table-hover items-table" id="item-table">
                <thead>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
    </div>

</div>
<div id="item-modals">
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach
</div>
