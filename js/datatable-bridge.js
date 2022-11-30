import 'datatables.net-dt';
import 'datatables.net-fixedcolumns-dt';

jQuery(document).ready(($) => {  


    if($('.highlight-table').length) {
        var table = $('.highlight-table').DataTable({
            scrollX:        true,
            searching: false,
            paging:         false,
            info: false,
            ordering: false,
            fixedColumns:   {
                left: 1,
            }
        });
        $('.highlight-table .column-1').last().addClass('last');
    }
});