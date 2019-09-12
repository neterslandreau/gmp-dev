<div class="container">

    <div id="item-list-details-holder" class="row d-none">

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="total-records-holder">
                        <h4 class="text-muted">Total Items: <span id="total_records"></span></h4>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="item-list-search-holder">
                        <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Items" />
                    </div>

                </div>
            </div>

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
